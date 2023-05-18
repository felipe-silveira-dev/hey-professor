<?php

use App\Models\Question;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

todo('should be able to like a question', function () {
    //Arrange
    $user = User::factory()->create();
    $question = Question::factory()->create();

    //Act
    actingAs($user)->post(route('question.like', $question->id), [
        'vote' => 1,
    ]);

    //Assert
    // expect($question->fresh()->likes)->toBe(1);
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like' => 1,
        'unlike' => 0,
        'user_id' => $user->id,
    ]);
});
