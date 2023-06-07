<?php

use App\Models\{Question, User};

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

it('should make sure that only questions with status DRAFT can be update', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => false]);
    $questionDraft = Question::factory()
    ->for($user, 'createdBy')
    ->create(['draft' => true]);

    actingAs($user)
        ->put(route('question.update', $questionNotDraft))
        ->assertForbidden();

    actingAs($user)
        ->put(route('question.update', $questionDraft), [
            'question' => 'This is a updated question?',
        ])
        ->assertRedirect();
    expect($questionDraft->fresh()->question)->toBe('This is a updated question?');
});

it('should make sure that question owner can update', function () {
    $user          = User::factory()->create();
    $questionOwner = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => true]);
    $questionNotOwner = Question::factory()->create(['draft' => true]);

    actingAs($user)
        ->put(route('question.update', $questionOwner), [
            'question' => 'This is a updated question?',
        ])
        ->assertRedirect();

    expect($questionOwner->fresh()->question)->toBe('This is a updated question?');

    actingAs($user)
        ->put(route('question.update', $questionNotOwner))
        ->assertForbidden();
});
