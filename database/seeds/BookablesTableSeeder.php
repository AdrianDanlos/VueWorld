<?php

use App\Bookable;
use Illuminate\Database\Seeder;

class BookablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://restcountries.eu/rest/v2/all?fields=name;capital;');


        $countries = json_decode($response->getBody());

        foreach ($countries as $country) {
            factory(App\Bookable::class, 30)->create(['country' => $country->name, 'city' => $country->capital]);
        }
    }
}
