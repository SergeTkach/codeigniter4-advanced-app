<?php

namespace App\Controllers;

class TestCookie extends \CodeIgniter\Controller
{

    public function index($key = null)
    {
        helper('cookie');

        if (!$key)
        {
            $key = rand();

            set_cookie('test_cookie_' . $key, $key, 0);

            return redirect()->to(site_url('testCookie/index/' . $key));
        }

        $value = get_cookie('test_cookie_' . $key);

        var_dump($value);
    }

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

        //set_cookie('test_cookie', '', 0);

        delete_cookie('test_cookie');
    }

}