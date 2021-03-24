<?php
 
namespace app\test\controller;
 
// use think\facade\Request;
use think\Request;
use think\Controller;
use think\Db;
 
class Index extends Controller
{
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function index(){
        return $this->fetch();
    }
    
    public function save(Request $request)
    {
        $data=input('post.');
        print_r($data);exit;
        $file = request()->file('image_url');
        // print_r($file);exit;
        $info = $file->move('uploads/image');
        print_r($info);exit;
        if($info){
            // 成功上传后 获取上传信息
            $_POST['image_url'] = '/uploads/image/'.$info->getSaveName();
            print_r($_POST['image_url']);exit;
            // $row = DB::name('article')->insert($_POST);
            if($_POST['image_url']){
                return "<script>alert('添加成功');window.location.href='index?cancel=yes';</script>";
            }
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
 
 
    }
 
}