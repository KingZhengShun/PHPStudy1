<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Deal extends Controller{

	private $obj;
    public function _initialize()
    {
        $this->obj=model('Deal');
    }
    /**团购商品列表页**/
	public function index(){
		$result=[];
		//获取团购商品待审核信息
		$deals=$this->obj->where('status','in','1')->select();		
		//判断是否存在团购商品申请数据
		if($deals){
			foreach ($deals as $key => $value) {
				$deal_se_city_id[$key]=$value->se_city_id;
				$deal_category_id[$key]=$value->category_id;
			}
			//获取团购商品的二级城市id信息（删除重复）
			$deal_se_city_id=array_unique($deal_se_city_id);
			//获取团购商品二级城市信息
			$deal_cityInfo=model('Regions')->where('region_id','in',$deal_se_city_id)->select();
			//获取团购商品信息的一级分类id信息（删除重复)
			$deal_category_id=array_unique($deal_category_id);
			//获取团购商品信息的一级分类信息
			$deal_categoryInfo=model('Category')->where('id','in',$deal_category_id)->select();
			//获取二级分类信息
			$deal_se_categoryInfo=model('Category')->where('parent_id','neq','0')->select();
			if(request()->isPost()){
				$data=input('post.');
				$sdata=[];
				if(!empty($data['category_id'])){
					$sdata['category_id']=$data['category_id'];
				}
				if(!empty($data['city_id'])){
					$sdata['se_city_id']=$data['city_id'];
				}
				if(!empty($data['start_time'])&&!empty($data['end_time'])&&strtotime($data['end_time'])>strtotime($data['start_time'])){
					$sdata['create_time']=[
						['gt',strtotime($data['start_time'])],
						['lt',strtotime($data['end_time'])]
					];
				}
				if(!empty($data['name'])){
					$sdata['name']=['like','%'.$data['name'].'%'];
				}
				
				$result=$this->obj->getNormalDealData($sdata);
				if($result){
					return $this->fetch('',[
					'dealInfo'=>$deals,
					'deal_categoryInfo'=>$deal_categoryInfo,
					'deal_cityInfo'=>$deal_cityInfo,
					'deal_se_categoryInfo'=>$deal_se_categoryInfo,
					'result'=>$result
					]);
				}
				else{
					$this->error('未查到匹配数据');
				}
			}
			
			return $this->fetch('',[
				'dealInfo'=>$deals,
				'deal_categoryInfo'=>$deal_categoryInfo,
				'deal_cityInfo'=>$deal_cityInfo,
				'deal_se_categoryInfo'=>$deal_se_categoryInfo,
				'result'=>$result
			]);
		}else{
			return $this->fetch('deal/detailBlank');
		}			
		
	}

	/**团购商品申请页面**/
	public function apply(){

		$result=[];
		//获取团购商品待审核信息
		$deals=$this->obj->where('status','in','0')->select();		
		//判断是否存在团购商品申请数据
		if($deals){
			foreach ($deals as $key => $value) {
				$deal_se_city_id[$key]=$value->se_city_id;
				$deal_category_id[$key]=$value->category_id;
			}
			//获取团购商品的二级城市id信息（删除重复）
			$deal_se_city_id=array_unique($deal_se_city_id);
			//获取团购商品二级城市信息
			$deal_cityInfo=model('Regions')->where('region_id','in',$deal_se_city_id)->select();
			//获取团购商品信息的一级分类id信息（删除重复)
			$deal_category_id=array_unique($deal_category_id);
			//获取团购商品信息的一级分类信息
			$deal_categoryInfo=model('Category')->where('id','in',$deal_category_id)->select();
			//获取二级分类信息
			$deal_se_categoryInfo=model('Category')->where('parent_id','neq','0')->select();

			if(request()->isPost()){
				$data=input('post.');

				$sdata=[];
				if(!empty($data['category_id'])){
					$sdata['category_id']=$data['category_id'];
				}
				if(!empty($data['city_id'])){
					$sdata['se_city_id']=$data['city_id'];
				}
				if(!empty($data['start_time'])&&!empty($data['end_time'])&&strtotime($data['end_time'])>strtotime($data['start_time'])){
					$sdata['create_time']=[
						['gt',strtotime($data['start_time'])],
						['lt',strtotime($data['end_time'])]
					];
				}
				if(!empty($data['name'])){
					$sdata['name']=['like','%'.$data['name'].'%'];
				}
				
				$result=$this->obj->getNormalDeals($sdata);
				if($result){
					return $this->fetch('',[
					'dealInfo'=>$deals,
					'deal_categoryInfo'=>$deal_categoryInfo,
					'deal_cityInfo'=>$deal_cityInfo,
					'deal_se_categoryInfo'=>$deal_se_categoryInfo,
					'result'=>$result
					]);
				}
				else{
					$this->error('未查到匹配数据');
				}

			}
			
			return $this->fetch('',[
				'dealInfo'=>$deals,
				'deal_categoryInfo'=>$deal_categoryInfo,
				'deal_cityInfo'=>$deal_cityInfo,
				'deal_se_categoryInfo'=>$deal_se_categoryInfo,
				'result'=>$result
			]);
		}else{
			return $this->fetch('deal/detailBlank');
		}			
	}

	/**商品团购详情页**/
	public function detail(){
		$dealId=input('get.id');
		$DealData=$this->obj->where('id','eq',$dealId)->select();
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
		$bislocation=model('Bislocation')->getNormalLocationByBisId($DealData[0]->bis_id);

		return $this->fetch('',[
			'DealData'=>$DealData,
			'se_cityInfo'=>$se_cityInfo,
			'province'=>$province,
			'categorys'=>$categorys,
			'se_categorys'=> $se_categorys ,
			'bislocation'=>$bislocation
		]);
	}


	/**
     * 修改状态
     */
    public function status(){
        $data = input('get.');
        //校验状态
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res=$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if ($res){

            //发送邮件
            //status -1 删除记录，status 0 待审核，status 1 审核通过 status 2 审核不通过

            $this->success('状态更新成功！');
        }else{
            $this->error('状态更新失败');
        }

    }

    public function detailBlank(){
    	return $this->fetch();
    }
}