<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Silveira Dev',
        //     'email' => 'silveira@dev.com'
        // ]);

        Question::factory()->count(120)->create();
    }
}
