<?php

namespace Tests\Feature;

use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CustomerSeeder::class);
    }

    public function test_customers_are_fetched_successfully()
    {
        $response = $this->get('/api/customers');

        $response->assertStatus(200);
        $json = $response->json();
        $this->assertNotEmpty($json['data']);
    }

    public function test_customers_pagination_works()
    {
        $response = $this->get('/api/customers?page=2');

        $response->assertStatus(200);
        $json = $response->json();
        $this->assertNotEmpty($json['data']);
    }

    public function test_customers_pagination_works_empty_page()
    {
        $response = $this->get('/api/customers?page=20');

        $response->assertStatus(200);
        $json = $response->json();
        $this->assertEmpty($json['data']);
    }

    public function test_single_customer_fetched_successfully()
    {
        $response = $this->get('/api/customers/1');

        $response->assertStatus(200);
    }

    public function test_single_customer_fetch_fails()
    {
        $response = $this->get('/api/customers/1500');

        $response->assertStatus(404);
    }
}
