<?php

namespace Izaika\Framework\Router;
use Izaika\Framework\Request\Request;

/**
 * Class Router
 * @package Izaika\Framework
 */

class Router
{
	const DEFAULT_REGEX = '[^\/]+';


	private $routes = [];


	public function __construct(array $config)
	{
		foreach ($config as $key => $value) {
			$this->routes[$key] = [
				'method' => isset($value['method']) ? $value['method'] : 'GET',
				'controller_name' => $this->getControllerName($value),
				'action_name' => $this->getActionName($value),
				'variables' => isset($value['parameters']) && count($value['parameters']) ? $this->getParameters($value) : [],
			];
		}
	}


	public function getRoute()
	{
		$request = Request::getInstance();
		debug($request->getPath());
		foreach ($this->routes as $name => $route) {

		}
	}


	public function getControllerName(array $value): string
	{
		return explode("@", $value["action"])[0];
	}


	public function getActionName(array $value): string
	{
		return explode("@", $value["action"])[1];
	}


	public function getParameters(array $value): array
	{
		$parameters = [];
		foreach ($value['parameters'] as $parameter) {
			$parameters[$parameter] = strpos($value['pattern'], $parameter);
		}
		return $parameters;
	}
}