<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $uniqueNames = [];

        // Generate 10 unique tags
        while (count($uniqueNames) < 10) {
            $name = $faker->unique()->word;
            if (!in_array($name, $uniqueNames)) {
                $uniqueNames[] = $name;
                Tag::create([
                    'name' => $name,
                ]);
            }
        }
    }
}
