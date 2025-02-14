<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Note;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user) {
            // Create random notes for each user
            for ($i = 0; $i < 5; $i++) {
                Note::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence,
                    'content' => $faker->paragraphs(3, true),
                    'is_pinned' => $faker->boolean(20),
                ]);
            }
        }
    }
}
