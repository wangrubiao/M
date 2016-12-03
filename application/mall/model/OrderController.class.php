<?php
/***
*@ Order Controller
*@ Wangrubiao
*@ 2015
*/
namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
	protected function _initialize()
	{
		parent::_initialize();
		//$power = explode(',',session('info.power'));
		//p($power);
		//parent::jurisdiction(array(1,2,3,4));
	}
    public function index()
	{
		$this->display('Index/index');
    }
    public function addShop()
	{
		$this->display('Index/Shop/addShop');
    }
    /*****
	*未发货订单列表  转为复制到Exlel的样式页面
	*/
	public function orderExcel()
	{
		extract(I());
	 	$Order  = D("Order");
		//信息总统计
		$now = date(strtotime(date('Y-m-d')));
		$data['order'] = array('egt',$now);
		$data['type'] = array('neq',0);
		$data['paystate'] = array('neq',0);
		$nowSum = $Order->where($data)->sum('mey');
		$nowAvg = $Order->where($data)->avg('mey');
		$nowCount = $Order->where($data)->count();
		//货到付款订单统计
		$csahArr['order'] = array('egt',$now);
		$csahArr['paytype'] = array('eq',0);
		$csahArr['type'] = array('neq',0);
		$csah = $Order->where($csahArr)->sum('mey'); 
		$csahCount = $Order->where($csahArr)->count();
		$this->assign('csahCount',$csahCount);//订单总数
		$this->assign('csahSum',number_format($csah,2));//订单总金额
		//支付宝订单统计
		$alipayArr['order'] = array('egt',$now);
		$alipayArr['paytype'] = array('eq',1);
		$alipayArr['paystate'] = array('eq',1);
		$alipay = $Order->where($alipayArr)->sum('mey');
		$alipayCount = $Order->where($alipayArr)->count();
		$this->assign('alipayCount',$alipayCount);//订单总数
		$this->assign('alipaySum',number_format($alipay,2));//订单总金额
		//Page输出
		$count = $Order->where('type=1')->count();
		$Page = $this->PagesStyle($count,10);
		$show = $Page->show();
		//数据模板渲染
		$list = $Order->where('wx_order.type=1')
		->field('wx_order.id,wx_order.goods_id,wx_order.order,wx_order.order_title,wx_order.type,wx_order.product_img,
				wx_order.product,wx_order.size,wx_order.consignee,wx_order.mob,wx_order.address,wx_order.mey,wx_order.paytype,wx_order.paystate,
				wx_order.guest,wx_order.ip,wx_order.countip,wx_order.position,wx_order.register,
				wx_bid_rule.rule_name,wx_bid_ressize.describe,wx_bid_resources.rsename,wx_bid_platform.platname
				')
		->join('wx_bid_rule ON wx_order.position = wx_bid_rule.rule_name','LEFT')
		->join('wx_bid_ressize ON wx_bid_rule.size_id = wx_bid_ressize.id','LEFT')
		->join('wx_bid_resources ON wx_bid_ressize.rsenid = wx_bid_resources.id','LEFT')
		->join('wx_bid_platform ON wx_bid_resources.platform_id = wx_bid_platform.id','LEFT')
		->order('wx_order.id desc')
		->limit($Page->firstRow.','.$Page->listRows)
		->select();
		//p($list);
		$this->assign('list',$list);
		//快递选择输出
		$express  = M('express');
		$exp  = $express->where()->select();
		$this->assign('express',$exp);
		//模板渲染
		$this->assign('page',$show);// 分页输出
		$this->assign('nowCount',$nowCount);//订单总数
		$this->assign('nowAvg',number_format($nowAvg,2));//订单均价
		$this->assign('nowSum',number_format($nowSum,2));//订单总金额
		$this->display('Index/Order/orderExcel');
	}
	/*****
	*未发货订单列表
	*/
	public function orderList()
	{
		//die(111111);
		extract(I());
	 	$Order  = D("Order");
		//信息总统计
		$now = date(strtotime(date('Y-m-d')));
		$data['order'] = array('egt',$now);
		$data['type'] = array('neq',0);
		$data['paystate'] = array('neq',0);
		$nowSum = $Order->where($data)->sum('mey');
		$nowAvg = $Order->where($data)->avg('mey');
		$nowCount = $Order->where($data)->count();
		//货到付款订单统计
		$csahArr['order'] = array('egt',$now);
		$csahArr['paytype'] = array('eq',0);
		$csahArr['type'] = array('neq',0);
		$csah = $Order->where($csahArr)->sum('mey'); 
		$csahCount = $Order->where($csahArr)->count();
		$this->assign('csahCount',$csahCount);//订单总数
		$this->assign('csahSum',number_format($csah,2));//订单总金额
		//支付宝订单统计
		$alipayArr['order'] = array('egt',$now);
		$alipayArr['paytype'] = array('eq',1);
		$alipayArr['paystate'] = array('eq',1);
		$alipay = $Order->where($alipayArr)->sum('mey');
		$alipayCount = $Order->where($alipayArr)->count();
		$this->assign('alipayCount',$alipayCount);//订单总数
		$this->assign('alipaySum',number_format($alipay,2));//订单总金额
		//Page输出
		$count = $Order->where('type=1')->count();
		$Page = $this->PagesStyle($count,10);
		$show = $Page->show();
		//数据模板渲染
		$list = $Order->where('wx_order.type=1 and wx_goods_picture.sort=1')
		->field('wx_order.id,wx_order.goods_id,wx_order.order,wx_order.order_title,wx_order.type,wx_order.product_img,
				wx_order.product,wx_order.size,wx_order.consignee,wx_order.mob,wx_order.address,wx_order.mey,wx_order.paytype,wx_order.paystate,
				wx_order.guest,wx_order.ip,wx_order.countip,wx_order.position,wx_order.register,
				wx_bid_rule.rule_name,wx_bid_ressize.describe,wx_bid_ressize.size_val,wx_bid_resources.rsename,wx_bid_platform.platname,
				wx_goods_picture.img_url
				')
		->join('wx_goods_picture ON wx_order.goods_id = wx_goods_picture.img_id','LEFT')
		->join('wx_bid_rule ON wx_order.position = wx_bid_rule.rule_name','LEFT')
		->join('wx_bid_ressize ON wx_bid_rule.size_id = wx_bid_ressize.id','LEFT')
		->join('wx_bid_resources ON wx_bid_ressize.rsenid = wx_bid_resources.id','LEFT')
		->join('wx_bid_platform ON wx_bid_resources.platform_id = wx_bid_platform.id','LEFT')
		->order('wx_order.id desc')
		->limit($Page->firstRow.','.$Page->listRows)
		->select();
		//p($list);
		$this->assign('list',$list);
		//快递选择输出
		$express  = M('express');
		$exp  = $express->where()->select();
		$this->assign('express',$exp);
		//模板渲染
		$this->assign('xsd','0.05');// 设置支付宝服务费
		$this->assign('page',$show);// 分页输出
		$this->assign('nowCount',$nowCount);//订单总数
		$this->assign('nowAvg',number_format($nowAvg,2));//订单均价
		$this->assign('nowSum',number_format($nowSum,2));//订单总金额
		$this->display('Index/Order/orderList');
	}
	//点击发货后弹窗查询订单数据
	public function selectOrder()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$order  = M('Order');
		$data['id']=array('eq',$id);
		$result = $order->where($data)->select();
		//礼品输出
		$gift  = M('gift_spec');
		$val['goods_id']=array('eq',$result[0]['goods_id']);
		$resultB = $gift->where($val)
		->join('wx_gift_specfocus ON wx_gift_spec.id = wx_gift_specfocus.gift_id')
		->select();
		if($resultB){
			$str='<select class="form-control2">
              <option value="0">是否赠送礼品</option>';
			foreach ($resultB as $key => $value) {
				$str.='<option value="'.$value['id'].'">'.$value['gift_name'].'-'.$value['gift_spec'].'</option>';
			}
			$str.='</select>';
			$result[]['gift']=$str;
			//p($result);
		}else{
			// p($result);
			$result[]['gift']='';

		}
		$this->ajaxReturn($result);
       
	}
	//点击订单确认发货完成
	public function checkOrder()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		if($express=='0' or $waybill==""){
			$data['status'] = 0;
			$this->ajaxReturn($data);
		}
		if(!ctype_alnum($waybill)){
				$data['status'] = 2;
				$this->ajaxReturn($data);
		}
		/*
		if(!preg_match("/^\d*$/",$freight)){
				$data['status'] = 3;
				$this->ajaxReturn($data);
		}
		*/
		//客户号码推送
		//客户号码推送
		$nameID = substr($mob,-4);
		JPush("number",array("name"=>"客户@".$name."@".$nameID, "mob"=>($mob-365)));
		
		$detailed = M('order_detailed');
		$detailedArr = $detailed->where(array('order_id'=>$id))->select();
		$Model = D('Order');
		$goodsVal = M("goods_specfocus");
		
		if(empty($gift)){
			//没有赠品状态
			$result = $Model->upOrder($order,$express,$waybill,$freight); 
			$data['status'] = 1;//$result;
			//$goodsVal-> where(array('id'=>$detailedArr[0]['size_id']))->setDec('spec_stock');
			$this->ajaxReturn($data);
		}else{
			//有赠品状态
			$result = $Model->upOrder($order,$express,$waybill,$freight); 
			$data['status'] = 1;//$result;
			$giftVal = M("gift_specfocus");
			//$giftVal-> where(array('id'=>$gift))->setDec('gift_stock');
			//$goodsVal-> where(array('id'=>$detailedArr[0]['size_id']))->setDec('spec_stock');
			//这里将产生出库清单
			$this->ajaxReturn($data);
		}
		
	}
	/*****
	*移动订单到回收站
	*/
	public function trash()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Model =  D('Order');
		$result = $Model->trashOrder($id);
		if($result){
			$data['status'] = 1;
		}else{
			$data['status'] = 0;
		}
		$this->ajaxReturn($data);
	}/*****
	*移动订单到待发货状态
	*/
	public function trashAgain()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Model =  D('Order');
		$result = $Model->trashOrder($id,1);
		if($result){
			$data['status'] = 1;
		}else{
			$data['status'] = 0;
		}
		$this->ajaxReturn($data);
	}
	/*****
	*已发货订单列表
	*/
	public function ordeIssue()
	{
		extract(I());
	 	$Order  = D("Order");
		//信息统计
		$val['type']=array('in','2,3,4');
		$val['sort'] = array('eq',1);
		$freightSum = $Order->where($val)->sum('freight'); //总运费
		$nowAvg = $Order->where($val)->avg('freight');	//平均运费
		$nowCount = $Order->where($val)->count();	//总订单数
		$refused = $Order->where('type=3')->count();	//签收单数
		$sign = $Order->where('type=4')->count();	//拒签单数
		//分页输出
		$count = $Order->where($val)->count();
		$Page = new\Think\Page($count,10);
		$Page -> setConfig('header','<li class="infoNo"><a href="#">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</a></li>');
		$Page -> setConfig('prev','上一页');
		$Page -> setConfig('next','下一页');
		$Page -> setConfig('theme','%HEADER% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
		$show = $Page->show();
		//数据输出
		$list = $Order
		->alias('o')
		->where($val)
		->field('o.id,o.order,o.order_title,o.product_img,o.goods_id,o.product,o.size,o.consignee,o.mob,o.address,o.mey,o.guest,o.type,o.ip,o.countip,
			o.express,o.waybill,o.register,o.sendtime,wx_express.exp_name,o.freight,
			o.position,o.paytype,o.paystate,
			wx_bid_rule.rule_name,wx_bid_ressize.describe,wx_bid_ressize.size_val,
			wx_bid_resources.rsename,wx_bid_platform.platname,
			wx_goods_picture.img_url
			')
		//->join('__ADMIN__ ON o.uid = __ADMIN__.id')
		->join('__EXPRESS__ ON o.express = __EXPRESS__.id')
		->join('wx_goods_picture ON o.goods_id = wx_goods_picture.img_id','LEFT')
		->join('wx_bid_rule ON o.position = wx_bid_rule.rule_name','LEFT')
		->join('wx_bid_ressize ON wx_bid_rule.size_id = wx_bid_ressize.id','LEFT')
		->join('wx_bid_resources ON wx_bid_ressize.rsenid = wx_bid_resources.id','LEFT')
		->join('wx_bid_platform ON wx_bid_resources.platform_id = wx_bid_platform.id','LEFT')
		->order('o.sendtime desc')
		->limit($Page->firstRow.','.$Page->listRows)
		->select();
		//p($list);
		//快递选择输出
		$express  = M('gift_spec');
		$express  = $express->where()->select();
		$this->assign('express',$express);
		//模板输出
		$this->assign('xsd','0.05');// 设置支付宝服务费
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 分页输出
		$this->assign('nowCount',$nowCount);//订单总数
		$this->assign('nowAvg',$nowAvg);//订单均价 number_format(str,2)
		$this->assign('freightSum',$freightSum);//订单总金额
		$this->assign('refused',$refused);//订单均价 number_format(str,2)
		$this->assign('sign',$sign);//订单总金额
		$this->display('Index/Order/orderIssue');
	}
	/*****
	*批量标记订单状态(拒签 OR 签收)
	*/
	public function orderBatch(){
		extract(I());
		$order = D('Order');
 		$valB['id']=array('in',$orderArr);
 		$valB['type']=array('in','3,4');
 		$result = $order->where($valB)->select();
 		//p($result);
 		if(!empty($result)){
 			foreach ($result as $key => $value) {
 				$str = $value['id'];
 			}
 			$this->ajaxReturn("标记失败<br/>ID:".$str."订单状态已被标识");
 		}else{
 			$val['id']=array('in',$orderArr);
 			$order->where($val)->setField('type',$type);
 			switch ($type) {
 				case '3':
 					$this->ajaxReturn("订单标记【签收】完成");
 					break;
 				case '4':
 					$this->ajaxReturn("订单标记【拒签】完成");
 					break;
 				default:
 					$this->ajaxReturn("标记失败");
 					break;
 			}
 		}	
	}
	/*****
	*订单回收站列表
	*/
	public function ordertrash(){
		extract(I());
	 	$Order  = D("Order");
		//信息统计
		$now = date(strtotime(date('Y-m-d')));
		$data['order'] = array('egt',$now);
		$nowSum = $Order->where($data)->sum('mey');
		$nowAvg = $Order->where($data)->avg('mey');
		$nowCount = $Order->where($data)->count();
		//分页输出
		$count = $Order->where('type=0')->count();
		$Page = new\Think\Page($count,10);
		$Page -> setConfig('header','<li class="infoNo"><a href="#">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</a></li>');
		$Page -> setConfig('prev','上一页');
		$Page -> setConfig('next','下一页');
		$Page -> setConfig('theme','%HEADER% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
		$show = $Page->show();
		//数据输出
		$list = $Order
		->alias('o')
		->where('o.type=0')
		->field('o.id,o.order,o.product,o.size,o.consignee,o.mob,o.address,o.mey,o.guest,o.type,o.ip,o.countip,
			o.express,o.waybill,o.register,o.sendtime')
		//->join('__ADMIN__ ON o.uid = __ADMIN__.id')
		->order('o.id desc')
		->limit($Page->firstRow.','.$Page->listRows)
		->select();
		//快递选择输出
		$express  = M('express');
		$express  = $express->where()->select();
		$this->assign('express',$express);
		//模板输出
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 分页输出
		$this->assign('nowCount',$nowCount);//订单总数
		$this->assign('nowAvg',number_format($nowAvg,2));//订单均价
		$this->assign('nowSum',number_format($nowSum,2));//订单总金额
		$this->display('Index/Order/ordertrash');
	}
	/*****
	*获取订单备注信息
	*/
	public function cgetNotes()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Model = D('Order');
		$result = $Model->getNotes($id);
		//$this->ajaxReturn($result[0]['register']);
		$this->ajaxReturn($result[0]['register']);
	}
	/*****
	*更新订单备注信息
	*/
	public function cEditNotes()
	{
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Order = M('Order');
		$val['id']=array('eq',$id);
		$data['register']=$register;
		$status = $Order->where($val)->save($data);
		if($status){
			$data['status']=1;
		}else{
			$data['status']=0;
		}
		$this->ajaxReturn($data);
	}
	/*****
	*获取物流(不支持圆通/韵达)
	*/
	public function logistics()
	{	
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Model = D('Order');
		$express=$Model->express($id);//获取快递和运单号
		$typeCom = $_GET["com"]=$express[0]['exp_name'];//快递公司
		$typeNu = $_GET["nu"]=$express[0]['waybill'];  //快递单号
		$AppKey='e02760682b2b1a43';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
		$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=asc';
		if(function_exists('curl_init') == 1){
  			$curl = curl_init();
 			curl_setopt ($curl, CURLOPT_URL, $url);
 			curl_setopt ($curl, CURLOPT_HEADER,0);
 			curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  			curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  			$get_content = curl_exec($curl);
  			curl_close ($curl);
  			$a=json_decode($get_content);
  			if($a->{'status'}==1){
  				foreach(array_reverse($a->{'data'}) as $k=>$item){
  				 	$str.= '<li class="list-group-item"><span>'.$item->time.'</span><p>'.$item->context.'</p></li>';
  				}
  			}else if($a->{'status'}==0){
  				$str.= '<li class="list-group-item"><span>'.$a->{'message'}.'</span></li>';
  			}else if($a->{'status'}==2){
  				$str.= '<li class="list-group-item"><span>无法查询该物流信息！圆通、韵达目前无法查询！请前往对应的官方网站进行查询，感谢您的支持！
  				</span></li>';
  			}
  			$data['express']=$typeCom;
  			$data['waybill']=$typeNu;
  			$data['str']=$str;
  			$this->ajaxReturn($data);
		}else{
			$this->ajaxReturn("error");
		}
	}
	/*****
	*获取物流(圆通/韵达 版本)
	*/
	public function logisticsB()
	{	
		if(!IS_AJAX)$this->error('非法请求');
		extract(I());
		$Model   = D('Order');
		$express = $Model->express($id);//获取快递和运单号
		$typeCom = $express[0]['exp_name'];//快递公司
		$pinyin = $express[0]['pinyin'];//快递公司 拼音
		$typeNu  =  $express[0]['waybill'];  //快递单号
		$AppKey='246c39f42f3a46b1857366c5f9a8db32';
		$url='http://api.avatardata.cn/ExpressNumber/Lookup?key='.$AppKey.'&company='.$pinyin.'&id='.$typeNu.'';
		if(function_exists('curl_init') == 1){
  			$curl = curl_init();
 			curl_setopt ($curl, CURLOPT_URL, $url);
 			curl_setopt ($curl, CURLOPT_HEADER,0);
 			curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  			curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  			$get_content = curl_exec($curl);
  			curl_close ($curl);
  			$a=json_decode($get_content);
  			//p($a);
  			if($a->{'error_code'}==0){
  				foreach(array_reverse($a->{'result'}) as $k=>$item){
  				 	$str.= '<li class="list-group-item"><span>'.$item->time.'</span><p>'.$item->action.'</p></li>';
  				}
  			}else{
  				$str.= '<li class="list-group-item"><span>无法查询该物流信息！若不是单号错误，便是程序出现Bug！
  				</span></li>';
  			}
  			$data['express']=$typeCom;
  			$data['waybill']=$typeNu;
  			$data['str']=$str;
  			//p($data);
  			//exit;
  			$this->ajaxReturn($data);
		}else{
			$this->ajaxReturn("error");
		}
	}
	/*****
	*获取手机归属地
	*/
	public function cgetMob(){
		extract(I());
		$Order  = D("Order");
		$mobAddr = $Order->getMob($mob);
		$data['centent'] = $mobAddr;
		$this->ajaxReturn($data);
	}
	/*****
	*发货单打印
	*/
	public function orderPrint(){
		extract(I());
		$info = M('order');
		$val['id']=array('eq',$id);
		$result = $info->where($val)->select();
		//p($result);
		//$this->assign('date',data('Y-m-d',time()));
		$this->assign('info',$result[0]);
		$this->display('Index/Order/orderPrint');
	}
	public function add() 
	{
    	if(SendMail('64941334@qq.com','标题','内容')) {
    	    $this->success('发送成功！');
   		} else {
    	    $this->error('发送失败');
   		}
	}
}