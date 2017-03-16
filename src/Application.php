<?php

namespace Izaika\Framework;

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
		$router->getRoute();
	}



	private function __clone()
	{

	}
}