<?php
declare(strict_types=1);
namespace Router;

use Kernel\Providers\AbstractServiceProvider;

class RouterProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		app()->bind(
			\Router\Interfaces\Route::class,
			Route::class
		);
	}
}