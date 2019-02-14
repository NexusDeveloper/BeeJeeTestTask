<?php

if(!function_exists('response')){
	/**
	 * @param string|array $content
	 * @param int          $code
	 *
	 * @return \Response\Interfaces\Response
	 */
	function response($content,int $code=200){
		return app(
			\Response\Interfaces\Response::class,
			[
				'content'=>$content,
				'code'=>$code
			]
		);
	}
};