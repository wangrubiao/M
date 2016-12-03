<?php 
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 购物车
// +----------------------------------------------------------------------
// | Time: 2016/12/3
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\MallGoods as MallGoodsModel;

class CartController extends CommonController {

	/**
	 * 购物车
	 * @access public
	 * @param Request $request        	
	 * @return array
	 */
	public function index(Request $request)
	{

        //p($request->session());
        //p(unserialize(cookie('cart')));
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
        $this->assign('list',$result);
        return view('Index/cart');
	}
	/***
	 *添加购物车
	 */
	public function add()
	{
	    is_ajax();
		extract(input());
		//$sku_id  =  2;
		$sku_val['id'] = array('eq',$sku_id);
		$result = Db::name('mall_specfocus')->where($sku_val)->select();
		if($result){
			$cartList = array();
			if(cookie('cart') == null){
				$cartList[] = array(
						'sku_id' => $result[0]['id'],
						'num' => 1
				);
				cookie('cart',serialize($cartList));
			}else{
				$cartListb = unserialize(cookie('cart'));
				$list = i_array_column($cartListb,'sku_id');
				//echo gettype(array_search(2,$list));
				if(gettype(array_search($result[0]['id'],$list)) != 'boolean'){
					$cartListb[array_search($result[0]['id'],$list)]['num'] = $cartListb[array_search($result[0]['id'],$list)]['num']+1;
				}else{
					$cartListb[] =array(
							'sku_id' => $result[0]['id'],
							'num' => 1
					);
				}
				cookie('cart',serialize($cartListb));
			}
			$data['status'] = 1;
		}else{
			$data['status'] = 0;
		}
		//cookie('cart',null);
		//p(unserialize(cookie('cart')));
		return $data;
	}
	/***
	 *更改购物车
	 */
	public function less()
	{
		extract(input());
		//$sku_id  =  2;
		$sku_val['id'] = array('eq',$sku_id);
		$result = Db::name('mall_specfocus')->where($sku_val)->select();
		if($result){
			$cartList = array();
			if(cookie('cart') == null){
				$cartList[] = array(
						'sku_id' => $result[0]['id'],
						'num' => 1
				);
				cookie('cart',serialize($cartList));
			}else{
				$cartListb = unserialize(cookie('cart'));
				$list = i_array_column($cartListb,'sku_id');
				if(gettype(array_search($result[0]['id'],$list)) != 'boolean'){
					$cartListb[array_search($result[0]['id'],$list)]['num'] = $cartListb[array_search($result[0]['id'],$list)]['num']-1;
				}else{
					$cartListb[] =array(
							'sku_id' => $result[0]['id'],
							'num' => 1
					);
				}
				cookie('cart',serialize($cartListb));
			}
			$data['status'] = 1;
		}else{
			$data['status'] = 0;
		}
		//cookie('cart',null);
		//p(unserialize(cookie('cart')));
		return $data;
	}
	/**
	 * 删除购物车
	 */
	public function del()
	{
		extract(input());
		//$sku_id  =  14;
		foreach (unserialize(cookie('cart')) as $key => $value) {
			if($value['sku_id'] == $sku_id){
				//unset();
				$cart = unserialize(cookie('cart'));
				unset($cart[$key]);
				cookie('cart',serialize($cart));
			}
		}
		$data['content'] = count(unserialize(cookie('cart')));
		$data['status'] = 1;
		return $data;
	}

    /**
     * 统计总价
     */
	protected function total(){

    }
}
