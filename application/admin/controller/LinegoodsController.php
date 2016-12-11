<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class LinegoodsController extends AuthController {
	
	public function index() {
		$result = Db::name('line_goods')->select();
		$this->assign('list',$result);
		return view('admin/line/goodsList');
		//p($result);
	}
	public function delete(){
		
	}
	public function insert(){
		is_ajax();
		extract(input());
		$data['name'] = trim($name);
		$data['group'] = $group;
		$data['gds_price'] = $gds_price;
		if($data['name'] == null){
			$data['status'] = 0;
			$data['content'] = '商品名称不能为空.';
		}else if($data['gds_price'] == null){
			$data['status'] = 0;
			$data['content'] = '商品价格不能为空.';
		}else{
			Db::name('line_goods')->insert($data);
			//p($result);
			$data['status'] = 1;
			$data['content'] = '新增成功.';
		}
		return $data;
	}
	public function update(){
		is_ajax();
		extract(input());
		$data['name'] = trim($name);
		$data['group'] = $group;
		$data['gds_price'] = $gds_price;
		if($data['name'] == null){
			$data['status'] = 0;
			$data['content'] = '商品名称不能为空.';
		}else if($data['gds_price'] == null){
			$data['status'] = 0;
			$data['content'] = '商品价格不能为空.';
		}else{
			Db::name('line_goods')->where('gid = '.$gid)->update($data);
			//p($result);
			$data['status'] = 1;
			$data['content'] = '更新成功.';
		}
		return $data;
	}
}
