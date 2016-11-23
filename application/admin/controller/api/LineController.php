<?php

namespace app\admin\controller\api;

use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class LineController extends Controller {
	public function index(Request $request) {

	}
	public function goods() {
		extract ( input () );
		$result = Db::name('line_goods')->select();
		//筛选分类
		$type = array(
				'type-1'=>1,
				'type-2'=>2,
				'type-3'=>3,
				'type-4'=>4,
				'type-5'=>5
		);
		foreach($type as $key=>$vo){
			foreach ($result as $k=>$v){
				if($vo == $v['group']){
					$list[$key][] = $result[$k];
				}	
			}
		}
		//p($list);
		return json($list);
	}
}
