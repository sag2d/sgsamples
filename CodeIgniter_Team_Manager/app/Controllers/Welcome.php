<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    /**
     * Index
     *
     * This method loads the Team Manager welcome page.
     *
     * @access public
     */
    public function index(): string
    {
        return $this->render('welcome_message');
    }
}
