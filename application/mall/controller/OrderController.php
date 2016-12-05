<?php 
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 订单
// +----------------------------------------------------------------------
// | Time: 2016/11/30
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\controller;

use think\Controller;
use think\Request;
use think\Db;

class OrderController extends CommonController {
	/**
	 * 渲染确认订单页
	 * 
	 * @access public
	 * @param Request $request        	
	 * @return array
	 */
	public function confirmCart()
	{
        $cart = controller('mall/CartController');
        $result = $cart->cartGoods();
        $this->assign('list',$result);
		return view('Index/confirm_cart');
	}

}
