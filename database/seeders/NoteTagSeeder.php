<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class NoteTagSeeder extends Seeder
{
    public function run()
    {
        // Get all notes and tags
        $notes = Note::all();
        $tags = Tag::all();

        // Ensure we have some notes and tags
        if ($notes->isEmpty() || $tags->isEmpty()) {
            $this->command->warn('No notes or tags found. Seeding skipped.');
            return;
        }

        // Assign random tags to notes
        foreach ($notes as $note) {
            // Assign 1 to 3 random tags per note
            $randomTags = $tags->random(rand(1, 3))->pluck('id');

            foreach ($randomTags as $tagId) {
                DB::table('note_tag')->insert([
                    'note_id' => $note->id,
                    'tag_id' => $tagId,
                ]);
            }
        }

        $this->command->info('✅ note_tag relationships seeded successfully.');
    }
}
