<?php
namespace app\bis\controller;
use think\Controller;
class Location extends Base{
	/**
	* @return mixed列表页 
	*/
    public function index(){
        $BislocationInfo=model('Bislocation')->where('status','=','1')->select();
        // print_r($BislocationInfo);
        
        return $this->fetch('',['BislocationInfo'=>$BislocationInfo]);

    }


    /**
    *新增分店信息
    */
    public function add(){
    	if(request()->isPost()){
            //获取提交的数据
            $info=input('post.');
            //数据校验
            $validate_zongdian_info=validate('Bis');
            if(!$validate_zongdian_info->scene('bis_zongdian_info')->check($info)){
                $this->error($validate_zongdian_info->getError());
            }
            //图片上传
            $info['logo']=model('ImageUpdate')->photoUpdate('logo');
            //获取父类id
            $bisId=$this->getLoginUser()->bis_id;
            //获取经纬度信息
            $lnglat=\Map::getLngLat($info['address']);
            if (empty($lnglat)){
                $this->error('数据匹配不精确！');
            }
            $xpoint=$lnglat->location->lng;
            $ypoint=$lnglat->location->lat;
            //判断是否有二级分类
            $info['cat']='';
            if (!empty($info['se_category_id'])){
                $info['cat']=implode('|',$info['se_category_id']);
            }


    		//门店的入库操作   		
            $locationDate=[
                'bis_id'=>$bisId,
                'name'=>$info['name'],
                'logo'=>$info['logo'],
                'tel'=>$info['tel'],
                'contact'=>$info['contact'],
                'category_id'=>$info['category_id'],
                'category_path'=>$info['category_id'].','.$info['cat'],
                'city_id'=>$info['city_id'],
                'city_path'=>empty($info['se_city_id'])?$info['city_id']:$info['city_id'].','.$info['se_city_id'],
                'api_address'=>$info['address'],
                'open_time'=>$info['open_time'],
                'content'=>empty($info['content'])?'':$info['content'],
                'is_main'=>0,
                'status'=>1,
                'xpoint'=>empty($xpoint)?'':$xpoint,
                'ypoint'=>empty($ypoint)?'':$ypoint,
            ];

            $locationId=model('Bislocation')->bisBaseInfoAdd($locationDate);
            $this->success('门店新增成功！',url('location/index'));
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