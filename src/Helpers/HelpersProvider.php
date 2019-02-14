<?php
declare(strict_types=1);
namespace Helpers;

use Kernel\Providers\AbstractServiceProvider;

class HelpersProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		foreach(glob(__DIR__.'/functions/*.php')?:[] as $path)
			include_once $path;
		
		foreach(glob(__DIR__.'/*.php') as $path){
			if(__FILE__!==$path)
				require_once $path;
		};
	}
}