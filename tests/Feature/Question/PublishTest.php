<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;

it('should be able to publish a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);
    //Act
    actingAs($user)
        ->put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();
    //Assert
    expect($question->draft)->toBeFalse();

});

it('should make sure only the author can publish a question', function () {
    //Arrange
    $userOwner    = User::factory()->create();
    $userStranger = User::factory()->create();
    $question     = Question::factory()->create(['draft' => true, 'created_by' => $userOwner->id]);
    //Act
    actingAs($userStranger)
        ->put(route('question.publish', $question))
        ->assertForbidden();
    expect($question->draft)->toBeTrue();

    actingAs($userOwner)
        ->put(route('question.publish', $question))
        ->assertRedirect();
    $question->refresh();
    expect($question->draft)->toBeFalse();

    //Assert

});
