<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate {
	/**
	 * 登录验证规则
	 */
	protected $rule = [ 
			[ 
					'username',
					'require|require',
					'User name cannot be empty!' 
			],
			[ 
					'password',
					'require|require',
					'Password can not be empty!' 
			] 
	];
}
