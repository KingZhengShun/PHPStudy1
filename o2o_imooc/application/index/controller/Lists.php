<?php
namespace app\index\controller;
use think\Controller;

class Lists extends Base{
	public function index(){
		//获取一级分类
		$categorys=model('category')->getNormalCagetorysByParentId();

		foreach ($categorys as $key => $value) {
			$firstCatIds[]=$value->id;
		}
		//获取参数
		$id=input('id',0,'intval');
		$data=[];
		//判断参数id为一级分类还是二级分类
		if (in_array($id, $firstCatIds)) {
			$categoryParentId=0;
			$data['category_id']=$id;

		}elseif ($id) {
			$category=model('category')->get($id);
			if (!$category||$category->status!=1) {
				$this->error('数据不合法');
			}
			$categoryParentId=$category->parent_id;
			$data['se_category_id']=$id;
		}else{
			$categoryParentId= 0;
			$data['category_id']=$id;
		}
		//获取二级分类
		$sedcategorys=[];
		if($categoryParentId){
			$sedcategorys=model('category')->getNormalCagetorysByParentId($categoryParentId);
		}
		$orders=$goodsInfo=[];
		//获取排序信息
		$order_scale=input('get.order_scale');
		$order_price=input('get.order_price');
		$order_time=input('get.order_time');
		if (!empty($order_scale)) {
			$orderflag=$order_scale;
			$orders['order_scale']=$order_scale;
		}elseif (!empty($order_price)) {
			$orderflag=$order_price;
			$orders['order_price']=$order_price;
		}elseif (!empty($order_time)) {
			$orderflag=$order_time;
			$orders['order_time']=$order_time;
		}else{
			$orderflag='';
		}
		$data['se_city_id']=$this->city->region_id;
		
		$goodsInfo=model('deal')->getNarmalCondition($data,$orders);
		

		
		


		// print_r($sedcategorys);exit;
		return $this->fetch('',[
			'categorys'=>$categorys,
			'sedcategorys'=>$sedcategorys,
			'id'=>$id,
			'categoryParentId'=>$categoryParentId,
			'goodsInfo'=>$goodsInfo,
			'orderflag'=>$orderflag,
		]);
	}




}