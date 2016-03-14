<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 18:05
 */

namespace Unplag\Exception;


use Unplag\Request;

class RequestException extends \Exception implements UnplagException
{
	/**
	 * @var Request
	 */
	protected $req;
	public function __construct($message, $code, \Exception $previous, Request $request)
	{
		parent::__construct($message, $code, $previous);

		$this->req = $request;
	}

	/**
	 * @return Request
	 */
	public function getRequest() {
		return $this->req;
	}
}