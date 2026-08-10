<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Contracts\View\View;

class LeagueController extends Controller
{
    /**
     * Display a listing of all leagues.
     *
     * Retrieves all leagues ordered by name and displays them on the leagues index page.
     * Results are paginated for better performance with large datasets.
     * Supports filtering by league name via the 'search' query parameter.
     */
    public function index(): View
    {
        $perPage = 10; // Number of leagues to display per page
        $searchName = request('search', '');

        $leagues = League::when($searchName, function ($query) use ($searchName) {
            $query->where('name', 'like', '%'.$searchName.'%');
        })
            ->orderBy('name')
            ->paginate($perPage);

        return view('leagues.index', ['leagues' => $leagues, 'searchName' => $searchName]);
    }

    /**
     * Display the specified league with its teams.
     *
     * Shows league details along with all teams associated with the league,
     * ordered by name. Uses implicit route model binding.
     */
    public function show(League $league): View
    {
        $teams = $league->teams()->orderBy('name')->get();

        return view('leagues.show', ['league' => $league, 'teams' => $teams]);
    }
}
