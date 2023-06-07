<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

it('should be able to update a question', function () {
    $user     = User::factory()->create();
    $question = $user->questions()->create([
        'question' => 'This is a question?',
        'draft'    => true,
    ]);

    actingAs($user)
        ->put(route('question.update', $question), [
            'question' => 'This is a updated question?',
        ])
        ->assertRedirect();

    expect($question->fresh()->question)->toBe('This is a updated question?');
});
