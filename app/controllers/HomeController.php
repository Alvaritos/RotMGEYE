<?php namespace App\Controllers;

class HomeController extends BaseController
{
	public function showTest()
	{
		$this->_view->render('test', array('name' => 'RotMG WEB ENGINE!'));
	}
}