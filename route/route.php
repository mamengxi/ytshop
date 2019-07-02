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

Route::get('/','pchome/Index/index');
Route::get('/product','pchome/Display/index');
Route::get('/about','pchome/About/index');
Route::get('/contact','pchome/Contact/index');
Route::post('/contact','pchome/Contact/index');

return [

];
