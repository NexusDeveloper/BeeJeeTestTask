<?php
declare(strict_types=1);
namespace ErrorHandler;

use ErrorHandler\Interfaces\ErrorHandler;
use Exception;
use Response\Interfaces\Response;

class Handler implements ErrorHandler{
	
	/**
	 * @param  Exception $exception
	 *
	 * @return void
	 */
	public function report(Exception $exception){}
	
	/**
	 * @param  Exception $exception
	 *
	 * @return Response
	 */
	public function render(Exception $exception):Response{
		return response(
			'<pre>'.$exception->__toString().'</pre>',
			500
		);
	}
}