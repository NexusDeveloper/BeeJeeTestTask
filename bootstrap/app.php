<?php
declare(strict_types=1);
namespace bootstrap;

require_once __DIR__.'/../vendor/autoload.php';


return new \Application\Application(
	__DIR__.'/../'
);