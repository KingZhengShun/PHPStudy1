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
		//获取首页分类数据
		$cats=$this->getNormalRecommendCate();

		$this->assign('province',$province);
		$this->assign('citys',$citys);
		$this->assign('city',$this->city);
		$this->assign('cats',$cats);
		$this->assign('userInfo',$this->getLoginUser());
	}

	//获取城市信息
	public function getCity($citys){
		$defaultname='';
		foreach ($citys as $key => $city) {
			$city=$city->toArray();
			if($city['is_default']==1){
				$defaultname=$city['region_name'];
				break;
			}
		}
		// print_r($defaultname);exit;
		//判断是否有默认数据
		$defaultname=empty($defaultname)?$defaultname:'天津市';
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
    /**获取首页分类的数据**/
    public function getNormalRecommendCate(){
    	$parentIds=$sedcatArr=$recomCats=array();
    	$cats=model('Category')->getNormalRecommendCateByParentId(0,5);
    	// print_r($cats);exit;
    	//获取一类分类的数据id
    	foreach($cats as $cat){
    		$parentIds[]=$cat->id;
    	}
    	//获取二级分类的数据
    	$sedCats=model('Category')->getNormalCategoryIdByParentId($parentIds);
    	//根据父类的id,对第二类分类数据进行封装
    	foreach ($sedCats as $sedcat) {
    		$sedcatArr[$sedcat->parent_id][]=[
    			'id'=>$sedcat->id,
    			'name'=>$sedcat->name
    		];
    	}
    	//封装一级和二级分类数据
    	foreach ($cats as $key => $cat) {
    		//recomCats 代表是一级和二级数据，[]第一个参数是一级分类的name，[]第二个参数是此一级分类下面的所有二级分类数据
    		$recomCats[$cat->id]=[$cat->name,empty($sedcatArr[$cat->id])?[]:$sedcatArr[$cat->id]];
    	}

    	return $recomCats;
    }


}