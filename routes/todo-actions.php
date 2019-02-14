<?php

use Router\Router;
use App\Services\ToDoSortingService;

Router::post('/add-action','\App\Http\Controllers\ToDoController@addAction')
	->name('todo-add-action');

Router::post('/edit-action/{id}','\App\Http\Controllers\ToDoController@editAction')
	->name('todo-edit-action');

Router::post('/set-sorting',function(){
	ToDoSortingService::setSortType(
		app('request')->input('sort-type','')
	);
	
	return redirect()->back();
})->name('todo-set-sort');