<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LeagueModel;

/**
 * League Controller for the admin section of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class League extends BaseController
{
    private LeagueModel $league;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->league = new LeagueModel();
    }

    /**
     * Index
     *
     * This method loads the view to display the league management listing.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('admin/league/index', [
            'leagues' => $this->league->getLeagues(),
        ]);
    }

    /**
     * Edit
     *
     * This method loads a league record to allow user to add a new league, or edit details for an existing league.
     *
     * @access public
     * @param int|null $id
     * @return string
     */
    public function edit(?int $id = null): string
    {
        return $this->render('admin/league/edit', [
            'league' => $this->league->getOneLeague($id),
            'errors' => [],
        ]);
    }

    /**
     * Save
     *
     * This method saves a league record.
     * If the league does not yet exist, a new league is inserted.
     * If the league does already exists, the existing league is updated.
     *
     * @access public
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function save()
    {
        $rules = [
            'name' => ['label' => 'Name', 'rules' => 'required']
        ];

        if (!$this->validate($rules)) {
        $league = (object) $this->request->getPost();
        $league->id = $league->id ?? null;

            return $this->render('admin/league/edit', [
                'league' => (object) $this->request->getPost(),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $id = $this->request->getPost('id');
        
        $fields = array('name');
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->request->getPost($field);
        }
        
        $result = $id ? $this->league->update($id, $data) : $this->league->insert($data);

        if ($result !== false) {
            session()->setFlashdata('message', 'League saved successfully!');
        } else {
            session()->setFlashdata('error', 'Error saving league. Please try again.');
        }

        return redirect()->to('/admin/league/index');
    }

    /**
     * Delete
     *
     * This method deletes a league record from the database.
     *
     * @access public
     * @param int|null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(?int $id = null)
    {
        $result = $id ? $this->league->delete($id) : false;

        if ($result !== false) {
            session()->setFlashdata('message', 'League deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Error deleting league. Please try again.');
        }

        return redirect()->to('/admin/league/index');
    }
}
