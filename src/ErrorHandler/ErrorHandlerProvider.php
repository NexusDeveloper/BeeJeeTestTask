<?php
declare(strict_types=1);
namespace ErrorHandler;

use ErrorHandler\Interfaces\ErrorHandler;
use Kernel\Providers\AbstractServiceProvider;

class ErrorHandlerProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		app()->bind(
			ErrorHandler::class,
			Handler::class
		);
	}
}