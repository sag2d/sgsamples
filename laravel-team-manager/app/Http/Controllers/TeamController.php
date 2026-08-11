<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Contracts\View\View;

/**
 * Team Controller for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class TeamController extends Controller
{
    /**
     * Display a listing of all teams.
     *
     * Retrieves all teams ordered by name and displays them on the teams index page.
     * Results are paginated for better performance with large datasets.
     * Supports filtering by team name via the 'search' query parameter.
     */
    public function index(): View
    {
        $perPage = 10; // Number of teams to display per page
        $searchName = request('search', '');

        $teams = Team::when($searchName, function ($query) use ($searchName) {
            $query->where('name', 'like', '%'.$searchName.'%');
        })
            ->orderBy('name')
            ->paginate($perPage);

        return view('teams.index', ['teams' => $teams, 'searchName' => $searchName]);
    }

    /**
     * Display the specified team with its players.
     *
     * Shows team details along with all players associated with the team,
     * ordered by name. Uses implicit route model binding.
     */
    public function show(Team $team): View
    {
        $league = $team->league; // Get the parent league of the team
        $players = $team->players()->active()->orderBy('first_name')->get();

        return view('teams.show', ['team' => $team, 'league' => $league, 'players' => $players]);
    }
}
