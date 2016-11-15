<?php

// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 权限管理
// +----------------------------------------------------------------------
// | Time: 2016/11/15
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class GroupController extends AuthController
{
	/**
	 * 渲染权限编辑页
	 */
	public function index(){
		is_ajax();
		extract(input());
		$group = Db('auth_group')->where('id',$id)->select();
		$this->assign('group',$group[0]);
		//dump($group);
		//输出所有权限
		$allRange = model('User')->range();
		$this->assign('range',$allRange);
		return view('admin/user/_range');
	}
	/**
	 * @Ajax编辑角色权限
	 */
	public function rangeEdit()
	{
		is_ajax();
		extract(input());
		$where['id'] = array('eq',$id);
		$result = Db('auth_group')->where($where)->setField('range_id',$range_id);
		return $result;
		
	}
    public function groupedit(Request $request)
    {	
    	return view('admin/user/_group');
    }
}
