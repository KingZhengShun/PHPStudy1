<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj=model('Bisuser');
    }
    /**
    *正常商户列表
    *@return mixed
    */
    public function index(){
        $data=$this->obj->getBisByStatus(1);
        if($data){
        return $this->fetch('',[
            'data'=>$data,
        ]);
        }
    return $this->fetch();
    }
    /**
    *入驻申请列表
    *@return mixed
    */
    public function apply(){
        $data=$this->obj->getBisByStatus();
        if($data){
            return $this->fetch('',[
                'data'=>$data,
            ]);
        }
        return $this->fetch();
    }

    /**
    *删除商户列表
    *@return mixed
    */
    public function dellist(){
        $data=$this->obj->getBisByStatus(-1);
        if($data){
            return $this->fetch('',[
                'data'=>$data,
            ]);
        }
        return $this->fetch();

    }


    /**
    *获取商户入驻申请数据
    */
    public function detail($id){
        $id=input('get.id');
        if(!$id){
            return $this->error('ID错误！');
        }
        //获取省数据列表数据
        $citys=model('Regions')->getNormalCitysByParentId();
        //获取一级栏目分类数据列表数据
        $categorys=model('Category')->getNormalCagetorysByParentId();
        //获取商户基本信息数据
        $data=model('bisuser')->get($id);
        //获取总店信息数据
        $locationData=model('Bislocation')->get(['bis_id'=>$id,'is_main'=>1]);
        //获取个人账号信息数据
        $accountData=model('Bisaccount')->get(['bis_id'=>$id,'is_main'=>1]);

        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'data'=>$data,
            'locationData'=>$locationData,
            'accountData'=>$accountData
        ]);
    }

    /**
     * 修改状态
     */
    public function status(){
        $data = input('get.');
        // print_r($data);exit;
        //校验状态
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res=$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        $location=model('Bislocation')->save(['status'=>$data['status']],['bis_id'=>$data['id']]);
        $account=model('Bisaccount')->save(['status'=>$data['status']],['bis_id'=>$data['id']]);
        if ($res && $location && $account){

            //发送邮件
            //status -1 删除记录，status 0 待审核，status 1 审核通过 status 2 审核不通过

            $this->success('状态更新成功！');
        }else{
            $this->error('状态更新失败');
        }

    }

}