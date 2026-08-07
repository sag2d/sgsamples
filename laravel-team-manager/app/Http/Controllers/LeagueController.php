<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Contracts\View\View;

class LeagueController extends Controller
{
    public function index(): View
    {
        return view('leagues.index', [
            'leagues' => League::query()->orderBy('name')->get(),
        ]);
    }
}
