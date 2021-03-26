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

}