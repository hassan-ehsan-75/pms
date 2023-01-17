<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//the welcome page
Route::get('/'	,'Controller@welcome')->name('home');


//user routes
Route::get('/login-form','UserController@loginForm')->name('login-form');

Route::post('/login','UserController@login')->name('login');


//
Route::middleware(['allowOrigin'])->group(function(){
	
	//make a call to delete the user event
	Route::get('markAsRead','EventController@markAsRead')->name('markAsRead');
	//change todo status
	Route::get('changeToDoStatus','ToDoController@apiChangeStatus')->name('changeToDoStatus');
});
//attachment routes

// Route::get('//index','@index')->name('.index');
// Route::get('//create','@create')->name('.create');
// Route::post('//store','@store')->name('.store');
// Route::get('//edit/{id}','@edit')->name('.edit');
// Route::post('//update/{id}','@update')->name('.update');



//errors
Route::middleware(['auth'])->group(function(){
Route::middleware(['AdminOrManger'])->group(function()
{

	//user routes
	Route::get('/user/create','UserController@create')->name('user.create');
	Route::post('/user/store','UserController@store')->name('user.store');
	Route::get('/user/edit/{id}','UserController@edit')->name('user.edit');
	Route::post('/user/update/{id}','UserController@update')->name('user.update');
	Route::get('/user/delete/{id}','UserController@delete')->name('user.delete');


	//title routes
	Route::get('/title/create','TitleController@create')->name('title.create');
	Route::post('/title/store','TitleController@store')->name('title.store');
	Route::get('/title/edit/{id}','TitleController@edit')->name('title.edit');
	Route::post('/title/update/{id}','TitleController@update')->name('title.update');
	Route::get('/title/delete/{id}','TitleController@delete')->name('title.delete');
	//permission routes
	Route::get('/permission/create','PermissionController@create')->
	name('permission.create');
	Route::post('/permission/store','PermissionController@store')->name('permission.store');
	Route::get('/permission/edit/{id}','PermissionController@edit')->name('permission.edit');
	Route::post('/permission/update/{id}','PermissionController@update')
	->name('permission.update');
	Route::get('/permission/delete/{id}','PermissionController@delete')
	->name('permission.delete');


	//project routes
	Route::get('/project/create','ProjectController@create')->name('project.create');
	Route::post('/project/store','ProjectController@store')->name('project.store');
	Route::get('/project/edit/{id}','ProjectController@edit')->name('project.edit');
	Route::post('/project/update/{id}','ProjectController@update')->name('project.update');
	Route::get('/project/delete/{id}','ProjectController@delete')->name('project.delete');
	Route::get('/project/show/{id}','ProjectController@show')->name('project.show');

	//job routes
	Route::get('/job/create','JobController@create')->name('job.create');
	Route::post('/job/store','JobController@store')->name('job.store');
	Route::get('/job/edit/{id}','JobController@edit')->name('job.edit');
	Route::post('/job/update/{id}','JobController@update')->name('job.update');
	Route::get('/job/delete/{id}','JobController@delete')->name('job.delete');
	Route::get('/job/show/{id}','JobController@show')->name('job.show');



	//discussion routes
Route::get('/discussion/create','DiscussionController@create')->name('discussion.create');
Route::post('/discussion/store','DiscussionController@store')->name('discussion.store');
Route::get('/discussion/edit/{id}','DiscussionController@edit')->name('discussion.edit');
Route::post('/discussion/update/{id}','DiscussionController@update')->name('discussion.update');
Route::get('/discussion/delete/{id}','DiscussionController@delete')->name('discussion.delete');
Route::get('/discussion/show/{id}','DiscussionController@show')->name('discussion.show');



	//announcement routes
	Route::get('/announcement/create','AnnouncementController@create')
	->name('announcement.create');
	Route::post('/announcement/store','AnnouncementController@store')
	->name('announcement.store');
	Route::get('/announcement/edit/{id}','AnnouncementController@edit')
	->name('announcement.edit');
	Route::post('/announcement/update/{id}','AnnouncementController@update')
	->name('announcement.update');
	Route::get('/announcement/delete/{id}','AnnouncementController@delete')
	->name('announcement.delete');

	//news routes
	Route::get('/news/create','NewsController@create')->name('news.create');
	Route::post('/news/store','NewsController@store')->name('news.store');
	Route::get('/news/edit/{id}','NewsController@edit')->name('news.edit');
	Route::post('/news/update/{id}','NewsController@update')->name('news.update');
	Route::get('/news/delete/{id}','NewsController@delete')->name('news.delete');

	//scheduel routes
	Route::get('/scheduel/create','ScheduelController@create')->name('scheduel.create');
	Route::post('/scheduel/store','ScheduelController@store')->name('scheduel.store');
	Route::get('/scheduel/edit/{id}','ScheduelController@edit')->name('scheduel.edit');
	Route::post('/scheduel/update/{id}','ScheduelController@update')
	->name('scheduel.update');

	//task routes

	Route::get('/task/create/{id}','TaskController@create')->name('task.create');
	Route::get('/task/edit/{id}','TaskController@edit')->name('task.edit');
	Route::post('/task/update/{id}','TaskController@update')->name('task.update');
	Route::get('/task/delete/{id}','TaskController@delete')->name('task.delete');
	Route::post('/task/store','TaskController@store')->name('task.store');
	Route::get('/task/show/{id}','TaskController@show')->name('task.show');
	//comment
	Route::post('/comment/store','DiscussionCommentController@store')->name('comment.store');
	Route::get('/comment/delete/{id}','DiscussionCommentController@delete')->name('comment.delete');
	Route::post('/comment/update/{id}','DiscussionCommentController@update')->name('comment.update');
	//api tokens routes
	Route::get('/token/index','ApiTokenController@index')->name('apiToken.index');
	Route::get('/token/create','ApiTokenController@create')->name('apiToken.create');
	Route::post('/token/store','ApiTokenController@store')->name('apiToken.store');
	Route::get('/token/delete/{id}','ApiTokenController@delete')->name('apiToken.delete');
	Route::get('/token/edit/{id}','ApiTokenController@edit')->name('apiToken.edit');
	Route::post('/token/update/{id}','ApiTokenController@update')->name('apiToken.update');

});
/*
all those routes in this group will go through the user permission check
 */
Route::middleware(['user'])->group(function()
{

	//todo routes
		Route::get('/todo/create/{task_id}','ToDoController@create')
	->name('todo.create');
	Route::post('/todo/store/{task_id}','ToDoController@store')
	->name('todo.store');
	Route::get('/todo/edit/{id}','ToDoController@edit')
	->name('todo.edit');
	Route::post('/todo/update/{id}','ToDoController@update')
	->name('todo.update');
	Route::get('/todo/index/{id}','ToDoController@index')
	->name('todo.index');
	Route::get('/todo/show/{id}','ToDoController@show')
	->name('todo.show');
	Route::get('/todo/delete/{id}','ToDoController@delete')
	->name('todo.delete');

	//attachment routes
	Route::post('/change_pic/{user_id}','AttachmentController@changePic')->name('change_pic');

	//permission routes
	Route::get('/permission/index','PermissionController@index')->name('permission.index');

	//user routes
	Route::get('/user/index','UserController@index')->name('user.index');
	Route::post('/user/changepass/{id}','UserController@changePassword')->name('user.changePassword');

	//project routes
	Route::get('/project/index','ProjectController@index')->name('project.index');
	Route::get('/project/show/{id}','ProjectController@show')->name('project.show');
	Route::get('/project/discuss/{id}','ProjectController@discuss')->name('project.discuss');

	//announement routes
	Route::get('/announcement/index','AnnouncementController@index')
	->name('announcement.index');
	Route::get('/announcement/show/{id}','AnnouncementController@show')->name('announcement.show');

	//discussion routes
	Route::get('/discussion/index','DiscussionController@index')->name('discussion.index');

	//news routes
	Route::get('/news/index','NewsController@index')->name('news.index');
	Route::get('/news/show/{id}','NewsController@show')->name('news.show');


	//scheduel  routes
	Route::get('/scheduel/index','ScheduelController@index')->name('scheduel.index');

	//schedule todo
	Route::get('/scheduelTodo/index','ScheduelToDoController@index')
	->name('scheduelTodo.index');
	Route::get('/logout','UserController@logout')->name('user.logout');
Route::get('/dashboard','UserController@dashboard')->name('dashboard');

Route::get('/user/index','UserController@index')->name('user.index');
Route::get('/user/profile/{id}','UserController@profile')->name('user.profile');



//job routes
Route::get('/job/index','JobController@index')->name('job.index');
Route::get('/job/show/{id}','JobController@show')->name('job.show');
Route::get('/job/discuss/{id}','JobController@discuss')->name('job.discuss');

//discussion routes
Route::get('/discussion/create','DiscussionController@create')->name('discussion.create');
Route::post('/discussion/store','DiscussionController@store')->name('discussion.store');
Route::get('/discussion/edit/{id}','DiscussionController@edit')->name('discussion.edit');
Route::post('/discussion/update/{id}','DiscussionController@update')->name('discussion.update');
Route::get('/discussion/delete/{id}','DiscussionController@delete')->name('discussion.delete');
Route::get('/discussion/show/{id}','DiscussionController@show')->name('discussion.show');
Route::get('/discussion/{type}/{id}','DiscussionController@listDiscussions')->name('discussion.list');
//news routes

//scheduel  routes

Route::get('/todo/discuss/{id}','ToDoController@discuss')->name('todo.discuss');
//announcement
Route::get('/announcement/discuss/{id}','AnnouncementController@discuss')->name('announcement.discuss');

//news discuss
Route::get('/news/discuss/{id}','NewsController@discuss')->name('news.discuss');
//comments routes
Route::post('/comment/store','DiscussionCommentController@store')->name('comment.store');
Route::get('/comment/delete/{id}','DiscussionCommentController@delete')->name('comment.delete');
Route::post('/comment/update/{id}','DiscussionCommentController@update')->name('comment.update');
//task routes
Route::get('/task/discuss/{id}','TaskController@discuss')->name('task.discuss');
Route::get('/task/index/{id}','TaskController@index')->name('task.index');
Route::get('/task/show/{id}','TaskController@show')->name('task.show');

//attachemnt
Route::get('/attachment/index','AttachmentController@index')->name('attachment.index');
Route::get('/attachment/create','AttachmentController@create')->name('attachment.create');
Route::post('/attachment/store','AttachmentController@store')->name('attachment.store');
Route::get('/attachment/delete/{id}','AttachmentController@delete')->name('attachment.delete');

Route::get('/user/add/{id}','UserController@addInfo')->name('user.addinfo');
Route::post('/user/storeinfo/{id}','UserController@storeInfo')->name('user.storeinfo');
//search functionality
Route::post('search','SearchEveryWhere@search')->name('search');
//events routes 
Route::get('event/index','EventController@index')->name('event.index');
Route::get('evetn/allAsRead','EventController@allAsRead')->name('event.allAsRead');
//calendar
Route::get('calendar','CalendarController@index')->name('calendar');
//TITLE ROTUTES
Route::get('/title/index','TitleController@index')->name('title.index');
});
});
