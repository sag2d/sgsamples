<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Contracts\View\View;

class PlayerController extends Controller
{
    /**
     * Display a listing of all players.
     *
     * Retrieves all players ordered by first name and displays them on the players index page.
     * Results are paginated for better performance with large datasets.
     * Supports filtering by player name via the 'search' query parameter.
     */
    public function index(): View
    {
        $perPage = 10; // Number of players to display per page
        $searchName = request('search', '');

        $players = Player::when($searchName, function ($query) use ($searchName) {
            $query->where('first_name', 'like', '%'.$searchName.'%')
                ->orWhere('last_name', 'like', '%'.$searchName.'%');
        })
            ->active()
            ->orderBy('first_name')
            ->paginate($perPage);

        return view('players.index', ['players' => $players, 'searchName' => $searchName]);
    }

    /**
     * Display the specified player with their details.
     *
     * Shows player details including team assignment and contact information.
     * Uses implicit route model binding.
     */
    public function show(Player $player): View
    {
        $team = $player->team;
        $state = $player->state;

        return view('players.show', ['player' => $player, 'team' => $team, 'state' => $state]);
    }
}
