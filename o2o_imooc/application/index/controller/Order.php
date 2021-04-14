<?php
namespace app\index\controller;
use think\Controller;

class Order extends Base
{
	public function index(){
		//判断用户是否登录
    	if(empty($this->getLoginUser())){
    		$this->error('请用户先登录','user/login');
    	}
    	//获取个人信息
    	$userInfo=session('o2o_user','','o2o');
    	//获取商品id
    	$goodId=input('get.id',0,'intval');
    	if(empty($goodId)){
    		$this->error('商品id不合法！');
    	}
    	//获取订单信息
    	$data=input('get.');
    	//获取信息来源
    	if(empty($_SERVER['HTTP_REFERER'])){
    		$this->error('访问来源不合法');
    	}
    	//创建订单号
    	$orderSn=setOrderSn();
    	$orderInfo=[
    		'out_trade_no'=>$orderSn,
    		'user_id'=>$userInfo->id,
    		'user_name'=>$userInfo->username,
    		'deal_id'=>$data['id'],
    		'deal_count'=>$data['goods_count'],
    		'total_price'=>$data['totao_price'],
    		'referer'=>$_SERVER['HTTP_REFERER'],

    	];
    	try {
    		$orderId=model('Order')->addOrder($orderInfo);
    	} catch (\Exception $e) {
    		$this->error($e->getMessage());
    	}

    	$this->redirect(url('pay/index',['id'=>$orderId]));
    	

	}

    public function confirm(){
    	//判断用户是否登录
    	if(empty($this->getLoginUser())){
    		$this->error('请用户先登录','user/login');
    	}
    	//获取个人信息
    	$userInfo=session('o2o_user','','o2o');
    	//获取商品id
    	$goodId=input('get.id',0,'intval');
    	if(empty($goodId)){
    		$this->error('商品id不合法！');
    	}
    	//获取商品的库存数
    	$goodsInfo=model('deal')->where('id','eq',$goodId)->find();
    	$goodsTotalCount=$goodsInfo->total_count;
    	//获取客户购买数量
    	$goodcount=input('get.count',0,'intval');
    	//判断库存数是否大于购买数
    	if ($goodsTotalCount<$goodcount) {

    		$this->error('商品已卖完，请重新选购！','/');
    	}

    	return $this->fetch('',[
    		'controler'=>'pay',
    		'userInfo'=>$userInfo,
    		'goodsInfo'=>$goodsInfo,
    		'goodcount'=>$goodcount,
    	]);
    }
}
