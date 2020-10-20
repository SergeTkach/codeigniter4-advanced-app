<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use BasicApp\Auth\AuthEvents;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

AuthEvents::onLogin(function($event) {
	if ($event->model instanceof \App\Models\UserModel)
	{
		// Compability with:
		// https://codeigniter.com/user_guide/extending/authentication.html

		Events::trigger('login');
	}
});

AuthEvents::onLogout(function($event) {
	if ($event->model instanceof \App\Models\UserModel)
	{
		// Compability with:
		// https://codeigniter.com/user_guide/extending/authentication.html

		Events::trigger('logout');
	}
});

Events::on('pre_system', function() {

    helper(['auth']);

	if (ENVIRONMENT !== 'testing')
	{
		if (ini_get('zlib.output_compression'))
		{
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0)
		{
			ob_end_flush();
		}

		ob_start(function ($buffer) {
			return $buffer;
		});
	}

	/*
	 * --------------------------------------------------------------------
	 * Debug Toolbar Listeners.
	 * --------------------------------------------------------------------
	 * If you delete, they will no longer be collected.
	 */
	if (!is_cli() && (ENVIRONMENT !== 'production'))
	{
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
	
    	Services::toolbar()->respond();
	}
});