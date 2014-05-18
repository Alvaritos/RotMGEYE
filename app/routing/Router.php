<?php namespace App\Routing;

class Router
{

	/**
    * Routes registred with method GET
    *
    * @var array
    */

	public $_get;

	/**
    * Routes registred with method POST
    *
    * @var array
    */

	public $_post;

	/**
    * Store GET routes
    *
    * @param string $uri
    * @param string $map
    * @access public
    * @return void
    * @throws RouterException
    */

	public function get($uri, $map = false)
	{
		if (!$map) throw new RouterException('Please define a Controller@functionTo');

		$map = explode('@', $map);
		$this->_get[$uri] = array('controller' => $map[0], 'function' => $map[1]);
	}

	/**
    * Store POST routes
    *
    * @param string $uri
    * @param string $map
    * @access public
    * @return void
    * @throws RouterException
    */

	public function post($uri, $map = false)
	{
		if (!$map) throw new RouterException('Please define a Controller@functionTo');

		$map = explode('@', $map);
		$this->_post[$uri] = array('controller' => $map[0], 'function' => $map[1]);
	}
}
