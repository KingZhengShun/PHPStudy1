<?php
namespace app\admin\controller;
use think\Controller;

class Deal extends Controller{

	private $obj;
    public function _initialize()
    {
        $this->obj=model('Deal');
    }

	public function index(){


		$data=input('post.');
		$sdata=[];
		if(!empty($data['category_id'])){
			$sdata['category_id']=$data['category_id'];
		}
		if(!empty($data['city_id'])){
			$sdata['city_id']=$data['city_id'];
		}
		if(!empty($data['start_time'])&&empty($data['end_time'])&&stritime($data['start_time'])<stritime($data['end_time'])){
			$sdata['create_time']=[
				['gt',strtime($data['start_time'])],
				['lt',strtime($data['end_time'])],				
			];
		}
		if(!empty($data['name'])){
			$sdata['name']=['like','%'.$data['name'].'%'];
		}
		$result=$this->obj->getNormalDealData();
		print_r($result);
		//获取一级分类的数据
		$categorys=model('Category')->getNormalCagetorysByParentId();
		//获取省份数据
		$provinces=model('Regions')->getNormalCitysByParentId();
		return $this->fetch('',[
			'categorys'=>$categorys,
			'provinces'=>$provinces
		]);

	}


	public function apply(){
		return $this->fetch();
	}
}