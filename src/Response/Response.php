<?php
declare(strict_types=1);
namespace Response;

use Response\Interfaces\Response as ResponseInterface;

class Response implements ResponseInterface{
	
	protected $code;
	protected $content;
	
	/**
	 * Response constructor.
	 *
	 * @param string|array $content
	 * @param int          $code
	 */
	public function __construct($content='',$code=200){
		$this->content=$content;
		$this->code=$code;
	}
	
	/**
	 * @return void
	 */
	public function send(){
		echo $this->content;
	}
	
	/**
	 * @param array $flashData
	 *
	 * @return Response
	 */
	public function with(array $flashData):self{
		$flash=app('flash');
		$flash->set(
			null,
			array_merge(
				$flash->get()?:[],
				$flashData
			)
		);
		
		return $this;
	}
	
	/**
	 * @return Response
	 */
	public function withFormData():self{
		$flash=app('flash');
		$flash->set(
			'form-data',
			app('request')->getFormData()
		);
		
		
		return $this;
	}
}