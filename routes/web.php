<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test','ApiController@test');
/**登录操作 */
$router->post('/login','ApiController@login');

/*上传校徽*/
$router->post('/upload','ApiController@upload');
/*添加学校*/
$router->post('/addSchool',['middleware' => 'token','uses'=>'ApiController@addSchool']);
/*添加学校*/
$router->post('/getSchool',['middleware' => 'token','uses'=>'ApiController@getSchool']);
$router->post('/getMajors',['middleware' => 'token','uses'=>'ApiController@getMajorsBySchoolId']);
$router->post('/addMajor',['middleware' => 'token','uses'=>'ApiController@addMajor']);
$router->post('/delMajor',['middleware'=>'token','uses'=>'ApiController@delMajor']);
$router->post('/getClassList',['middleware'=>'token','uses'=>'ApiController@getClassList']);
// 根据id获取专业的名称
$router->post('/getClassById',['middleware'=>'token','uses'=>'ApiController@getClassById']);


