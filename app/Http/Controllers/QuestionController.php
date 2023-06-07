<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('question.index', [
            'questions' => user()->questions,
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'question' => [
                'required',
                'min:10',
                'string',
                new EndWithQuestionMarkRule(),
            ],
        ]);

        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return back();
    }

    public function edit(Question $question): \Illuminate\Contracts\View\View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate([
            'question' => [
                'required',
                'min:10',
                'string',
                new EndWithQuestionMarkRule(),
            ],
        ]);

        $question->question = request()->question;
        $question->save();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('delete', $question);
        $question->delete();

        return back();
    }
}
