<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    /**
     * https://laravel.com/docs/10.x/authorization#creating-policies
     */
    public function publish(User $user, Question $question): bool
    {
        return $question->createdBy->is($user);
    }
}
