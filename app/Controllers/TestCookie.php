<?php

namespace App\Controllers;

use Denis303\Auth\NotRememberMeCookie;

class TestCookie extends \CodeIgniter\Controller
{

    public function setCookie($set = 1)
    {
        if ($set)
        {
            helper('cookie');

            $token = rand();

            set_cookie('test_cookie', $token, 0);

            return redirect()->to(site_url('testCookie/setCookie/0'));
        }

    }

    public function getCookie()
    {
        helper('cookie');

        $value = get_cookie('test_cookie');

        var_dump($value);

    }

    public function deleteCookie()
    {
        helper('cookie');

        set_cookie('test_cookie', '', 0);

        delete_cookie('test_cookie');
    }

}