<?php

use Router\Router;

Router::get('/','\App\Http\Controllers\ToDoController@index')
	->name('index');

Router::get('/add','\App\Http\Controllers\ToDoController@add')
	->name('todo-add');

Router::get('/edit/{id}','\App\Http\Controllers\ToDoController@edit')
	->name('todo-edit');