<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    //Arrange
    $user      = User::factory()->create();
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

it('should paginate the result', function () {
    //Arrange
    $user      = User::factory()->create();
    $questions = Question::factory()->count(20)->create();

    //Act
    actingAs($user);
    $response = get(route('dashboard'));

    //Assert
    $response->assertViewHas('questions', function ($value) {
        return $value instanceof \Illuminate\Pagination\LengthAwarePaginator
            && $value->total() === 20;
    });
});
