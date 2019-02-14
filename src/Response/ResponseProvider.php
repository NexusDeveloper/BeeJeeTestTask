<?php
declare(strict_types=1);
namespace Response;

use Kernel\Providers\AbstractServiceProvider;

class ResponseProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		app()->bind(
			\Response\Interfaces\Response::class,
			Response::class
		);
	}
}