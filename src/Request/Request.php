<?php

namespace Izaika\Framework\Request;

/**
 * Class Request
 * Singletone
 * @package Izaika\Framework
 */
class Request
{
	private static $instance = null;
	private $headers = [];
	private $user_agent = '';
	private $uri_prefix = ''; // http://localhost/uri_prefix/uri
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
			$this->uri_prefix = $_SERVER['CONTEXT_PREFIX'];
		}

		if (isset($_SERVER["REQUEST_URI"])) {
			$this->uri = $_SERVER["REQUEST_URI"];
		}

		if ($this->uri) {
			if ($this->uri_prefix) {
				$path = str_replace($this->uri_prefix, '', $this->uri);
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


	/**
	 * @return Request
	 */
	public static function getInstance(): self
	{
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->uri;
	}


	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}


	/**
	 * @param string $key
	 * @return string
	 */
	public function getHeader(string $key = ''): string
	{
		return isset($this->headers[$key]) ? $this->headers[$key] : '';
	}


	/**
	 * Returns array of get parameters in URI (?key=value)
	 * @return array
	 */
	public function getQueryParameters(): array
	{
		return $this->query_parameters;
	}


	/**
	 * Returns the value of get parameter in URI by key (?key=value)
	 *
	 * @param string $key
	 * @return string
	 */
	public function getQueryParameter(string $key = ''): string
	{
		return isset($this->query_parameters[$key]) ? $this->query_parameters[$key] : '';
	}


	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}


	private function __clone()
	{

	}
}