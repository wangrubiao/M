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
use think\Validate;

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
	    //输出用户地址
        $where['uid'] = array('eq',$this->uid);
        $address = Db::name('mall_address')->where($where)->select();
        foreach($address as $k=>$vo){
           if($vo['fixed'] != null){
                   $address[$k]['fixeds'] = explode('-',$vo['fixed']);
           }
        }
        //p($address);
        $this->assign('address',$address);
	    //输出购买商品
        $cart = controller('mall/CartController');
        $result = $cart->cartGoods();
        $this->assign('list',$result);
		return view('Index/confirm_cart');
	}

    /**
     * 收货人地址操作
     * @access public
     * @param  $execute    create|update|delete
     * @return mixed
     */
    public function address(){
	    extract(input());
        //摧毁非数据表字段和创建
        $data = input();
        $data['uid'] = $this->uid;
        $where['id'] = array('eq',$id);
        unset($data['id']);
        unset($data['pn3']);
        unset($data['allcity']);
        unset($data['execute']);
        if($execute != 'delete'){
            //验证规则
            $validate = $this->validate(input(),'Mall.address');
            if(true !== $validate){
                $data['status'] = 0;
                $data['content'] = $validate;
                return $data;
            }
            //数据交互
            if($execute == 'create'){
                if(Db::name('mall_address')
                        ->where(array('uid'=>$this->uid))
                        ->count() > 5){
                    $data['status'] = 0;
                    $data['content'] = '最多添加地址5个';
                }else{
                    Db::name('mall_address')
                        ->insert($data);
                    $data['status'] = 1;
                    $data['content'] = '新增地址成功';
                }
            }else if($execute == 'update'){
                Db::name('mall_address')
                    ->where($where)
                    ->update($data);
                $data['status'] = 1;
                $data['content'] = '修改地址成功';
            }
        }else{
            if($execute == 'delete'){
                Db::name('mall_address')
                    ->where($where)
                    ->delete();
                $data['status'] = 1;
                $data['content'] = '删除地址成功';
            }
        }
        return $data;

    }
}
