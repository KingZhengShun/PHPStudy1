<?php 
namespace app\common\model;
use think\Model;

class Featured extends BaseModel{
	//更新时间
	protected $autoWriteTimestamp = true;
	/**根据类型获取列表数据**/
	public function getFeaturedsByType($type){
		$data=[
			'type'=>$type,
			'status'=>['neq',-1]
		];
		$order=['id'=>'desc'];
		$result=$this->where($data)->order($order)->paginate();
		return $result;

	}

}