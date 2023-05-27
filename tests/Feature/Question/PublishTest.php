<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;

it('should be able to publish a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true]);
    //Act
    actingAs($user)
        ->put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();
    //Assert
    expect($question->draft)->toBeFalse();

})->only();
