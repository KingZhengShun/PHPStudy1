<?php
namespace app\index\controller;
use think\Controller;

class Detail extends Base
{
    public function index()
    {
    	$id=input('get.id');
    	// print_r($id);exit;
    	if(!intval($id)){
    		$this->error('id不合法！');
    	}
    	$detailData=model('Deal')->get($id);
    	if(!$detailData||$detailData->status!=1){
    		$this->error('商品不存在！');
    	}

    	//获取本商品的一级分类
    	$category=model('Category')->get($detailData->category_id);
    	//获取本商品所属的店铺信息
    	$locationIds=explode(',', $detailData->location_ids);
    	$location=model('Bislocation')->where('id','in',$locationIds)->select();
    	//判断团购是否开始
    	$flag=0;
    	// print_r(time());exit;
    	if($detailData->start_time>time()){
    		$flag=1;
    		$dtime=$detailData->start_time-time();
    		$timedata='';
    		$d=floor($dtime/(3600*24));
    		if($d){
    			$timedata.=$d.'天';
    		}
    		$h=floor($dtime%(3600*24)/3600);
    		if($h){
    			$timedata.=$h.'时';
    		}
    		$m=floor($dtime%(3600*24)%3600/60);
    		if($m){
    			$timedata.=$m.'分';
    		}
    		// print_r($m);exit;
    		$this->assign('timedata',$timedata);


    	}
    	$point=$location[0]->xpoint.','.$location[0]->ypoint;

    	$mapstr=\Map::staticimage($point);

		return $this->fetch('',[
			'detailData'=>$detailData,
			'title'=>$detailData->name,
			'category'=>$category,
			'location'=>$location,
			'flag'=>$flag,
			'mapstr'=>$mapstr,
		]);

    }
}
