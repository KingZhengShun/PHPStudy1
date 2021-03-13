<?php
namespace app\common\model;

use think\Model;

class Bisaccount extends Model
{
	protected $autoWriteTimestamp = true;
	public function bisaccountInfoAdd($data){
        $data['status']=0;
        $this->save($data);
		return $this->id;
	}

    /**
     * 更新最后登陆的时间
     * @param $data
     * @param $id
     * @return false|int
     */
	public function updateById($data,$id){
	    return $this->allowField(true)->save($data,['id'=>$id]);
    }
}