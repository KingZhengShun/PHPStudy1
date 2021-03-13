<?php
namespace app\common\model;
use think\Model;

class BaseModel extends Model{
	//添加数据到指定的数据库
	public function add($data){
		$data['status']=0;
		$this->save($data);
		return $this->id;
	}
}