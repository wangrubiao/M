<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class LoginController extends Controller {
	public function index(Request $request) {
        //dump ( $request->session () );
		return view ( 'admin/user/login' );
	}
	public function login() {
		extract ( input () );
		$result = $this->validate ( input (), 'Admin.login' );
		if (true !== $result) {
			return $result;
		}
		$result = Db::name ( 'admin' )->where ( 'username', $username )->where ( 'password', md5 ( $password ) )->find ();
		if ($result) {
			Session::set ( 'info', array (
					'uid' => $result ['uid'],
					'username' => $result ['username'] 
			) );
			return true;
		} else {
			return "User name or password error!";
		}
	}
}
