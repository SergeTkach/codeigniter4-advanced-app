<?php

namespace App\Controllers;

use Denis303\Auth\NotRememberMeCookie;

class TestNotRememberMeCookie extends \CodeIgniter\Controller
{

    protected $notRememberMeCookie;

    public function __construct()
    {
        $this->notRememberMeCookie = new NotRememberMeCookie('test_not_remember_me');
    }

    public function setToken($set = 1)
    {
        if ($set)
        {
            $token = rand();

            $this->notRememberMeCookie->setToken($token);
        
            return redirect()->to(site_url('testNotRememberMeCookie/setToken/0'));
        }
    }

    public function getToken()
    {
        $token = $this->notRememberMeCookie->getToken();

        echo $token;
    }

    public function deleteToken()
    {
        $this->notRememberMeCookie->deleteToken();
    }

}
