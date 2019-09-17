<?php

namespace App\Controllers;

class Home extends \App\Components\BaseController
{

    public $layout = false;

	public function index()
	{
		return view('welcome_message');
	}

}