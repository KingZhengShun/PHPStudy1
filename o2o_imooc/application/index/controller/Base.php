<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller{
	public $city='';
	public $account='';
	public function _initialize(){
		//获取省份数据
		$province=model('Regions')->getNormalCitysByParentId();
		//获取城市数据
		$citys=model('Regions')->getNormalCitysInfo();
		//获取默认的城市信息
		$this->getCity($citys);

		$this->assign('province',$province);
		$this->assign('citys',$citys);
		$this->assign('city',$this->city);
		$this->assign('userInfo',$this->getLoginUser());
	}

	//获取城市信息
	public function getCity($citys){
		foreach ($citys as $key => $city) {
			$city=$city->toArray();
			// print_r($city);exit;
			if($city['is_default']==1){
				$defaultname=$city['region_name'];
				break;
			}
		}
		//判断是否有默认数据
		$defaultname=$defaultname?$defaultname:'天津市';
		//判断session是否有数据并且url没有数据
		if (session('citynames','','o2o')&&!input('get.city_name')) {
			$citynames=session('citynames','','o2o');
		}else{
			//获取url中的数据，如果没有则选择磨人的数据
			$citynames=input('get.city_name',$defaultname,'trim');
			session('citynames',$citynames,'o2o');
		}

		$this->city=model('Regions')->where(['region_name'=>$citynames])->find();

	}

	//获取session值
    public function getLoginUser(){
        if (!$this->account){
            $this->account = session('o2o_user','','o2o');
        }
        return $this->account;
    }
}