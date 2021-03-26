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
        //获取当前账号的id信息！
        $bisId=$this->getLoginUser()->bis_id;
        if(request()->isPost()){
            //获取请求的数据
            $info=input('post.');
            //进行数据的判断
            $validate_info=validate('Bis');
            if($validate_info->scene('status')->check($info)){
                $this->error($validate_info->getError());
            }
            //判断图片是否修改如果没有修改则原图片地址不变，否则图片上传并获取图片地
            $file=request()->file('image');
            if($file==''){
                $result=model('Deal')->where('id',$info['bisId'])->find();                
                $info['image']=$result['image'];
            }else{
                $info['image']=model('ImageUpdate')->photoUpdate('image');
            }

            //查询商户项目都有门店信息
            $location=model('bislocation')->get($info['location_ids'][0]);
            $deals=[
                'name'=>$info['name'],
                'category_id'=>$info['category_id'],
                'se_category_id'=>empty($info['se_category_id'])?'':implode(',',$info['se_category_id']),
                'bis_id'=>$bisId,
                'location_ids'=>empty($info['location_ids'])?'':implode(',',$info['location_ids']),
                'image'=>$info['image'],
                'description'=>$info['description'],
                'start_time'=>strtotime($info['start_time']),
                'end_time'=>strtotime($info['end_time']),
                'coupons_begin_time'=>strtotime($info['coupons_begin_time']),
                'coupons_end_time'=>strtotime($info['coupons_end_time']),
                'origin_price'=>$info['origin_price'],
                'current_price'=>$info['current_price'],
                'city_id'=>$info['city_id'],
                'se_city_id'=>empty($info['se_city_id'])?'':$info['se_city_id'],
                'buy_count'=>'',
                'total_count'=>$info['total_count'],
                'xpoint'=>$location->xpoint,
                'ypoint'=>$location->ypoint,
                'bis_account_id'=>$this->getLoginUser()->id,
                'balance_price'=>'',
                'notes'=>$info['notes'],
                'update_time'=>time()
            ];

            //数据更新数据库
            $datainfo=model('Deal')->where('id',$info['bisId'])->update($deals);
            //判定是否导入数据成功！
            if($datainfo){
                $this->success('更新成功','deal/index');
            }else{
                $this->error("更新失败");
            }

        }else{
            //获取团购商品id的信息
            $data=input('get.');
            //获取需查看修改团购商品的详情信息
            $DealData=model('Deal')->where(['id'=>$data['id']])->select();
            //通过团购信息获取二级城市信息
            $city_id=['region_id'=>$DealData[0]->se_city_id];
            $se_cityInfo=model('regions')->where($city_id)->find();
            //获取省信息
            $province=model('regions')->getNormalCitysByParentId();
            //获取一级栏目分类数据列表数据
            $categorys=model('Category')->getNormalCagetorysByParentId();
            //获取二级栏目分类数据列表数据
            $category_id=$DealData[0]->category_id;
            $se_categorys=model('Category')->where(['parent_id'=>$category_id])->select();
            //所支持门店
            $bislocation=model('Bislocation')->getNormalLocationByBisId($bisId);


            // print_r($bislocation);exit;
            return $this->fetch('deal/editDeal',[
                'DealData'=>$DealData,
                'se_cityInfo'=>$se_cityInfo,
                'province'=>$province,
                'categorys'=>$categorys,
                'se_categorys'=> $se_categorys ,
                'bislocation'=>$bislocation
            ]);
        }
        
        
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
            //图片上传并获取图片地址
            $info['image']=model('ImageUpdate')->photoUpdate('image');

            //查询商户项目都有门店信息
            $location=model('bislocation')->get($info['location_ids'][0]);
            $deals=[
                'name'=>$info['name'],
                'category_id'=>$info['category_id'],
                'se_category_id'=>empty($info['se_category_id'])?'':implode(',',$info['se_category_id']),
                'bis_id'=>$bisId,
                'location_ids'=>empty($info['location_ids'])?'':implode(',',$info['location_ids']),
                'image'=>$info['image'],
                'description'=>$info['description'],
                'start_time'=>strtotime($info['start_time']),
                'end_time'=>strtotime($info['end_time']),
                'coupons_begin_time'=>strtotime($info['coupons_begin_time']),
                'coupons_end_time'=>strtotime($info['coupons_end_time']),
                'origin_price'=>$info['origin_price'],
                'current_price'=>$info['current_price'],
                'city_id'=>$info['city_id'],
                'se_city_id'=>empty($info['se_city_id'])?'':$info['se_city_id'],
                'buy_count'=>'',
                'total_count'=>$info['total_count'],
                'xpoint'=>$location->xpoint,
                'ypoint'=>$location->ypoint,
                'bis_account_id'=>$this->getLoginUser()->id,
                'balance_price'=>'',
                'notes'=>$info['notes'],                
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