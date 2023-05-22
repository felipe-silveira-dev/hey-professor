<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to like a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    //Act
    actingAs($user)->post(route('question.like', $question->id))
        ->assertRedirect();

    //Assert
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to like twice', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    //Act
    actingAs($user)->post(route('question.like', $question->id));
    actingAs($user)->post(route('question.like', $question->id));
    actingAs($user)->post(route('question.like', $question->id));

    //Assert
    expect($user->votes()->where('question_id', $question->id)->count())->toBe(1);
    expect($user->votes()->count())->toBe(1);
});

it('should be able to unlike a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    //Act
    actingAs($user)->post(route('question.unlike', $question->id))
        ->assertRedirect();

    //Assert
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to unlike twice', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create();

    //Act
    actingAs($user)->post(route('question.unlike', $question->id));
    actingAs($user)->post(route('question.unlike', $question->id));
    actingAs($user)->post(route('question.unlike', $question->id));

    //Assert
    expect($user->votes()->where('question_id', $question->id)->count())->toBe(1);
    expect($user->votes()->count())->toBe(1);
});