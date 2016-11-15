<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;
class AuthController extends Controller
{
	public function __construct(Request $request)
    {
    	parent::__construct();
		//echo "权限开始执行...<br>";
		$url = $request->module().'/'.$request->controller().'/'.$request->action();
		//echo $url;
		$result = $this->check($url,$request->session('info.uid'));
		if(!$result){
			die('没有访问权限！');
			return false;
			//$this->error('没有访问权限');
		}
		//dump($result);
    }
	/**
     * 检查当前用户是否拥有权限
     * @access protected
     * @param  string    $range   权限ID
     * @param  int       $uid     用户ID
     * @return boolean
     */
	protected function check($range,$uid)
    {
		$group = $this->group($uid);
		$range = $this->range($range);
		$result = in_array($range['id'],$group);
		return $result;
    }
	/**
     * 返回角色组所有权限ID
     * @access protected
     * @param  int      $uid     用户ID
     * @return array|boolean
     */
	protected function group($uid){
		$result = Db::view('auth_user','admin_id,auth_group_id')
			->view('auth_group',['aname','range_id'],'auth_group.id=auth_user.auth_group_id')
			->where('admin_id',$uid)
			->select();
		$str = '';
		foreach($result as $item){
			$str .= ','.$item['range_id'];
		}
		$arr = explode(",",substr($str,1));
		$arr = array_unique($arr);
		return $arr;
	}
	/**
     * 返回访问地址的ID
     * @access protected
     * @param  string     $range    当前[模块/控制器/方法]
     * @return int|boolean
     */
	protected function range($range){
		$result = Db::name('auth_range')
		->where('range',$range)
		->find();
		return $result;
	}

}
