<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PlayerModel;
use App\Models\TeamModel;

/**
 * Player Controller for the admin section of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class Player extends BaseController
{
    private PlayerModel $player;
    private TeamModel $team;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->player = new PlayerModel();
        $this->team = new TeamModel();
    }

    /**
     * Index
     *
     * This method loads the view to display the player management listing.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('admin/player/index', [
            'players' => $this->player->getPlayers(),
            'teams' => $this->team->getTeamOptions(false),
        ]);
    }

    /**
     * Edit
     *
     * This method loads a player record to allow user to add a new player, or edit details for an existing player.
     *
     * @access public
     * @param int|null $id
     * @return string
     */
    public function edit(?int $id = null): string
    {
        return $this->render('admin/player/edit', [
            'player' => $this->player->getOnePlayer($id),
            'states' => get_states(),
            'teams' => $this->team->getTeamOptions(),
            'errors' => [],
        ]);
    }

    /**
     * Save
     *
     * This method saves a player record.
     * If the player does not yet exist, a new player is inserted.
     * If the player does already exists, the existing player is updated.
     *
     * @access public
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function save()
    {
        $rules = [
            'first_name' => ['label' => 'First Name', 'rules' => 'required'],
            'last_name' => ['label' => 'Last Name', 'rules' => 'required'],
            'team_id' => ['label' => 'Team', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
        ];

        if (!$this->validate($rules)) {
            return $this->render('admin/player/edit', [
                'player' => (object) $this->request->getPost(),
                'states' => get_states(),
                'teams' => $this->team->getTeamOptions(),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $id = $this->request->getPost('id');
        $fields = array('first_name', 'last_name', 'team_id', 'address', 'city', 'state_id', 'zip', 'email', 'phone');
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->request->getPost($field);
        }
       
        $result = $id ? $this->player->update($id, $data) : $this->player->insert($data);

        if ($result !== false) {
            session()->setFlashdata('message', 'Player saved successfully!');
        } else {
            session()->setFlashdata('error', 'Error saving player. Please try again.');
        }

        return redirect()->to('/admin/player/index');
    }

    /**
     * Delete
     *
     * This method deletes a player record from the database.
     *
     * @access public
     * @param int|null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(?int $id = null)
    {
        $result = $id ? $this->player->delete($id) : false;

        if ($result !== false) {
            session()->setFlashdata('message', 'Player deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Error deleting player. Please try again.');
        }

        return redirect()->to('/admin/player/index');
    }
}
