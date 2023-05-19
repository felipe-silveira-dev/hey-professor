<?php

namespace App\Http\Controllers;

use App\Models\Question;

class DashboardController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View
    {
        return view('dashboard', [
            'questions' => Question::all(),
        ]);
    }
}
