<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class User extends Model {
	//设置模型表
	protected $name = 'admin';
	
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
	/**
	 * 返回权限所有ID
	 * @access protected
	 * @param  int      $uid     用户ID|null
	 * @return array|boolean
	 */
	public function rangeList($uid=""){
		if($uid != null){
			$result = $this->group($uid);
			$str = '';
			foreach($result as $item){
				$str .= ','.$item['range_id'];
			}
			$arr = explode(",",substr($str,1));
			$arr = array_unique($arr);
		}else{
			$arr = Db('auth_range')->select();
		}
		
		return $arr;
	}
}