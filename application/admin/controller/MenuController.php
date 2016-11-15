<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class MenuController extends Controller
{
	public function __construct(Request $request)
    {
		parent::__construct();
		//判断是否登陆成功
		if(empty($request->session('info.uid'))){
			$this->error('请登录再来!','Login/index');
		}
		$this->assign('user',$request->session());
		//当前登陆用户角色名称
		$allGroup = model('User')->group($request->session('info.uid'));
		//dump($allGroup);
		$this->assign('group',$allGroup);
	}
    //权限列表
    public function authList()
    {
    	return view('admin/user/authList');
    }
    //角色组列表
    public function authGroup(Request $request)
    {
    	//返回所有角色
    	$allGroup = model('User')->group();
    	$this->assign('group',$allGroup);
    	/*//输出所有权限
    	$allRange = model('User')->range();
    	$this->assign('range',$allRange);
    	//dump($allRange);
    	
    	 *显示权限树 (需优化) 
    	 *
    	foreach($allRange as $item){
    		if($item['type'] == 1){
    			echo $item['title']."<br>";
    			foreach($allRange as $v){
    				if($v['fid'] == $item['id']){
    					echo "-".$v['title']."<br>";
    					foreach($allRange as $c){
    						if($c['fid'] == $v['id']){
    							echo "--".$c['title']."<br>";
    						}
    						
    					}
    				}
    			}
    		}
    	}
    	*/
    	return view('admin/user/authGroup');
    }
}
