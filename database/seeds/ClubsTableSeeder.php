<?php

use Illuminate\Database\Seeder;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i < 2; $i++) {
            $name = $faker->company;
            $slug = str_slug($name);
            DB::table('clubs')->insert([
                'name' => $name,
                'owner_id' => 2,
                'gender' => $faker->numberBetween($min = 0, $max = 1),
                'ages' => $faker->numberBetween($min = 1, $max = 6),
                'phone' => $faker->phoneNumber,
                'email' => $faker->freeEmail,
                'club_type' => $faker->numberBetween($min = 1, $max = 5),
                'slug' => $slug,
                'description' => $faker->text($maxNbChars = 200),
            ]);
        }
    }
}
