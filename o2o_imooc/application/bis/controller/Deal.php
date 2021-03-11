<?php
namespace app\bis\controller;
use think\Controller;
use think\Db;
class Deal extends Base{

    public function index(){
        //查询团购表单的信息
        $DealData=model('deal')->select();        
        return $this->fetch("",[
            "DealData"=>$DealData
        ]);
    }

    //修改团购信息
    public function editDeal(){
        //获取团购商品id的信息
        $data=input('get.');
        //获取需查看修改团购商品的详情信息
        $DealData=model('deal')->where(['id'=>$data['id']])->select();
        $citys=model('regions')->getNormalCitysByParentId();
        var_dump($DealData);
        return $this->fetch('deal/editDeal',[
            'DealData'=>$DealData,
            'citys'=>$citys
        ]);
    }





    public function add(){
        //获取商家的id信息
            $bisId=$this->getLoginUser()->bis_id;
        //进行请求的逻辑判断
        if(request()->isPost()){
            //获取请求的数据
            $info=input('post.');
            //进行数据的判断
            $validate_info=validate('Bis');
            if($validate_info->scene('status')->check($info)){
                $this->error($validate_info->getError());
            }
            //
            $location=model('bislocation')->get($info['location_ids'][0]);
            $deals=[
                'name'=>$info['name'],
                'city_id'=>empty($info['se_city_id'])?$info['city_id']:$info['city_id'].",".$info['se_city_id'],
                'category_id'=>$info['category_id'],
                'se_category_id'=>empty($info['se_category_id'])?'':implode(',',$info['se_category_id']),
                'location_ids'=>empty($info['location_ids'])?'':implode(',',$info['location_ids']),
                'image'=>$info['image'],
                'start_time'=>strtotime($info['start_time']),
                'end_time'=>strtotime($info['end_time']),
                'total_count'=>$info['total_count'],
                'origin_price'=>$info['origin_price'],
                'current_price'=>$info['current_price'],
                'coupons_begin_time'=>strtotime($info['coupons_begin_time']),
                'coupons_end_time'=>strtotime($info['coupons_end_time']),
                'bis_account_id'=>$this->getLoginUser()->id,
                'description'=>$info['description'],
                'notes'=>$info['notes'],
                'xpoint'=>$location->xpoint,
                'ypoint'=>$location->ypoint
            ];

            //数据导入数据库
            $datainfo=model('Deal')->add($deals);
            //判定是否导入数据成功！
            if($datainfo){
                $this->success('添加成功','deal/index');
            }else{
                $this->error("添加失败");
            }

        }else{

            //获取省数据列表数据
            $citys=model('Regions')->getNormalCitysByParentId();
            //获取一级栏目分类数据列表数据
            $categorys=model('Category')->getNormalCagetorysByParentId();

            return $this->fetch('',[
                'citys'=>$citys,
                'categorys'=>$categorys,
                'bislocation'=>model('Bislocation')->getNormalLocationByBisId($bisId)
            ]);
        }

    }
}