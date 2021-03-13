<?php
namespace app\common\model;

use think\Model;

class Bisuser extends Model
{

	protected $autoWriteTimestamp = true;

	public function bisBaseInfo($data){
        $data['status']=0;
        $this->save($data);
		return $this->id;
	}

    /**
     * 获取商家入驻待审核数据
     * @param int $status
     * @return \think\paginator\Collection
     * @throws \think\exception\DbException
     */
    public function getBisByStatus($status=0){
        $data=[
            'status'=>$status,
        ];
        $order=[
            'id'=>'desc'
        ];
        $result=$this->where($data)->order($order)->paginate();
        return $result;
    }



}