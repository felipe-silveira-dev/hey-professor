<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted, assertSoftDeleted};

it('should be able to archive a question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->create(['created_by' => $user->id]);

    //Act
    actingAs($user)
        ->patch(route('question.archive', $question))
        ->assertRedirect();

    //Assert
    assertSoftDeleted('questions', ['id' => $question->id]);
    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

it('should make sure only the author can archive a question', function () {
    //Arrange
    $userOwner    = User::factory()->create();
    $userStranger = User::factory()->create();
    $question     = Question::factory()->create(['created_by' => $userOwner->id]);
    //Act
    actingAs($userStranger)
        ->patch(route('question.archive', $question))
        ->assertForbidden();
    expect(Question::count())->toBe(1);

    actingAs($userOwner)
        ->patch(route('question.archive', $question))
        ->assertRedirect();
    expect(Question::count())->toBe(0);
});

it('should be able to restore an archived question', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true, 'deleted_at' => now()]);

    //Act
    actingAs($user)
        ->patch(route('question.restore', $question))
        ->assertRedirect();

    //Assert
    assertNotSoftDeleted('questions', ['id' => $question->id]);
    expect($question)
        ->refresh()
        ->deleted_at->toBeNull();
});
