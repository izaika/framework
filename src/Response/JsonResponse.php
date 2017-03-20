<?php

namespace Izaika\Framework\Response;

class JsonResponse extends Response
{

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