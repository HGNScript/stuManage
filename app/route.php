<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::rule('adminLogin','admin/Login/login');
//Route::rule('loginCtrl','admin/Login/loginCtrl');
Route::rule('adminIndex','admin/Index/index');

Route::rule('stuLogin','student/Login/login');
Route::rule('stuIndex','student/Index/index');
Route::rule('Stuleave','student/Stuleave/index');
Route::rule('Stugrant','student/Stugrant/index');
Route::rule('Stuinfo','student/Stuinfo/index');
Route::rule('Stureduction','student/Stureduction/index');

Route::rule('tchLogin','teacher/Login/login');
Route::rule('tchIndex','teacher/Index/index');






