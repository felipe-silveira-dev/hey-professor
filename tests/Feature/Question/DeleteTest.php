<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;

it('should be able to destroy a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id]);
    //Act
    actingAs($user)
        ->delete(route('question.destroy', $question))
        ->assertRedirect();

    //Assert
    expect(Question::count())->toBe(0);
});

it('should make sure only the author can delete a question', function () {
    //Arrange
    $userOwner    = User::factory()->create();
    $userStranger = User::factory()->create();
    $question     = Question::factory()->create(['created_by' => $userOwner->id]);
    //Act
    actingAs($userStranger)
        ->delete(route('question.destroy', $question))
        ->assertForbidden();
    expect(Question::count())->toBe(1);

    actingAs($userOwner)
        ->delete(route('question.destroy', $question))
        ->assertRedirect();
    expect(Question::count())->toBe(0);

    //Assert
});
