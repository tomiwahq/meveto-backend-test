<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\LocationResolverService;
use Illuminate\Console\Command;

class ImportCustomersCommand extends Command
{

    public LocationResolverService $locationResolverService;

    public function __construct(LocationResolverService $locationResolverService)
    {
        parent::__construct();

        $this->locationResolverService = $locationResolverService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "customers:import";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import supplied customers into the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $open = fopen(storage_path('app/customers.csv'), 'r');
        $count = 0;

        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            if ($data[0] == "id") {
                continue;
            }
            [
                1 => $firstName,
                2 => $lastName,
                3 => $email,
                4 => $gender,
                5 => $company,
                6 => $city,
                7 => $title,
            ] = $data;
            $coords = $this->locationResolverService->getCityCoordinates($city);

            try {
                Customer::create([
                    "firstname" => $firstName,
                    "lastname" => $lastName,
                    "title" => $title,
                    "email" => $email,
                    "gender" => $gender,
                    "company" => $company,
                    "city" => $city,
                    "longitude" => $coords["lng"] ?? null,
                    "latitude" => $coords["lat"] ?? null,
                ]);
                $count++;
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
        $this->info(sprintf("A total number of %d customers were saved", $count));
        return self::SUCCESS;
    }
}
