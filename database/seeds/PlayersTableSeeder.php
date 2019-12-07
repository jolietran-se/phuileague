<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 20; $i++) {
            DB::table('players')->insert([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'club_id' => 6,
                'uniform_number' => $faker->randomDigit,
                'uniform_name' => $faker->name,
                'position' => $faker->numberBetween($min = 1, $max = 5),
                'role' => $faker->numberBetween($min = 1, $max = 7),
                'birthday' => $faker->date($format = 'm/d/Y', $max = 'now'),
                'ismain' => $faker->numberBetween($min = 1, $max = 2),
            ]);
        }
    }
}
