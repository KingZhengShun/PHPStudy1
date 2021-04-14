<?php
namespace app\common\model;

class Order extends BaseModel
{
	//添加数据到订单表
	public function addOrder($data){
		$data['status']=1;
		$this->save($data);
		return $this->id;
	}

}