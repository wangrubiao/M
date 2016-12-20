<?php
// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 商品 AND 分类
// +----------------------------------------------------------------------
// | Time: 2016/11/18
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\LineGroup;

class LinegoodsController extends AuthController {
	
	public function index() {
		$result = Db::name('line_goods')->select();
		$this->assign('list',$result);
		return view('admin/line/goodsList');
	}

    /**
     * 删除商品
     * @为了后期统计精度，删除暂时不支持
     */
	public function delete(){
		
	}
    /**
     * 新增商品
     * @return mixed
     */
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

    /**
     * 更新商品
     * @return mixed
     */
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

	public function calss(){
        $group = new LineGroup();
        $list = $group->calssList();
	    dump($list);
	}
}
