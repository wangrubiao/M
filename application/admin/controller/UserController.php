<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class UserController extends Controller
{
	public function __construct(Request $request)
    {
		parent::__construct();
		//判断是否登陆成功
		if(empty($request->session('info.uid'))){
			$this->error('请登录再来!','Login/index');
		}
	}
    public function index(Request $request)
    {
		$this->assign('user',$request->session());
		//当前登陆用户角色名称
		$allGroup = model('User')->group($request->session('info.uid'));
		$this->assign('group',$allGroup);
		return view('admin/user/index');
		
    }
	public function user(Request $request){
		extract(input());
		Session::clear();
		echo "成功退出登录...";
	}
}
