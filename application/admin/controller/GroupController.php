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
use think\Validate;
use app\admin\model\User as UserModel;

class GroupController extends AuthController {
	/**
	 * 渲染权限编辑页 and 保存编辑
	 */
	public function index() {
		is_ajax ();
		extract ( input () );
		if ($type == 'load') {
			$group = Db ( 'auth_group' )->where ( 'id', $id )->select ();
			//p($group);
			$this->assign ( 'group', $group [0] );
			// 输出所有权限
			$allRange = model ( 'User' )->rangeList();
			//p($allRange);
			$this->assign ( 'range', $allRange );
			return view ( 'admin/user/_range' );
		} else {
			//保存编辑
			$where ['id'] = array ('eq',$id);
			$result = Db ( 'auth_group' )->where ( $where )->setField ( 'range_id', $range_id );
			return $result;
		}
	}
	/**
	 * Ajax Request
     * 角色编辑
     * @access public
     * @param  int       $id         角色ID
     * @param  string    $aname      角色名称
     * @param  string    $describe   角色描述
     * @return boolean
     */
	public function groupEdit() {
		is_ajax ();
		extract(input());
		$data['aname'] = $aname;
		$data['describe'] = $describe;
		//验证规则
		$result = $this->validate ( input (), 'Admin.group' );
		if (true !== $result) {
			$data['status'] = 0;
			$data['content'] = $result;
			return $data;
		}
		//更新操作
		$result = Db::name( 'auth_group' )->where( 'id', $id )->update($data);
		$data['status'] = 1;
		$data['content'] = '编辑成功';
		return $data;
	}
	/**
	 * Ajax Request
	 * 角色创建
	 * @access public
	 * @param  string    $aname      角色名称
	 * @param  string    $describe   角色描述
	 * @return boolean
	 */
	public function groupAdd() {
		is_ajax ();
		extract(input());
		$data['aname'] = $aname;
		$data['describe'] = $describe;
		//验证规则
		$result = $this->validate ( input (), 'Admin.group' );
		if (true !== $result) {
			$data['status'] = 0;
			$data['content'] = $result;
			return $data;
		}
		//创建操作
		$result = Db ( 'auth_group' )->insert($data);
		$data['status'] = 1;
		$data['content'] = '创建成功';
		return $data;
		
	}
	/**
	 * Ajax Request
	 * 用户创建
	 * @access public
	 * @param  string    $username   用户名称
	 * @param  string    $password   用户密码
	 * @param  string    $mailbox    用户邮箱
	 * @param  string    $name       用户名称
	 * @return boolean
	 */
	public function createUser() {
		is_ajax ();
		extract(input());
		$data['name'] = $name;
		$data['username'] = $username;
		$data['password'] = md5(trim($password));
		$data['mailbox'] = $mailbox;
		$data['jointime'] = time();
		//验证规则
		$result = $this->validate ( input (), 'Admin.createUser' );
		if (true !== $result) {
			$data['status'] = 0;
			$data['content'] = $result;
			return $data;
		}
		//创建操作
		$result = Db::name( 'admin' )->insert($data);
		$data['status'] = 1;
		$data['content'] = '创建成功';
		return $data;
		
	}
	/**
	 * Ajax Request
	 * 用户编辑
	 * @access public
	 * @param  string    $username   用户名称
	 * @param  string    $password   用户密码
	 * @param  string    $mailbox    用户邮箱
	 * @param  string    $name       用户名称
	 * @return boolean
	 */
	public function editUser() {
		is_ajax ();
		extract(input());
		$data['name'] = $name;
		trim($password)!=""?$data['password'] = md5(trim($password)):$password;
		$data['mailbox'] = $mailbox;
		$data['jointime'] = time();
		//p($data);
		//验证规则
		$result = $this->validate ( input (), 'Admin.editUser' );
		if (true !== $result) {
			$data['status'] = 0;
			$data['content'] = $result;
			return $data;
		}
		//编辑操作
		$result = Db::name( 'admin' )->where( 'uid', $id )->update($data);
		$data['status'] = 1;
		$data['content'] = '编辑成功';
		return $data;
	
	}
	/**
	 * Ajax Request
	 * 用户角色分配渲染 | 角色分配
	 * @access public
	 * @param  string    $username   用户名称
	 * @param  string    $password   用户密码
	 * @param  string    $mailbox    用户邮箱
	 * @param  string    $name       用户名称
	 * @return boolean
	 */
	public function choseGroup(Request $request){
		is_ajax ();
		extract(input());
		if(empty($type)){
			//ajax渲染数据
			$allgroup = model('User')->group();
			$userGroup = model('User')->group($uid);
			foreach ($allgroup as $key=>$vo){
				foreach ($userGroup as $v){
					if($vo['id']==$v['id']){
						$allgroup[$key]['state'] = 'checked';
					}
				}
			}
			return $allgroup;
		}else{
			//保存更改角色
			Db::name('auth_user')->where('admin_id',$uid)->delete();
			if(!empty($group_id)){
				foreach($group_id as $key=>$vo){
					$data[$key]['admin_id'] = $uid;
					$data[$key]['auth_group_id'] = $vo;
				}
				Db::name('auth_user')->insertAll($data);
			}
			$data['status'] = 1;
			$data['content'] = '权限分配成功';
			return $data;
		}
		
		
	}
}
