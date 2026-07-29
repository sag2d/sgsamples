<?php

namespace App\Controllers;

/**
 * Welcome Controller for the frontend of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class Welcome extends BaseController
{
    /**
     * Index
     *
     * This method loads the Team Manager welcome page.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('welcome_message');
    }
}
