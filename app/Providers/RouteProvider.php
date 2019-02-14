<?php
declare(strict_types=1);
namespace App\Providers;

use Kernel\Providers\AbstractServiceProvider;

class RouteProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		foreach(glob(base_path('/routes/*.php')) as $route)
			include_once $route;
	}
}