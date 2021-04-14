<?php 
namespace app\common\model;
use think\Model;

class Deal extends BaseModel{
	//更新时间
	protected $autoWriteTimestamp = true;
	function getNormalDealData($data=[]){
		$data['status']=1;
		$order=['id'=>'desc'];
		$result= $this->where($data)
		->order($order)
		->paginate();

		// echo $this->getLastSql();exit;
		return $result;
	}

	public function getNormalDeals($data=[]){
		$data['status']=0;
		$order=['id'=>'desc'];
		$result= $this->where($data)
		->order($order)
		->select();
		return $result;
	}

	/**获取商户的基本信息id:第一分类下的团购信息limit:限制查出的条数**/
	public function getNormalDealByCategoryCityId($cityId,$limit=10){
		$data=[
			// 'end_time'=>['gt',time()],
			'se_city_id'=>$cityId,
			'status'=>1
		];
		$order=[
			'listorder'=>'desc',
			'id'=>'desc'
		];

		$result=$this->where($data)->order($order);
		if($limit){
			$result=$result->limit($limit);
		}
		$result=$result->select();
		return $result;
	}


	/**对商品进行排序$data:查询第一分类还是第二分类商品，$orders判断排序方法**/
	public function getNarmalCondition($data=[],$orders=[]){
		$order=[];
		if(!empty($orders['order_scale'])){
			$order['buy_count']='desc';
		}
		if(!empty($orders['order_price'])){
			$order['current_price']='desc';
		}
		if(!empty($orders['order_time'])){
			$order['update_time']='desc';
		}
		$data['status']=1;

		$result= $this->where($data)
				// ->where('end_time','>',time())
				->order($order)
				->paginate();
		return $result;
	}

}