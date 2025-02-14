<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Note;
use Faker\Factory as Faker;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $notes = Note::all();

        foreach ($notes as $note) {
            // Each note can have 1-3 documents
            for ($i = 0; $i < rand(1, 3); $i++) {
                Document::create([
                    'note_id' => $note->id,
                    'filename' => $faker->word . '.pdf',
                    'file_path' => 'documents/' . $faker->uuid . '.pdf',
                    'file_type' => 'application/pdf',
                    'extracted_text' => $faker->paragraphs(5, true),
                ]);
            }
        }
    }
}
