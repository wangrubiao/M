<?php

// +----------------------------------------------------------------------
// | W+ [ Not the same fireworks ]
// +----------------------------------------------------------------------
// | Describe: 公共控制器
// +----------------------------------------------------------------------
// | Time: 2016/11/18
// +----------------------------------------------------------------------
// | Author: 64941334@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class CommonController extends Controller {
	public function __construct(Request $request) {
		parent::__construct ();
		//dump($request->session ());
		//echo count($request->session ( 'info.uid' ));
		// 判断是否登陆成功
		if (count($request->session ( 'info.uid' )) != 1) {
			$this->redirect('Login/index');
		}
		// 模板渲染路径/配合JS选中状态
		$url = $request->module().$request->controller().$request->action();
		$this->assign ( 'action', strtolower($url));
		// 全局模板渲染会员信息
		$this->assign ( 'user', $request->session () );
		// 当前登陆用户角色名称
		$infoGroup = model ( 'User' )->group ( $request->session ( 'info.uid' ) );
		$rangeList = model ( 'User' )->rangeList ( $request->session ( 'info.uid' ) );
		$this->assign ( 'infoGroup', $infoGroup );
		$this->assign ( 'rangeList', $rangeList );
		// 输出Menu列表
		$this->assign ( 'menu', $this->generateTree ( $request ) );
	}
	/**
	 * 输出Menu
	 * 
	 * @access protected
	 * @param Request $request        	
	 * @return array
	 */
	protected function generateTree(Request $request) {
		// 所有的权限ID
		$rangeList = model ( 'User' )->rangeList ( $request->session ( 'info.uid' ) );
		// 属于菜单的权限ID
		$all = Db::name( 'auth_range' )->where ( 'type=1' )->select ();
		//p($all);
		//过滤掉没有权限的菜单 并输出对应权限
		$rangeList = model ( 'User' )->rangeList ( $request->session ( 'info.uid' ) );
		//p($rangeList);
		foreach ($all as $kvo=>$vo){
			foreach ($rangeList as $kv=>$v){
				if($vo['id'] == $v){
					$list[] = $all[$kvo];
				}
			}
		}
		if(!empty($list)){
		//重新排序数组Key从1开始排序
		foreach ( $list as $key => $vo ) {
			$items [$vo ['id']] = array (
					'id' => $vo ['id'],
					'title' => $vo ['title'],
					'range' => $vo ['range'],
					'fid' => $vo ['fid'],
					'type' => $vo ['type'] 
			);
		}
		//输出菜单树级格式
		$tree = array ();
		foreach ( $items as $item ) {
			if (isset ( $items [$item ['fid']] )) {
				$items [$item ['fid']] ['son'] [] = &$items [$item ['id']];
			} else {
				$tree [] = &$items [$item ['id']];
			}
		}
		//p($tree);
		return $tree;
		}
		
	}
}
