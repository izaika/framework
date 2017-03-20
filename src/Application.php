<?php

namespace Izaika\Framework;

use Izaika\Framework\Response\Response;
use Izaika\Framework\Router\Route;
use Izaika\Framework\Router\Router;

/**
 * Class Application
 * Singleton
 *
 * @package Izaika\Framework
 */
class Application
{
	private static $_instance = null;


	public $config = [];


	static public function getInstance(array $config = []): self
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self($config);
		}
		return self::$_instance;
	}


	private function __construct(array $config = [])
	{
		$this->config = $config;
	}


	public function run()
	{
		$router = new Router($this->config);
		$route = $router->getRoute(); /** @var $route Route */

		$controller_name		= $route->getController();
		$controller_method_name	= $route->getMethod();

		if (class_exists($controller_name)) {
			$reflection_class = new \ReflectionClass($controller_name);
			if ($reflection_class->hasMethod($controller_method_name)) {
				$reflection_method = $reflection_class->getMethod($controller_method_name);
				if ($reflection_method->isPublic()) {
					$controller = new $controller_name($route);
					$response = $controller->$controller_method_name(); /** @var $response Response */
					if ($response instanceof Response) {
						$response->send();
					}
				} else {
					throw new \ErrorException("Method $controller_method_name is not public in controller $controller_name");
				}
			} else {
				throw new \ErrorException("Method $controller_method_name does not exist in controller $controller_name");
			}
		} else {
			throw new \ErrorException("Controller $controller_name does not exist");
		}
	}


	private function __clone()
	{

	}
}