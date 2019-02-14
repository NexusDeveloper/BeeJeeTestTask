<?php
declare(strict_types=1);
namespace View;

use Closure;

class PHPViewDirectives{
	/**
	 * @param string $path
	 * @param array  $attributes
	 *
	 * @return string
	 */
	public function css(string $path,array $attributes=[]):string{
		return $this->renderTemplate($path,$attributes)(
			'<link rel="stylesheet" type="text/css" href="%s" %s/>'
		);
	}
	
	/**
	 * @param string $path
	 * @param array  $attributes
	 *
	 * @return string
	 */
	public function js(string $path,array $attributes=[]):string{
		return $this->renderTemplate($path,array_merge([
			'type'=>'text/javascript'
		],$attributes))(
			'<script src="%s" %s></script>'
		);
	}
	
	/**
	 * @param string $path
	 * @param array  $attributes
	 *
	 * @return Closure
	 */
	protected function renderTemplate(string $path,array $attributes=[]):Closure{
		$path=$this->preparePath($path);
		$attributes=$this->renderAttributes($attributes);
		
		
		return function(string $template) use($path,$attributes){
			return sprintf($template,$path,$attributes);
		};
	}
	
	/**
	 * @param array $attributes
	 *
	 * @return string
	 */
	protected function renderAttributes(array $attributes=[]):string{
		return implode(' ',array_map(function($key) use(&$attributes){
			return sprintf('%s="%s"',$key,$attributes[$key]);
		},array_keys($attributes)));
	}
	
	/**
	 * @param string $path
	 *
	 * @return string
	 */
	protected function preparePath(string $path=''):string{
		$realPath=is_file($path)?
			$path:
			public_path($path);
		
		if(!is_file($realPath))
			return $path;
		
		$prefix=mb_strpos($realPath,'?')!==false?'&':'?';
		$path.=$prefix.'mtime='.filemtime($realPath);
		
		
		return DIRECTORY_SEPARATOR.ltrim($path,DIRECTORY_SEPARATOR);
	}
}