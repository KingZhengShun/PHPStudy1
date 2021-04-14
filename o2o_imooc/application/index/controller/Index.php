<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Base
{	
	//主页导航
	public function index()
	{
		$se_categoryDate=$arr=$dealDates=$datas=[];
		//获取首页大图 相关的数据
		$navPhoto=model('Featured')->getFeaturedsByType(0);
		//获取广告位相关的数据
		$advertisingPhoto=model('Featured')->getFeaturedsByType(1);
		//获取商品分类，数据-美食，推荐数据
		// print_r($this->city->region_id);exit;
		$dealInfo=model('Deal')->getNormalDealByCategoryCityId($this->city->region_id);
		// print_r($dealInfo);exit;
		if($dealInfo){
			//获取团购信息的一级分类信息
			foreach ($dealInfo as $key => $value) {
				$arr[$key]=$value->category_id;
			}
			
			$arr=array_unique($arr);
			
			//获取团购信息中一级分类信息
			$categoryInfo=model('Category')->where('id','in',$arr)->select();

			//获取一级分类下的团购信息
			foreach ($categoryInfo as $ke => $vo) {
				$dealDate=[];
				foreach ($dealInfo as $key => $value) {
					if($vo->id==$value->category_id){
						$dealDate[$key]=$value;
					}
				}
				$dealDates[$ke]=[
					'id'=>$vo->id,
					'name'=>$vo->name,
					'dealInfo'=>$dealDate
				];
			}
			//获取一级分类下面的子类信息
			$se_categoryInfo=model('Category')->where('parent_id','neq',0)->select();
			
			foreach ($dealDates as $key => $value) {
				$categoryDate=[];

				foreach ($se_categoryInfo as $ke => $vo) {
					// print_r($value['id']);exit;
					if($value['id']==$vo->parent_id){
						$categoryDate[$ke]=$vo;
					}
				}
				$dealDates[$key]['categoryDate']=$categoryDate;
			}

			return $this->fetch('',[
				'navPhoto'=>$navPhoto,
				'advertisingPhoto'=>$advertisingPhoto,
				'dealDates'=>$dealDates,
			]);

		}else{
			return $this->fetch('',[
					'navPhoto'=>$navPhoto,
					'advertisingPhoto'=>$advertisingPhoto,
					'dealDates'=>null,
				]);

		}

		
		

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
