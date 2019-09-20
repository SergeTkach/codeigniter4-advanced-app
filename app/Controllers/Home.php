<?php

namespace App\Controllers;

class Home extends \App\Components\Controller
{

	public function index()
	{
		return $this->render('welcome_message');
	}

}