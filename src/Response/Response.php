<?php

namespace Izaika\Framework\Response;

/**
 * Class Response
 *
 * @package Izaika\Framework
 */
class Response
{
	const STATUS_MSGS = [
		'200' => 'Success',
		'301' => 'Moved permanently',
		'302' => 'Moved temporary',
		'401' => 'Auth required',
		'403' => 'Access denied',
		'404' => 'Not found',
		'500' => 'Server error'
	];

	const DEFAULT_STATUS = 200;

	protected $status;
	protected $headers = [];
	protected $body = '';


	/**
	 * Response constructor.
	 * @param int $status
	 * @param $body
	 */
	public function __construct(int $status = self::DEFAULT_STATUS, $body)
	{
		$this->status = $status;
		$this->setBody($body);
		$this->addHeader('Content-Type', 'text/html');
	}


	public function send()
	{
		$this->sendBody();
	}


	/**
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}


	public function addHeader(string $key, $value)
	{
		$this->headers[$key] = $value;
	}


	public function sendHeaders()
	{
		header($_SERVER['SERVER_PROTOCOL'] . $this->status . array_key_exists($this->status, self::STATUS_MSGS) ? ' '.self::STATUS_MSGS[$this->status] : null);
		if ($this->headers) {
			foreach ($this->headers as $key => $value) {
				header("$key: $value");
			}
		}
	}


	/**
	 * @return string
	 */
	public function getBody():string
	{
		return $this->body;
	}


	public function setBody($body)
	{
		$this->body = $body;
	}


	/**
	 * send content to the client
	 */
	public function sendBody()
	{
		echo $this->body;
	}
}