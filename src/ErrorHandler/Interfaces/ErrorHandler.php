<?php
declare(strict_types=1);
namespace ErrorHandler\Interfaces;

use Exception;
use Response\Interfaces\Response;

interface ErrorHandler{
	/**
	 * @param  Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception);
	
	/**
	 * @param  Exception $exception
	 *
	 * @return Response
	 */
	public function render(Exception $exception):Response;
}