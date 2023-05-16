<?php

use App\Models\Question;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should list all the questions', function () {
    //Arrange
    $user = User::factory()->create();
    $questions = Question::factory()->count(5)->create();

    //Act
    actingAs($user);
    $response = get(route('dashboard'));

    //Assert
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
