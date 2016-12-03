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
use app\admin\model\MallGoods as MallGoodsModel;

class OrderController extends CommonController {
	/**
	 * 确认订单
	 * 
	 * @access public
	 * @param Request $request        	
	 * @return array
	 */
	public function confirmCart(Request $request)
	{
        //p($request->session());
       // p(unserialize(cookie('cart')));
        //unserialize() 将已序列化的字符串还原回 PHP 的值
        if(unserialize(cookie('cart'))){
            //i_array_column() 返回输入数组中某个单一列的值
            $val['mall_specfocus.id'] = array('in',i_array_column(unserialize(cookie('cart')),'sku_id'));
        }else{
            //$val['mall_specfocus.id'] = array('in',array(0),'sku_id');
            $val['mall_specfocus.id'] = array('in',array(0));
        }
        $val['mall_picture.sort'] = array('eq',1); //设置第一张主图为购物车显示
        $result = Db::view ( 'mall_specfocus', '*' )
            ->view ( 'mall_spec', 'spec_name', 'mall_spec.id = mall_specfocus.spec_id' )
            ->view ( 'mall_goods', 'title', 'mall_goods.id = mall_spec.goods_id' )
            ->view ( 'mall_picture', 'img_url', 'mall_picture.img_id = mall_goods.id' )
            ->where ( $val )
            ->select();
        foreach ($result as $key => $value) {
            foreach (unserialize(cookie('cart')) as $k => $itme) {
                if($value['id'] == $itme['sku_id']){
                    $result[$key]['num'] = $itme['num'];//设置数量
                    $result[$key]['count'] = $value['spec_mey']*$itme['num'];
                }
            }
        }
        //p($result);
        $this->assign('list',$result);
		return view('Index/confirm_cart');
	}

}
