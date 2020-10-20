<?php

namespace Admin\Controllers;

class Logout extends BaseController
{

    public function index()
    {
        adminAuth()->logout();

        return $this->goHome();
    }

}