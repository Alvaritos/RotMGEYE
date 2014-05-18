<?php namespace App\View;

class View
{
	/**
    * Default layout to render
    *
    * @var string
    */

	private $_layout;

	/**
    * Rendered layout
    *
    * @var string
    */

	private $_rendered;

	/**
    * Rendered content
    *
    * @var array
    */

	private $_content;

	/**
	* Init our view system
	*
	* @access public
	* @return void
	*/

	public function __construct($layout)
	{
		$this->_layout = $layout;
	}

	public function render($view, array $args = null)
	{
		if (file_exists('views/'.$view.'.php')) throw new ViewException('Missing view file - /views/'.$view.'.php');

		ob_start();

		if ($args !== null) extract($args);

		include 'views/'.$view.'.php';

		$this->_content = array('content' => ob_get_contents());

		ob_end_clean();
		ob_start();
		extract($this->_content);

		include 'views/'.$this->_layout.'.php';

		$this->_rendered = ob_get_contents();
		
		ob_end_flush();
	}
}