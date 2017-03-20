<?php

namespace Izaika\Framework\Router;

use Izaika\Framework\Request\Request;

/**
 * Class Router
 * @package Izaika\Framework
 */
class Router
{
	private $routes = [];


	public function __construct(array $config)
	{
		foreach ($config as $key => $value) {
			$this->routes[$key] = [
				'url_parts_arr' => array_diff(explode('/', $value['pattern']), ['']),
				'method' => isset($value['method']) ? $value['method'] : 'GET',
				'controller_name' => $this->getControllerName($value),
				'action_name' => $this->getActionName($value),
			];
		}
	}


	public function getRoute()
	{
		$request = Request::getInstance();
		$url_parts_array = explode('/', $request->getPath());
		// remove empty values from array
		$url_parts_array = array_diff($url_parts_array, ['']);
		$route_name = false;
		$parameters = [];
		foreach ($this->routes as $name => $route) {
			if ($request->getMethod() != $route['method']) continue;
			if (count($url_parts_array) != count($route['url_parts_arr'])) continue;
			// check if this array contains of only parameters names
			$parameters_only = true;
			foreach (array_diff($route['url_parts_arr'], $url_parts_array) as $arr_key => $arr_item) {
				if (!preg_match('/^[\{].*[\}]$/', $arr_item)) {
					$parameters_only = false;
					break;
				}
				$parameters[str_replace(['{', '}'], '', $arr_item)] = array_diff($url_parts_array, $route['url_parts_arr'])[$arr_key];
			}
			if (!$parameters_only) continue;
			$route_name = $name;
		}
		if ($route_name) {
			return new Route($route_name, $this->routes[$route_name]['controller_name'], $this->routes[$route_name]['action_name'], $parameters);
		} else {
			throw new \ErrorException('Route not found');
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
}