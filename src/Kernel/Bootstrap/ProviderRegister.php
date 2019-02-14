<?php
declare(strict_types=1);
namespace Kernel\Bootstrap;

use Kernel\Providers\AbstractServiceProvider;

class ProviderRegister extends AbstractServiceProvider{
	/**
	 * @return array
	 */
	public function providers():array{
		return config('app')->get('providers',[]);
	}
}