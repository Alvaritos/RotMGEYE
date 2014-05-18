<?php

spl_autoload_register(function($class) 
{
	$parts = explode('\\', $class);

	switch ($parts[1]) {
		case 'Routing':
			require_once '/../app/routing/'.end($parts).'.php';
			break;
		case 'View':
			require_once '/../app/view/'.end($parts).'.php';
			break;
		case 'Libs':
			require_once '/../app/libs/'.end($parts).'.php';
			break;
		case 'Controllers':
			require_once '/../app/controllers/'.end($parts).'.php';
			break;
	}
});