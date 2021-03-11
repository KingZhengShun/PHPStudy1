<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{	
	//主页导航
	public function index()
	{
	return $this->fetch();

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

}
