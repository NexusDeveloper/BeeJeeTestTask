<?php
declare(strict_types=1);
namespace ErrorHandler\Exceptions;

use Throwable;

class FatalThrowableError extends \Exception{
	/**
	 * FatalThrowableError constructor.
	 *
	 * @param Throwable $throwable
	 */
	public function __construct(Throwable $throwable){
		parent::__construct(
			$throwable->getMessage(),
			$throwable->getCode(),
			$throwable
		);
	}
}