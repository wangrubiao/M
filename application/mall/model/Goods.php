<?php

namespace app\mall\model;

use think\Model;
use think\Db;

class MallGoods extends Model {
	//设置模型表
	//protected $name = 'mall_goods';
	
	public function userAll(){

	}
	/**
	 * 返回角色组(含多个角色)
	 * @access public
	 * @param  int       $uid|null     用户ID|null
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
}