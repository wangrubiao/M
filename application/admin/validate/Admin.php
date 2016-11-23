<?php

// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 自动验证
// +----------------------------------------------------------------------
// | Time: 2016/11/15
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate {
	/**
	 * 验证规则
	 * @var array
	 */
	protected $rule = [ 
			[ 
					'username',
					'require|require',
					'User name cannot be empty!' 
			], //登录账号
			[ 
					'password',
					'require|require',
					'Password can not be empty!' 
			],//登录密码
			[ 
					'aname',
					'require|require',
					'角色名称不能为空!' 
			],//角色名称
			[ 
					'describe',
					'require|require',
					'角色描述不能为空!' 
			],//角色描述
			[
					'mailbox',
					'email',
					'邮箱格式不正确!'
			],//用户邮箱
			[ 
					'name',
					'require|require',
					'名称不能为空!' 
			],//用户名称
			
	];
	/**
	 * 验证场景
	 * @var array
	 */
	protected $scene = [ 
		'login' => [ 
				'username',
				'password' 
		],
		'group' => [ 
				'aname',
				'describe' 
		] ,
		'createUser' => [ 
				'username',
				'password',
				'mailbox',
				'name'
		],
		'editUser' => [
				'username',
				'mailbox',
				'name'
		],

		
];
}
