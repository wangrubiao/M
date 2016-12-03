<?php 
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 购物车
// +----------------------------------------------------------------------
// | Time: 2016/11/30
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\MallGoods as MallGoodsModel;

class OrderController extends CommonController {
	/**
	 * 确认订单
	 * 
	 * @access protected
	 * @param Request $request        	
	 * @return array
	 */
	public function confirmCart(Request $request)
	{
		return view('Index/confirm_cart');
	}

}
