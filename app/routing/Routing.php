<?php namespace App\Routing;

class Routing
{
	/**
    * Create the new route we will request
    *
    * @var string
    */

	public $_new;
	
	/**
    * Get our actual uri
    *
    * @var string
    */

	private $_uri;

	/**
    * Save route list
    *
    * @var array
    */

	private $_routes;

	/**
    * Save used params
    *
    * @var array
    */

	private $_params = array();

	/**
    * Store actual URI and Route list
    *
    * @param Router $route
    * @access public
    * @return void
    */

	public function __construct(array $route)
	{
		$this->_uri = $_SERVER['REQUEST_URI'];
		$this->_routes = (array)$route;
		$this->patchRoute();
	}

	/**
    * Patch Route list
    *
    * @access public
    * @return array
    * @throws RouterException
    */

	public function patchRoute()
	{
		foreach ($this->_routes as $key => $value)
		{
			$new_uri = array_filter(explode('/', $this->_uri));
			$new_key = array_filter(explode('/', $key));

			if (count($new_uri) === count($new_key))
			{
				for ($i = 0; $i < count($new_uri); $i++) 
				{ 
					if (strpos($new_key[$i], ':') !== false)
					{
						$this->_params[$new_key[$i]] = $new_uri[$i + 1];
						$new_key[$i] = $new_uri[$i + 1];
					}
				}
			}

			if ($this->_uri === '/'.implode('/', $new_key))
			{
				$this->_new = array('controller' => $value['controller'], 'function' => $value['function'], 'params' => $this->_params);

				return true;
			}
		}

		throw new RouterException('No route match found');
	}
}