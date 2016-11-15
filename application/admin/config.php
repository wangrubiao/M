<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 模板资源路径
    'PUBLIC'        => $_SERVER['SERVER_NAME'].'/static',
	//开启session服务
	'session'        => [
		'prefix'         => 'think',
		'type'           => '',
		'auto_start'     => true,
	],
	// 控制器类后缀
	'controller_suffix'      => true,
];
