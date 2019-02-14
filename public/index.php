<?php

$app = require_once __DIR__.'/../bootstrap/app.php';

$app
	->make(\Kernel\Kernel::class,['app'=>$app])
	->handle()
	->send();