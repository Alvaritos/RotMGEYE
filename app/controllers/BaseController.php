<?php namespace App\Controllers;

class BaseController
{
	/**
    * Actual params
    *
    * @var array
    */

	public $_params = array();

	/**
    * View object
    *
    * @var object
    */

	public $_view;

	/**
	* Set our default layout
	*
	* @access public
	* @return void
	*/

	public function __construct()
	{
		$this->_view = new \App\View\View('layout'); 
	}
}