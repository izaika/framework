<?php

namespace Izaika\Framework\Controller;

use Izaika\Framework\Request\Request;
use Izaika\Framework\Router\Route;

abstract class Controller
{
	protected $route;
	protected $request;
	protected $template;
	protected $view;


	public function __construct(Route $route)
	{
		$this->route = $route;
		$this->request = Request::getInstance();
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