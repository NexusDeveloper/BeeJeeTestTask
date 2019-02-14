<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Exceptions\AccessDeniedHttpException;
use Request\Request;
use Router\Exceptions\NotFoundHttpException;

class ToDoController{
	/**
	 * @return string|\View\Interfaces\View
	 */
	public function index(){
		$onPage=3;
		$originalPage=app('request')->input('page',0);
		if($originalPage==1)
			return redirect()->route('index',[],true);
		
		$maxPage=max(1,ceil(ToDo::count()/$onPage));
		$page=min($maxPage,max(1,$originalPage));
		if($originalPage>0 and $page!=$originalPage)
			return redirect(
				url()->route('index').'?page='.$page
			);

		
		return view('pages/main',[
			'todo-list'=>ToDo::get(
				(int) $onPage,
				(int) $page*$onPage-$onPage
			),
			'pagination'=>[
				'url'=>url()->route('index').'?page=',
				'current'=>$page,
				'on-page'=>$onPage,
				'max-page'=>$maxPage
			]
		]);
	}
	
	/**
	 * @return string|\View\Interfaces\View
	 */
	public function add(){
		return view('pages/add');
	}
	
	/**
	 * @return string|\View\Interfaces\View
	 * @throws NotFoundHttpException
	 * @throws AccessDeniedHttpException
	 */
	public function edit(){
		if(!user())
			throw new AccessDeniedHttpException('Access denied');
		
		$taskId=(int) app('router')->getCurrentRoute()->parameter('id');
		if(!$taskId)
			throw new NotFoundHttpException('Task not found');
		
		return view('pages/edit',[
			'task'=>ToDo::findOrFail($taskId)
		]);
	}
	
	/**
	 * @return \Response\Response|\Response\ResponseRedirect
	 */
	public function addAction(){
		$data=[
			'author_name',
			'author_email',
			'text'
		];
		$errors=[];
		$request=app('request');
		$data=array_reduce($data,function($res,$key) use(&$request,&$errors){
			$value=$request->input($key,'');
			if(empty($value))
				$errors[]="Field [$key] are required";
			
			$res[$key]=$value;
			
			return $res;
		},[]);
		if(!empty($errors))
			return redirect()->back()->with([
				'error'=>reset($errors)
			])->withFormData();
		
		$task=new ToDo($data);
		$task->save();
		
		
		return redirect()->route('todo-edit',[
			'id'=>$task->id
		]);
	}
	
	/**
	 * @return \Response\ResponseRedirect
	 * @throws AccessDeniedHttpException
	 * @throws NotFoundHttpException
	 */
	public function editAction(){
		if(!user())
			throw new AccessDeniedHttpException('Access denied');
		
		$taskId=(int) app('router')->getCurrentRoute()->parameter('id');
		if(!$taskId)
			throw new NotFoundHttpException('Task not found');
		
		$task=ToDo::findOrFail($taskId);
		
		
		/** @var Request $request */
		$request=app('request');
		$task->setAttribute(
			'text',
			$request->input('text',$task->text)
		);
		$task->setAttribute(
			'completed',
			$request->has('completed')?1:0
		);
		$task->save();
		
		
		return redirect()->route('index');
	}
}