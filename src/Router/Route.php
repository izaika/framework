<?php


namespace Izaika\Framework\Router;

/**
 * Class Route
 *
 * @package Izaika\Framework
 */
class Route
{
	private $name;
	private $controller;
	private $method;
	private $params = [];


	/**
	 * Route constructor.
	 * @param string $name
	 * @param string $controller
	 * @param string $method
	 * @param array $params
	 */
	public function __construct(string $name, string $controller, string $method, array $params = [])
	{
		$this->name = $name;
		$this->controller = $controller;
		$this->method = $method;
		$this->params = $params;
	}


	/**
	 * Returns the name of route
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}


	/**
	 * Returns the name of controller
	 * @return string
	 */
	public function getController(): string
	{
		return $this->controller;
	}


	/**
	 * Returns the name of method
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}


	/**
	 * Returns the array of parameters
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}


	/**
	 * Returns the value of parameter by it's key
	 * @param string $key
	 * @return string
	 */
	public function getParam(string $key): string
	{
		return $this->params[$key];
	}
}