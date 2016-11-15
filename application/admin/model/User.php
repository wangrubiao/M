<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class User extends Model {
	//设置模型表
	protected $name = 'admin';
	
	/**
	 * 返回角色组
	 * @access public
	 * @param  int       $uid|null     用户ID|all
	 * @return array
	 */
	public function group($uid = '')
	{
		
		if(empty($uid))
		{
			$array = Db('auth_group')->select();
		}else{
			$where['admin_id'] =  array('eq',$uid);
			$array = Db::view ( 'auth_user', 'admin_id,auth_group_id' )->view ( 'auth_group', [
					'aname',
					'range_id'
			], 'auth_group.id=auth_user.auth_group_id' )->where ( $where )->select();
		}
		
		return $array;
	}
	/**
	 * 返回所有权限列表
	 * @access public
	 * @param  string     $range    当前[模块/控制器/方法]
	 * @return array
	 */
	public function range(){
		$array = Db('auth_range')
		//->where('range',$range)
		->select();
		return $array;
	}
}