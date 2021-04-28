<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Administrator",
            'email'  => "admin@mypassion.pl",
            'password' => bcrypt("Admin123!@#"),
        ]);
    }
}
