<?php
use think\facade\Route;

Route::get('login','admin/login/index');
Route::rule('admin/index','admin/index/index');

//===============================================前端路由开始==========================================================

Route::rule('/news/show','index/news/show');
Route::rule('/empservice/show','index/empservice/show');
Route::rule('/jobs/show','index/jobs/show');
Route::rule('/empservice','index/empservice/index');

Route::rule('/','index/index/index');
Route::rule('/news','index/news/index');
Route::rule('/aboutus','index/aboutus/index');
Route::rule('/entservice','index/entservice/index');
Route::rule('/empservice','index/empservice/index');
Route::rule('/jobs','index/jobs/index');
Route::rule('/contact','index/contact/index');
Route::rule('/download','index/download/index');


return [

];
