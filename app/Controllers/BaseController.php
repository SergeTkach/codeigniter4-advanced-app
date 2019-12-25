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

    protected $layout = "layout";

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

        $this->user = Services::user();
    }

    protected function render(string $view, array $params = [])
    {
        $content = view($view, $params, ['saveData' => true]);

        $layout = $this->layout;

        $data = service('renderer')->getData();

        if (array_key_exists('layout', $data))
        {
            $layout = $data['layout'];
        }

        if ($layout)
        {
            return view($this->layout, ['content' => $content], ['saveData' => false]);
        }

        return $content;
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