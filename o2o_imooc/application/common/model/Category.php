<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{

	protected $autoWriteTimestamp = true;

	public function add($data){		
		$data['status']=1;
		//$data['create_time']=time();
		return $this->save($data);
	}

	public function getNormalFirstCagetory(){
	    $data=[
	        'status'=>1,
            'parent_id'=>0
        ];
	    $order=[
            'id'=>'desc'
        ];
	    return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getFirstCagetorys($parentID=0){
        $data=[
            'status'=>['neq',-1],
            'parent_id'=>$parentID
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];
        $result=$this->where($data)
            ->order($order)
            ->paginate();
        return $result;
    }

    public function getNormalCagetorysByParentId($parentID=0){
        $data=[
            'parent_id'=>$parentID
        ];
        $result=$this->where($data)
            ->select();
        return $result;
    }


    public function getNormalRecommendCateByParentId($id=0,$limit=5){
        $data=[
            'parent_id'=>$id,
            'status'=>1
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];
        $result=$this->where($data)->order($order);
        if ($limit) {
            $result=$result->limit($limit);
        }

        return $result->select();
    }


    public function getNormalCategoryIdByParentId($Ids){
        $data=[
            'parent_id'=>['in',$Ids],
            'status'=>1
        ];
        $order=[
            'listorder'=>'desc',
            'id'=>'desc',
        ];

        // print_r($data);exit;
        $result=$this->where($data)->order($order)->select();

        return $result;


    }

}