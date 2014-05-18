<?php namespace App\View;

class ViewException extends \Exception
{
	/**
    * Throw a View error message
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