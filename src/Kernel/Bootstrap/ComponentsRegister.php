<?php
declare(strict_types=1);
namespace Kernel\Bootstrap;

use Database\DatabaseProvider;
use ErrorHandler\ErrorHandlerProvider;
use Helpers\HelpersProvider;
use Kernel\Providers\AbstractServiceProvider;
use Response\ResponseProvider;
use Router\RouterProvider;
use Session\SessionProvider;
use View\ViewProvider;

class ComponentsRegister extends AbstractServiceProvider{
	/**
	 * @return array
	 */
	public function providers():array{
		return [
			HelpersProvider::class,
			SessionProvider::class,
			RouterProvider::class,
			ResponseProvider::class,
			ErrorHandlerProvider::class,
			DatabaseProvider::class,
			ViewProvider::class,
		];
	}
}