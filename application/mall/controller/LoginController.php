<?php
namespace app\mall\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class LoginController extends CommonController
{
	/**
	 * 后台主页
	 * @param Request $request
	 * @return \think\response\View
	 */
    public function index(Request $request)
    {
		echo "准备开发mall...";
    }
    /**
     * ajax验证是否登录
     * @return number
     */
    public function ajaxCheck(Request $request)
    {
   		is_ajax();
   		extract(input());
   		// 判断是否登陆成功
   		if (count($request->session ( 'mall_info.uid' )) != 1) {
   			$data['status'] = 0;
   		}else{
   			$data['status'] = 1;
   		}
   		return $data;
    }
	/**
	 * 登陆验证
	 * @return number
	 */
    public function check()
    {
    	extract(input());
    	$where['username'] = array('eq',$username);
    	$where['password'] = array('eq',md5($password));
    	$result = Db::name('mall_user')->where($where)->find();
    	if($result){
    		$data['status'] = 1;
    		//生成session
    		Session::set ( 'mall_info', array (
    				'uid' => $result ['uid'],
    				'username' => $result ['username']
    		) );
    		
    	}else{
    		$data['status'] = 0;
    	}
		return $data;
    }
	public function user(Request $request){
		extract(input());
		Session::clear();
		echo "成功退出登录...";
	}
}
