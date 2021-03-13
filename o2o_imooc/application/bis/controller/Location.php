<?php
namespace app\bis\controller;
use think\Controller;
class Location extends Base{
	/**
	* @return mixed列表页 
	*/
    public function index(){

        return $this->fetch();

    }


    /**
    *新增分店信息
    */
    public function add(){
    	if(request()->isPost()){
            //校验数据
            $data=input('post.');
            $bisId=$this->getLoginUser()->bis_id;
            print_r($data);exit;
            //判断是否有二级分类
            $info['cat']='';
            if (!empty($info['se_category_id'])){
                $info['cat']=implode('|',$info['se_category_id']);
            }

    		//门店的入库操作   		
            $locationDate=[
                'bis_id'=>$bisId,
                'name'=>$info['name'],
                'tel'=>$info['tel'],
                'contact'=>$info['contact'],
                'category_id'=>$info['category_id'],
                'category_path'=>$info['category_id'].','.$info['cat'],
                'city_id'=>$info['city_id'],
                'city_path'=>empty($info['se_city_id'])?$info['city_id']:$info['city_id'].','.$info['se_city_id'],
                'address'=>$info['address'],
                'open_time'=>$info['open_time'],
                'content'=>empty($info['content'])?'':$info['content'],
                'xpoint'=>empty($xpoint)?'':$xpoint,
                'ypoint'=>empty($ypoint)?'':$ypoint,
            ];

            $locationId=model('Bislocation')->bisBaseInfoAdd($locationDate);
    	}else{
    		//获取省数据列表数据
    		$citys=model('Regions')->getNormalCitysByParentId();
    		//获取一级栏目分类数据列表数据
    		$categorys=model('Category')->getNormalCagetorysByParentId();
    		if($citys!=null){
    		    return $this->fetch('',['citys'=>$citys,'categorys'=>$categorys]);
    		}
    	}
    	    return $this->fetch();       
    }    

}