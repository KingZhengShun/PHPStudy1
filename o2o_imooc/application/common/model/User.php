<?php 
namespace app\common\model;
use think\Model;

class User extends BaseModel{

	/**
	*将注册的数据添加到数据库
	*
	**/
	public function add($data){
		//判断提交的数据是否是数组类型
		if(!is_array($data)){
			exception("传输数据类型不是数组");
		}
		$data['status']=1;
		return $this->allowField(true)->save($data);
	}
	/**
	*通过用户名获取数据信息
	*
	**/
	public function getClientInfoByUserName($username){
		if(!$username){
			exception("用户名不合法！");
		}
		$data=['username'=>$username];
		return $this->where($data)->find();
		
	}
}