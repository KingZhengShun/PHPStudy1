<?php
namespace app\common\model;

use think\Model;

class Bislocation extends Model
{
	protected $autoWriteTimestamp = true;
	public function bisBaseInfoAdd($data){
        $data['status']=0;
        $this->save($data);
		return $this->id;
	}


	public function getNormalLocationByBisId($bisId){
	    $data=[
	      'bis_id'=>$bisId,
            'status'=>1
        ];
	    return $this->where($data)->select();

    }


}