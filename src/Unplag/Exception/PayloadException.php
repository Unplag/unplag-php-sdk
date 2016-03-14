<?php
/**
 * Created by IntelliJ IDEA.
 * User: egormelnikov
 * Date: 12.03.16
 * Time: 17:07
 */

namespace Unplag\Exception;


class PayloadException extends \Exception implements UnplagException
{
	const CODE_INVALID_RESOURCE = 101;
	const CODE_PATH_NOT_READABLE = 102;
	const CODE_FAILED_TO_READ_FILE = 103;
	const CODE_FAILED_TO_READ_RESOURCE = 104;
}