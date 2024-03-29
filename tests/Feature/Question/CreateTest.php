<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post, postJson};

test('only authenticated users can create a question', function () {
    // Act::agir
    post(route('question.store'))->assertRedirect(route('login'));
    assertDatabaseCount('questions', 0);
});

it('should be able to create a new question bigger than 255 characters', function () {
    // Arrange::preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act::agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 256) . '?',
    ]);

    // Assert::verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 256) . '?']);
});

it('should create as draft all the time', function () {
    // Arrange::preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act::agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 256) . '?',
    ]);

    // Assert::verificar
    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 256) . '?', 'draft' => true]);
});

it('should check if ends with question mark ?', function () {
    // Arrange::preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act::agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 256),
    ]);

    // Assert::verificar
    $request->assertSessionHasErrors(['question' => 'Are you sure that is a question? It is missing the end mark.']);
    assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters', function () {
    // Arrange::preparar
    $user = User::factory()->create();
    actingAs($user);

    // Act::agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assert::verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('question should be unique', function () {
    // Arrange::preparar
    $user     = User::factory()->create();
    $question = $user->questions()->create([
        'question' => 'Same question?',
    ]);
    actingAs($user);
    post(route('question.store'), [
        'question' => 'Same question?',
    ])->assertSessionHasErrors(['question' => 'This question already exists.']);
});
