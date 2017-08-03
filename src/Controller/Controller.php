<?php

namespace Izaika\Framework\Controller;

use duncan3dc\Laravel\BladeInstance;
use Izaika\Framework\Request\Request;
use Izaika\Framework\Router\Route;

/**
 * Abstract class Controller
 * @package Izaika\Framework
 */
abstract class Controller
{
	protected $route;
	protected $renderer;
	protected $request;


	public function __construct(Route $route)
	{
		$this->route = $route;
		$this->request = Request::getInstance();
	}


	/**
	 * shows view
	 *
	 * @param string $view_name
	 * @param array $variables
	 */
	final protected function render(string $view_name, array $variables)
	{
		if (!$this->renderer) {
			$this->renderer = new BladeInstance(APP_PATH . 'views', APP_PATH . 'cache/views');
		}
		echo $this->renderer->render($view_name, $variables);
	}
}