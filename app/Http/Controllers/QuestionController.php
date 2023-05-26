<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                'string',
                new EndWithQuestionMarkRule(),
            ],
        ]);

        Question::query()->create([
            'question' => $attributes['question'],
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }
}
