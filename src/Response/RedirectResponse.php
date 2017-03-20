<?php

namespace Izaika\Framework\Response;

/**
 * Class RedirectResponse
 *
 * @package Izaika\Framework
 */
class RedirectResponse extends Response
{
	/**
	 * RedirectResponse constructor.
	 * @param int $status
	 * @param string $redirect_uri
	 */
	public function __construct(int $status = self::DEFAULT_STATUS, string $redirect_uri)
	{
		$this->status = $status;
		$this->addHeader('Location', $redirect_uri);
	}


	public function send()
	{
		$this->sendHeaders();
	}
}