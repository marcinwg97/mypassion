<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => "Dom i ogród",
                'icon' => "fa-home",
            ],
            [
                'name' => "Gry",
                'icon' => "fa-dice-six",
            ],
            [
                'name' => "Książki",
                'icon' => "fa-book-reader",
            ],
            [
                'name' => "Muzyka",
                'icon' => "fa-music",
            ],
            [
                'name' => "Sport",
                'icon' => "fa-running",
            ],
            [
                'name' => "Sztuka",
                'icon' => "fa-university",
            ],
            [
                'name' => "Zdrowie i uroda",
                'icon' => "fa-heart",
            ],
            [
                'name' => "Zwierzęta",
                'icon' => "fa-paw",
            ]
        ]);
    }
}
