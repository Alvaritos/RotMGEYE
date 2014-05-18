<?php namespace App\Routing;

class RouterException extends \Exception
{
	/**
    * Throw a Routing error message
    *
    * @param string
    * @access public
    * @return void
    */

	public function __construct($text)
	{
		die($text);
	}
}