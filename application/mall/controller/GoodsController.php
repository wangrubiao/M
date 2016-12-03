<?php 
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 商品控制器
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

class GoodsController extends CommonController {
	/**
	 * ���Menu
	 * 
	 * @access protected
	 * @param Request $request        	
	 * @return array
	 */
	public function index(Request $request) {
		extract(input());
		$result = model('MallGoods')->goods($gid);
		//p($result);
		
		//根据主图数量组合数组
		foreach($result as $key => $item){
			$imgList[]['picture'] = $item['img_url'];
		}
		 //p($imgList);
		 
		 //获取规格信息
		 $val['goods_id']=array('eq',$result[0]['id']);
		 $spec = Db::name('mall_spec')->where($val)->select();
		 $this->assign('spec',$spec);
		 //获取SKU信息
		 $valSku['spec_id']=array('eq',$spec[0]['id']);
		 $sku = Db::name('mall_specfocus')->where($valSku)->select();
		 $this->assign('sku',$sku);
		 
		 $this->assign('img_data',$imgList);
		 $this->assign('info',$result[0]);
		 return view('Index/goods');
	}
	/*******
	 *ajax加载规格集
	 */
	public function skuList()
	{
		extract(input());
		//$spec_id=1;
		
		$val['spec_id']=array('eq',$spec_id);
		$result = Db::name('mall_specfocus')->where($val)->select();
		//p($result);
		$str = '';
		foreach($result as $item){
			$str.=' <li prop="prop_2" fid="'.$item['spec_id'].'" vid="'.$item['id'].'" class="skuli
               ">
                <a href="javascript:void(0)" title="'.$item['focus_name'].'">'.$item['focus_name'].'</a>
                </li>';
		}
		$data['status']=1;
		$data['content']=$str;
		return $data;
	}
	/*******
	 *ajax查询sku库存
	 */
	public function skuStock()
	{
		extract(input());
		//$spec_id = 1;
		//$sku_id = 1;
		$val['spec_id'] = array('eq',$spec_id);
		$val['id'] = array('eq',$sku_id);
		$result = Db::name('mall_specfocus')->where($val)->select();
		//p($result);
		$data['status'] = 1;
		$data['content'] = $result[0]['spec_stock'];
		return $data;
	}
}
