# Meveto Coding Test 

This is a coding test for Meveto. 
Built with Laravel

## How to use

### Requirements
* PHP >= 8
* Any RDBMS supported by Laravel (Tested on MariaDB 10)
* Google maps api key
* Redis (Optional)
* Docker (Optional)

### Installation
Simply clone this repo:
`git clone https://github.com/tomiwahq/meveto-backend-test.git`

`cd` into the cloned project

Create a `.env` file using the `.env.example` file supplied with this repo.
Fill in your credentials appropriately.

Create two additional environment variables:

```
GOOGLE_MAPS_API_URL=https://maps.googleapis.com/maps/api/geocode/json
GOOGLE_MAPS_API_KEY=your_google_maps_geocoding_api_key
```

Run `composer install`

Please note that if using docker, this project comes with Laravel Sail configured.
So prefix all commands with `./vendor/bin/sail`. E.g `./vendor/bin/sail php artisan migrate`

Run `php artisan migrate` to run the migrations

Place the `customers.csv` file in the `./storage/app/` directory

Run `php artisan customers:import` to import the customers.

Serve the application in your preferred way.

If using docker via Sail, run `./vendor/bin/sail up`

### Usage
To list all customers, visit https://your_app_url/api/customers
Please note the results are paginated.
Each page is limited to 50 results, to see results of other pages, simply append `?page=page_num` to the request URI

To see a single customer, visit https://your_app_url/api/customers/:customer_id
