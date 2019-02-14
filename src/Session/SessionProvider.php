<?php
declare(strict_types=1);
namespace Session;

use Kernel\Providers\AbstractServiceProvider;

class SessionProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		@session_start();
		
		app()->bind(
			\Session\Interfaces\Session::class,
			Session::class
		);
		app()->bind(
			'session',
			\Session\Interfaces\Session::class
		);
		app()->bind('flash',Flash::class);
	}
}