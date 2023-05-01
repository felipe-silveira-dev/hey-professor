<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        // $question = new Question();
        // $question->question = request()->question;
        // $question->save();

        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (substr($value, -1) != '?') {
                        $fail('Are you sure taht is a question? It is missing the end mark.');
                    }
                },
            ],
        ]);

        Question::query()->create($attributes);

        return to_route('dashboard');
    }
}
