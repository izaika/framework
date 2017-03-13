<?php

namespace Izaika\Framework;

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
		// TODO: implement run method
	}


	public function __destruct()
	{
		// TODO: implement __destruct method
	}


	private function __clone()
	{

	}
}