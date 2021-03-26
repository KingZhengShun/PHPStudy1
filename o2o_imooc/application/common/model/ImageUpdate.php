<?php
namespace app\common\model;
use think\Model;
class ImageUpdate extends Model{
    /**
     * @param int $regionsparentid
     * @return \think\db\Query
     */
    //图片上传
    public function photoUpdate($imgs){
        $file=request()->file($imgs);
        // print_r($file);exit;
        $info = $file->move('uploads/image');
        if($info){
            // 成功上传后 获取上传信息
            $imageUrl = '/uploads/image/'.$info->getSaveName();
        }
        return $imageUrl;
     }   
}
