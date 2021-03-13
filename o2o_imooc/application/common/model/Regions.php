<?php
namespace app\common\model;
use think\Model;
class Regions extends Model{
    /**
     * @param int $regionsparentid
     * @return \think\db\Query
     */
    public function getNormalCitysByParentId($regionsparentid=-1){
        $data=[
            'region_parent_id'=>$regionsparentid
        ];

        $order=[
            'region_id'=>'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}