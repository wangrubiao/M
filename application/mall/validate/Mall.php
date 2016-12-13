<?php

// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 自动验证
// +----------------------------------------------------------------------
// | Time: 2016/12/11
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\validate;

use think\Validate;

class Mall extends Validate {
	/**
	 * 验证规则
	 * @var array
	 */
	protected $rule = [ 
			[ 
					'name',
					'require|require',
					'收货人不能为空'
			], //收货人
			[ 
					'phone',
					'require|require',
					'手机号码不能为空'
			],//验证手机
            [
                    'phone',
                    'checkPhone',
                    '手机号码错误'
            ],//验证手机
            [
                    'fixed',
                    'checkFixed',
                    '固话格式错误'
            ],//验证固话
            [
                'email',
                'email',
                '邮箱格式不正确'
            ],//验证邮箱
            [
                'allcity',
                'checkCity',
                '省份地区选择不完整'
            ],//验证地区
            [
                'execute',
                'require|require',
                '操作类型不存在'
            ],//操作类型
			
	];
	/**
	 * 验证场景
	 * @var array
	 */
	protected $scene = [ 
		'address' => [
				'name',
				'phone',
                'fixed',
            'execute',
            'allcity',
            'email'
		],//添加收货地址
    ];
    /**
     * 验证地区是否合法
     * @param $value  验证表单字段值
     * @param $rule   验证规则组
     * @param $data   所有表单字段
     * @return bool|string
     */
    protected function checkCity($value,$rule,$data)
    {
        $city = explode('/',$value);
        if(count($city) != 3){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 手机号码验证
     * @param $value  验证表单字段值
     * @param $rule   验证规则组
     * @param $data   所有表单字段
     * @return bool|string
     */
    protected function checkPhone($value,$rule,$data)
    {
        if(preg_match("/^1[34578]{1}\d{9}$/",$value)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 固话验证
     * @param $value  验证表单字段值
     * @param $rule   验证规则组
     * @param $data   所有表单字段
     * @return bool|string
     */
    protected function checkFixed($value,$rule,$data)
    {
        if(preg_match("/\d{3}-\d{8}|\d{4}-\d{7}/",$value)){
            return true;
        }else{
            return false;
        }
    }
}
