<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Base
{	
	//主页导航
	public function index()
	{
		//获取首页大图 相关的数据

		$navPhoto=model('Featured')->getFeaturedsByType(0);
		// print_r($navPhoto);exit;
		//获取广告位相关的数据
		$advertisingPhoto=model('Featured')->getFeaturedsByType(1);
		return $this->fetch('',[
			'navPhoto'=>$navPhoto,
			'advertisingPhoto'=>$advertisingPhoto
		]);

	}


	//列表页导航
	public function shopList()
	{
	return $this->fetch('list');

	}

	//详情页导航
	public function detail()
	{
	return $this->fetch();

	}

	//支付页导航
	public function pay()
	{
	return $this->fetch();

	}



	//搜索地址
	public function address(){
		return $this->fetch();
	}

}
