<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use app\admin\model\User as UserModel;
class AuthController extends CommonController
{
	public function __construct(Request $request)
    {
    	parent::__construct($request);
		$url = $request->module().'/'.$request->controller().'/'.$request->action();
		$result = $this->check($url,$request->session('info.uid'));
		if(!$result){
			die('没有访问权限！');
			//$this->error('没有访问权限');
		}
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
		$ranges = $this->authRange($range);
		if(!$ranges){
			return false;
		}
		$group = $this->authGroup($uid);
		$result = in_array($ranges['id'],$group);
		return $result;
    }
	/**
     * 返回角色组所有权限ID
     * @access protected
     * @param  int      $uid     用户ID
     * @return array|boolean
     */
	protected function authGroup($uid){
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
	 * @param  string     $url  权限的路径地址
	 * @return boolean
	 */
	protected function authRange($url){
		$result = Db::name('auth_range')
		->where('range',$url)
		->find();
		return $result;
	}

}
