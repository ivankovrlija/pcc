<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\Guest;

use Illuminate\Support\Facades\DB;

 

class GuestTableSeeder extends Seeder

{

public function run()

{

DB::connection()->disableQueryLog();

$faker = Faker\Factory::create();
$this->call(GuestTableSeeder::class);

            }

}