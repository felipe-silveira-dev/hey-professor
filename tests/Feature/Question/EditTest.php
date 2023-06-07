<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;

it('should be able to open a question to edit', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => true]);

    actingAs($user)
        ->get(route('question.edit', $question))
        ->assertSuccessful();
});

it('should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => true]);

    actingAs($user)
        ->get(route('question.edit', $question))
        ->assertViewIs('question.edit');
});

it('should make sure that only questions with status DRAFT can be edit', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => false]);
    $questionDraft = Question::factory()
    ->for($user, 'createdBy')
    ->create(['draft' => true]);

    actingAs($user)
        ->get(route('question.edit', $questionNotDraft))
        ->assertForbidden();

    actingAs($user)
        ->get(route('question.edit', $questionDraft))
        ->assertSuccessful();
});

it('should make sure that question owner can edit', function () {
    $user          = User::factory()->create();
    $questionOwner = Question::factory()
                    ->for($user, 'createdBy')
                    ->create(['draft' => true]);
    $questionNotOwner = Question::factory()->create(['draft' => true]);

    actingAs($user)
        ->get(route('question.edit', $questionOwner))
        ->assertSuccessful();

    actingAs($user)
        ->get(route('question.edit', $questionNotOwner))
        ->assertForbidden();
});
