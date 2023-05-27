<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;

it('should be able to list all questions created by me', function () {
    $user      = User::factory()->create();
    $wrongUser = User::factory()->create();

    $questions = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    $response = actingAs($user)->get(route('question.index'));

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

    actingAs($wrongUser)
        ->get(route('question.index'))
        ->assertDontSee($questions->first()->question);
});
