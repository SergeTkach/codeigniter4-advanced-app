<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

abstract class BaseController extends \CodeIgniter\Controller
{

    protected $session;

    protected $user;

    protected $viewsNamespace;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------

        $this->session = Services::session();

        $this->user = Services::auth()->getUser();
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
        return $this->redirect(base_url());
    }

    public function redirect($url)
    {
        return redirect()->to($url);
    }

}