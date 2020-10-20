<?php

namespace Admin\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;
use CodeIgniter\Security\Exceptions\SecurityException;

abstract class BaseController extends \CodeIgniter\Controller
{

    protected $session;

    protected $admin;

    protected $viewsNamespace = 'Admin';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = Services::session();

        $this->admin = adminAuth()->getUser();

        if (!$this->checkAuth())
        {
            throw SecurityException::forDisallowedAction();
        }
    }

    protected function checkAuth() : bool
    {
        return $this->admin ? true : false;
    }

    protected function render(string $view, array $params = [], array $options = [])
    {
        if (mb_strpos("\\", $view) === false)
        {
            if ($this->viewsNamespace)
            {
                $view = $this->viewsNamespace . "\\" . $view;
            }
        }

        if (array_key_exists('saveData', $options) == false)
        {
            $options['saveData'] = true;
        }

        return view($view, $params, $options);
    }

    public function goHome()
    {
        return $this->redirect(site_url('admin'));
    }

    public function redirect($url)
    {
        return redirect()->withCookies()->to($url);
    }

}