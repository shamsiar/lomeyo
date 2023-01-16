<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            [
                'name' => 'Bangladesh',
                'code' => 'bd',
                'status' => 1,
            ],
            [
                'name' => 'India',
                'code' => 'in',
                'status' => 0,
            ],
            [
                'name' => 'United States',
                'code' => 'us',
                'status' => 0,
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'uk',
                'status' => 0,
            ],
        ]);
    }
}
