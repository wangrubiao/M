<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;

class LineuserController extends AuthController {
	/**
	 * 渲染列表页
	 * @return \think\response\View
	 */
	public function index() {
		$result = Db::name('line_user')->order('pubtime desc')->select();
		$this->assign('list',$result);
		return view('admin/line/userList');
	}
	/**
	 * 获取商品明细
	 * @return \think\Collection|\think\db\false|PDOStatement|string
	 */
	public function goodsList(){
		is_ajax();
		extract(input());
		$where['order_id'] = array('eq',$id);
		$result = Db::view('line_orderdetailed','*')
		->view('line_order','*','line_order.id = line_orderdetailed.order_id')
		->view('line_goods','*','line_goods.gid = line_orderdetailed.goods_id')
		->where($where)
		->select();
		return $result;
	}
	/**
	 * 取消订单
	 */
}
