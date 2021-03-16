<?php 
namespace app\common\model;
use think\Model;

class User extends BaseModel{
	public function add($data){
		//判断提交的数据是否是数组类型
		if(!is_array($data)){
			exception("传输数据类型不是数组");
		}
		$data['status']=1;
		return $this->allowField(true)->save($data);
	}
}