<?php
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: GoodsModel
// +----------------------------------------------------------------------
// | Time: 2016/11/30
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\mall\model;

use think\Model;
use think\Db;

class MallGoods extends Model {
	//设置模型表
	//protected $name = 'mall_goods';
	
	public function userAll(){
	}
	/**
	 * 返回商品信息
	 * @access public
	 * @param  int       $gid|null    商品ID|null
	 * @return array
	 */
	public function goods($gid = '')
	{
			$where['mall_goods.id'] =  array('eq',$gid);
			$array = Db::view ( 'mall_goods', '*' )
						->view ( 'mall_type', 'type_name', 'mall_type.id = mall_goods.type' )
						->view ( 'mall_picture', 'img_url', 'mall_picture.img_id = mall_goods.id' )
						->where ( $where )
						->select();
		
		
		return $array;
	}
}