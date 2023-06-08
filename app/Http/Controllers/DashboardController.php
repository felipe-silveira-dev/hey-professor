<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    // public function __invoke(): \Illuminate\Contracts\View\View
    // {
    //     return view('dashboard', [
    //         'questions' => Question::withSum('votes', 'like')
    //                 ->withSum('votes', 'unlike')
    //                 // if(votes_sum_like is null, 0, votes_sum_like) desc,
    //                 // if(votes_sum_unlike is null, 0, votes_sum_unlike)
    //                 ->orderByRaw('case when votes_sum_like is null then 0 else 1 end desc, case when votes_sum_unlike is null then 0 else 1 end')
    //                 ->paginate(5),
    //     ]);

    public function __invoke(): View
    {
        return view('dashboard', [
            'questions' => Question::query()
                ->withSum('votes', 'like')
                ->withSum('votes', 'unlike')
                ->orderByRaw('
                    case when votes_sum_like is null then 0 else votes_sum_like end desc,
                    case when votes_sum_unlike is null then 0 else votes_sum_unlike end
                ')
                ->paginate(5),
        ]);
    }
}
