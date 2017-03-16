<?php

namespace Izaika\Framework\Request;

/**
 * Class Request
 * @package Izaika\Framework
 */
class Request
{
	private static $instance = null;
	private $headers = [];
	private $user_agent = '';
	private $docroot = '';
	private $uri = '';
	private $path = '';
	private $query_parameters = [];
	private $method = '';


	private function __construct()
	{
		$headers = [];

		if (function_exists('getallheaders')) {
			$headers = getallheaders();
		} else {
			foreach ($_SERVER as $key => $value) {
				if (substr($key, 0, 5) == 'HTTP_') {
					$key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
					$headers[$key] = $value;
				} else {
					$headers[$key] = $value;
				}
			}
		}
		$this->headers = $headers;

		if (isset($_SERVER['REQUEST_METHOD'])) {
			$this->method = $_SERVER['REQUEST_METHOD'];
		}

		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		if (isset($_SERVER['CONTEXT_PREFIX'])) {
			$this->docroot = $_SERVER['CONTEXT_PREFIX'];
		}

		if (isset($_SERVER["REQUEST_URI"])) {
			$this->uri = $_SERVER["REQUEST_URI"];
		}

		if ($this->uri) {
			if ($this->docroot) {
				$path = str_replace($this->docroot, '', $this->uri);
			} else {
				$path = $this->uri;
			}

			if (strpos($path, '?') !== false) $path = explode('?', $path)[0];
			$this->path = $path;
		}

		if (isset($_SERVER["QUERY_STRING"])) {
			foreach (explode('&', $_SERVER["QUERY_STRING"]) as $parameter) {
				$parameter_arr = explode('=', $parameter);
				$this->query_parameters[$parameter_arr[0]] = @$parameter_arr[1] ? $parameter_arr[1] : '';
			}
		}
	}


	public static function getInstance(): self
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	public function getUri(): string
	{
		return $this->uri;
	}


	public function getMethod(): string
	{
		return $this->method;
	}

	public function getHeaders(): array
	{
		return $this->headers;
	}


	public function getHeader(string $key = ''): string
	{
		return isset($this->headers[$key]) ? $this->headers[$key] : '';
	}


	public function getQueryParameters(): array
	{
		return $this->query_parameters;
	}


	public function getQueryParameter(string $key = ''): string
	{
		return isset($this->query_parameters[$key]) ? $this->query_parameters[$key] : '';
	}


	public function getPath(): string
	{
		return $this->path;
	}


	private function __clone()
	{

	}
}