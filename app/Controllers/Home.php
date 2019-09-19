<?php

namespace App\Controllers;

class Home extends \App\Components\BaseController
{

	public function index()
	{
		return $this->render('welcome_message');
	}

}