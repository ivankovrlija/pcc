<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        //DB::table('guests')->delete();

        $this->call('GuestTableSeeder');

        $this->call([
            // UsersTableSeeder::class,
            // GuestTableSeeder::class,
        ]);
    }
}
