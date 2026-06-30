<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['form', 'url', 'state'];

    /**
     * Initialize Controller
     *
     * This method initializes shared services used by Team Manager controllers.
     *
     * @access public
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);

        if (! ($request instanceof CLIRequest)) {
            service('session');
        }
    }

    /**
     * Render
     *
     * This method wraps a view with the shared Team Manager header and footer.
     *
     * @access protected
     * @param string $view
     * @param array $data
     * @return string
     */
    protected function render(string $view, array $data = []): string
    {
        return view('header')
            . view($view, $data)
            . view('footer');
    }
}
