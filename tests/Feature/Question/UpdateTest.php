<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

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

it('should check if ends with question mark ?', function () {
    // Arrange::preparar
    $user     = User::factory()->create();
    $question = $user->questions()->create([
        'question' => 'This is a question?',
        'draft'    => true,
    ]);
    actingAs($user);

    // Act::agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 256),
    ]);

    // Assert::verificar
    $request->assertSessionHasErrors(['question' => 'Are you sure that is a question? It is missing the end mark.']);
    assertDatabaseHas('questions', ['question' => 'This is a question?']);
});

it('should have at least 10 characters', function () {
    // Arrange::preparar
    $user     = User::factory()->create();
    $question = $user->questions()->create([
        'question' => 'This is a question?',
        'draft'    => true,
    ]);
    actingAs($user);

    // Act::agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assert::verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseHas('questions', ['question' => 'This is a question?']);
});

test('only authenticated users can update a question', function () {
    put(route('question.update', ['question' => 'This is a new question?']))->assertRedirect(route('login'));
    assertDatabaseCount('questions', 0);
});

it('should be able to update a question bigger than 255 characters', function () {
    // Arrange::preparar
    $user     = User::factory()->create();
    $question = $user->questions()->create([
        'question' => 'This is a question?',
        'draft'    => true,
    ]);

    actingAs($user);

    // Act::agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 256) . '?',
    ]);

    // Assert::verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 256) . '?']);
});
