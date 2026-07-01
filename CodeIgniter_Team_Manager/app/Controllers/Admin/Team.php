<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LeagueModel;
use App\Models\TeamModel;

/**
 * Team Controller for the admin section of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class Team extends BaseController
{
    private LeagueModel $league;
    private TeamModel $team;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->league = new LeagueModel();
        $this->team = new TeamModel();
    }

    /**
     * Index
     *
     * This method loads the view to display the team management listing.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('admin/team/index', [
            'teams' => $this->team->getTeams(),
            'leagues' => $this->league->getLeagueOptions(false),
        ]);
    }

    /**
     * Edit
     *
     * This method loads a team record to allow user to add a new team, or edit details for an existing team.
     *
     * @access public
     * @param int|null $id
     * @return string
     */
    public function edit(?int $id = null): string
    {
        return $this->render('admin/team/edit', [
            'team' => $this->team->getOneTeam($id),
            'leagues' => $this->league->getLeagueOptions(),
            'errors' => [],
        ]);
    }

    /**
     * Save
     *
     * This method saves a team record.
     * If the team does not yet exist, a new team is inserted.
     * If the team does already exists, the existing team is updated.
     *
     * @access public
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function save()
    {
        $rules = [
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'league_id' => ['label' => 'League', 'rules' => 'required'],
        ];

        if (!$this->validate($rules)) {
            return $this->render('admin/team/edit', [
                'team' => (object) $this->request->getPost(),
                'leagues' => $this->league->getLeagueOptions(),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $id = $this->request->getPost('id');
        $fields = array('name', 'league_id', 'mascot');
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->request->getPost($field);
        }
       
        $result = $id ? $this->team->update($id, $data) : $this->team->insert($data);

        if ($result !== false) {
            session()->setFlashdata('message', 'Team saved successfully!');
        } else {
            session()->setFlashdata('error', 'Error saving team. Please try again.');
        }

        return redirect()->to('/admin/team/index');
    }

    /**
     * Delete
     *
     * This method deletes a team record from the database.
     *
     * @access public
     * @param int|null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(?int $id = null)
    {
        $result = $id ? $this->team->delete($id) : false;

        if ($result !== false) {
            session()->setFlashdata('message', 'Team deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Error deleting team. Please try again.');
        }

        return redirect()->to('/admin/team/index');
    }
}
