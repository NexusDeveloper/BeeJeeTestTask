<?php
declare(strict_types=1);
namespace View;

use Kernel\Providers\AbstractServiceProvider;
use View\Interfaces\View;

class ViewProvider extends AbstractServiceProvider{
	/**
	 * @return void
	 */
	public function register():void{
		app()->bind(
			View::class,
			PHPView::class
		);
	}
}