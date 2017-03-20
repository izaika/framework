<?php

namespace Izaika\Framework\Response;


class RedirectResponse extends Response
{
	public function __construct(int $status = self::DEFAULT_STATUS, string $redirect_uri)
	{
		$this->status = $status;
		$this->addHeader('Location', $redirect_uri);
	}


	public function send()
	{
		$this->sendHeaders();
	}

	/**
	 * override
	 */
	public function sendBody()
	{
		// Do nothing
	}
}