<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class IndexController extends AuthController
{
	/**
	 * 后台主页
	 * @param Request $request
	 * @return \think\response\View
	 */
    public function index(Request $request)
    {
		//当前登陆用户角色名称
		$allGroup = model('User')->group($request->session('info.uid'));
		$this->assign('group',$allGroup);
		return view('admin/user/index');
    }
    /**
     * 会员管理页
     * @return \think\response\View
     */
    public function userList()
    {
    	$list = model('User')->select();
    	$this->assign('list',$list);
    	return view('admin/user/userList');
    }
    /**
     * 角色管理页
     * @return \think\response\View
     */
    public function groupList()
    {
    	$list = model('User')->group();
    	$this->assign('list',$list);
    	return view('admin/user/groupList');
    }
    /**
     * 角色权限分配页
     * @param Request $request
     * @return \think\response\View
     */
    public function groupRange(Request $request)
    {
    	//返回所有角色
    	$allGroup = model('User')->group();
    	$this->assign('group',$allGroup);
    	return view('admin/user/groupRange');
    }
	public function user(Request $request){
		extract(input());
		Session::clear();
		echo "成功退出登录...";
	}
}
