<?php


namespace Izaika\Framework\Router;


class Route
{
	private $name;
	private $controller;
	private $method;
	private $params = [];


	public function __construct(string $name, string $controller, string $method, array $params = [])
	{
		$this->name = $name;
		$this->controller = $controller;
		$this->method = $method;
		$this->params = $params;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getController(): string
	{
		return $this->controller;
	}


	public function getMethod(): string
	{
		return $this->method;
	}


	public function getParams(): array
	{
		return $this->params;
	}


	public function getParam(string $key): string
	{
		return $this->params[$key];
	}
}