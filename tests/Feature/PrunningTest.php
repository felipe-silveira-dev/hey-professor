<?php

use App\Models\{Question, User};

use function Pest\Laravel\{artisan, assertDatabaseMissing, assertSoftDeleted};

it('should prune questions deleted more than 1 month', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create([
        'created_by' => $user->id,
        'created_at' => now()->subMonths(3),
        'deleted_at' => now()->subMonths(2),
    ]);

    assertSoftDeleted('questions', [
        'id' => $question->id,
    ]);

    artisan('model:prune');

    assertDatabaseMissing('questions', [
        'id' => $question->id,
    ]);
});
