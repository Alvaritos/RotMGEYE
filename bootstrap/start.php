<?php use App\Libs;
{
	class App
	{
		/**
	    * Load ROUTES
	    *
	    * @access public
	    * @return void
	    */

		public function __construct()
		{
			// Start our Routing system

			$route = new App\Routing\Router();

			// Include our Routes -> Map to Controllers

			require_once '/../app/routes.php';

			$routing = new App\Routing\Routing($route->_get);

			// We got all the information needed, load controller and do the magic

			$namespace = 'App\\Controllers\\'.$routing->_new['controller'];
			$our_controller = new $namespace();

			// Pass our parametters and load desired function

			$our_controller->_params = $routing->_new['params'];
			$function_call = $routing->_new['function'];
			$our_controller->$function_call();
		}
	}
}

