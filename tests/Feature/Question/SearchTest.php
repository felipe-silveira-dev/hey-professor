<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('it should be able to search a question by text', function () {
    //Arrange
    $user           = User::factory()->create();
    $questions      = Question::factory()->count(5)->create();
    $questionTarget = Question::factory()->create([
        'question' => 'This is the question that I want to search?',
    ]);

    //Act
    actingAs($user);
    $response = get(route('dashboard', ['search' => 'question']));

    //Assert
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertDontSee($q->question);
    }

    $response->assertSee($questionTarget->question);
});
