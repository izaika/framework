<?php

namespace Izaika\Framework\Response;

/**
 * Class JsonResponse
 *
 * @package Izaika\Framework
 */
class JsonResponse extends Response
{

	/**
	 * JsonResponse constructor.
	 * @param int $status
	 * @param $body
	 */
	public function __construct(int $status = self::DEFAULT_STATUS, $body)
	{
		parent::__construct($status, $body);
		$this->addHeader('Content-Type', 'application/json');
	}

	/**
	 * @inheritdoc
	 */
	public function sendBody(){
		echo json_encode($this->body);
	}
}