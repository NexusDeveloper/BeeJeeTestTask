<?php
declare(strict_types=1);
namespace View;

use Container\Exceptions\PropertyNotFoundException;
use PHPViewParameters;
use View\Exceptions\FileNotFoundException;
use View\Interfaces\View;

/**
 * Class PHPView
 * @package View
 * @property PHPView|null base
 */
class PHPView implements View{
	static protected $openedViews=[];
	
	private $queueIndex;
	private $name;
	
	protected $path;
	protected $extendView;
	protected $extendSection;
	
	protected $sections=[];
	
	/**
	 * PHPView constructor.
	 *
	 * @param string $view
	 *
	 * @throws FileNotFoundException
	 */
	public function __construct(string $view){
		$viewPath=$view;
		if(mb_strpos($viewPath,'.php')===false)
			$viewPath.='.php';
		
		$viewPath=view_path($viewPath);
		if(!is_file($viewPath))
			throw new FileNotFoundException("View [$viewPath] not found");
		
		$this->name=$view;
		$this->path=$viewPath;
		$this->queueIndex=isset(static::$openedViews[$view])?
			count(static::$openedViews[$view]):0;
		
		static::$openedViews[$view][$this->queueIndex]=&$this;
	}
	
	/**
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render(array $parameters=[]):string{
		$params=app(PHPViewParameters::class,[
			'params'=>array_merge($parameters,[
				'viewEngine'=>$this
			])
		]);
		
		$html=$this->buffering($params);
		
		unset(static::$openedViews[$this->path][$this->queueIndex]);
		
		if($this->extendView)
			$html=$this->getExtendedView()->setSection(
				$this->extendSection,
				$html
			)->render();
		
		
		return $html;
	}
	
	/**
	 * @param PHPViewParameters $var
	 *
	 * @return string
	 */
	protected function buffering(PHPViewParameters $var):string{
		$inc=app(PHPViewDirectives::class);
		ob_start();
		
		include $this->path;
		
		$content=ob_get_contents();
		ob_end_clean();
		
		
		return $content;
	}
	
	/**
	 * @param string $view
	 * @param string $section
	 */
	public function extend(string $view,string $section):void{
		$this->extendView=$view;
		$this->extendSection=$section;
	}
	
	/**
	 * @param string $sectionName
	 *
	 * @return bool
	 */
	public function hasSection(string $sectionName):bool{
		return isset($this->sections[$sectionName]);
	}
	
	/**
	 * @param string $sectionName
	 *
	 * @return null|string
	 */
	public function getSection(string $sectionName):?string{
		if(!$this->hasSection($sectionName))
			return null;
		
		return $this->sections[$sectionName];
	}
	
	/**
	 * @param string $sectionName
	 * @param string $sectionContent
	 *
	 * @return PHPView
	 */
	public function setSection(string $sectionName,string $sectionContent):self{
		$this->sections[$sectionName]=$sectionContent;
		
		return $this;
	}
	
	/**
	 * @param string $viewName
	 *
	 * @return null|PHPView
	 */
	static protected function &getViewInstance(string $viewName):?self{
		return isset(static::$openedViews[$viewName])?
			end(static::$openedViews[$viewName]):
			app()->make(self::class,[
				'view'=>$viewName
			]);
	}
	
	/**
	 * @return null|PHPView
	 */
	public function getExtendedView():?self{
		return $this->extendView?
			self::getViewInstance($this->extendView):
			null;
	}
	
	/**
	 * @param string $name
	 *
	 * @return null|PHPView
	 * @throws PropertyNotFoundException
	 */
	public function __get(string $name){
		if($name==='base')
			return $this->getExtendedView();
		
		throw new PropertyNotFoundException("Property [$name] not found in class [".self::class."]");
	}
}