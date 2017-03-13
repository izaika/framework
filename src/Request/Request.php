<?php

namespace Izaika\Framework\Request;

/**
 * Class Request
 * @package Izaika\Framework
 */
class Request
{
	private static $_instance = null;
	private $_headers = [];
	private $_user_agent = '';
	private $_docroot = '';
	private $_uri = '';
	private $_path = '';
	private $_query_parameters = [];
	private $_method = '';


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
		$this->_headers = $headers;

		if (isset($_SERVER['REQUEST_METHOD'])) {
			$this->_method = $_SERVER['REQUEST_METHOD'];
		}

		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$this->_user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		if (isset($_SERVER['CONTEXT_PREFIX'])) {
			$this->_docroot = $_SERVER['CONTEXT_PREFIX'];
		}

		if (isset($_SERVER["REQUEST_URI"])) {
			$this->_uri = $_SERVER["REQUEST_URI"];
		}

		if ($this->_uri) {
			if ($this->_docroot) {
				$path = str_replace($this->_docroot . '/', '', $this->_uri);
			} else {
				$path = str_replace('/', '', $this->_uri);
			}

			if (strpos($path, '?') !== false) $path = explode('?', $path)[0];
			$this->_path = $path;
		}

		if (isset($_SERVER["QUERY_STRING"])) {
			foreach (explode('&', $_SERVER["QUERY_STRING"]) as $parameter) {
				$parameter_arr = explode('=', $parameter);
				$this->_query_parameters[$parameter_arr[0]] = @$parameter_arr[1] ? $parameter_arr[1] : '';
			}
		}
	}


	public static function getInstance(): self
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	public function getUri(): string
	{
		return $this->_uri;
	}


	public function getMethod(): string
	{
		return $this->_method;
	}

	public function getHeaders(): array
	{
		return $this->_headers;
	}


	public function getHeader(string $key = ''): string
	{
		return isset($this->_headers[$key]) ? $this->_headers[$key] : '';
	}


	public function getQueryParameters(): array
	{
		return $this->_query_parameters;
	}


	public function getQueryParameter(string $key = ''): string
	{
		return isset($this->_query_parameters[$key]) ? $this->_query_parameters[$key] : '';
	}


	private function __clone()
	{

	}
}