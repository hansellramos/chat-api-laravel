<?php

use Illuminate\Database\Seeder;
use \Faker\Factory;
use \App\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::truncate();

        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Room::create([
                'name' => $faker->sentence,
                'description' => $faker->sentence,
            ]);
        }
    }
}
