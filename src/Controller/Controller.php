<?php

namespace Izaika\Framework\Controller;

use duncan3dc\Laravel\BladeInstance;
use Izaika\Framework\Request\Request;
use Izaika\Framework\Router\Route;

abstract class Controller
{
	protected $route;
	protected $renderer;
	protected $request;
	protected $template;
	protected $view;


	public function __construct(Route $route)
	{
		$this->route = $route;
		$this->request = Request::getInstance();
	}


	final protected function render(string $view_name, array $variables)
	{
		if (!$this->renderer) {
			$this->renderer = new BladeInstance(APP_PATH.'views', APP_PATH.'cache/views');
		}
		echo $this->renderer->render($view_name, $variables);
	}


	final public function setTemplate(string $path)
	{
		$this->template = $path;
	}


	final public function setView(string $path)
	{
		$this->view = $path;
	}
}