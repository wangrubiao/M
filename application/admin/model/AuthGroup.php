<?php

namespace app\admin\model;

use think\Model;

class AuthGroup extends Model {
	// �������ݱ�����ǰ׺��
	// protected $name = 'admin';
	
	// �����������
	public function users() {
		// 用户
		// return $this->hasMany('admin','uid');
		return $this->belongsToMany ( 'User', 'w_auth_user' );
	}
}