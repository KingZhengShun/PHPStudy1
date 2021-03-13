<?php 
namespace app\common\model;
use think\Model;

class Deal extends BaseModel{
	//更新时间
	protected $autoWriteTimestamp = true;
	function getNormalDealData(){
		$order=[
			'id'=>'desc'
		];
		return $this->order($order)->select();
	}
}