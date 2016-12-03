<?php

// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 公共控制器
// +----------------------------------------------------------------------
// | Time: 2016/11/18
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\controller;

use think\Controller;
use think\Request;
use think\Db;

class CommonController extends Controller {
	public function __construct(Request $request) {
		parent::__construct ();
		//p($request->session());
		/*
		// 判断是否登陆成功
		if (count($request->session ( 'info.uid' )) != 1) {
			$this->redirect('Login/index');
		}
		*/
		$this->assign('username',$request->session('mall_info.username'));
	}
	/**
	 * 输出Menu
	 * 
	 * @access protected
	 * @param Request $request        	
	 * @return array
	 */
	protected function generateTree(Request $request) {
	
	}
}
