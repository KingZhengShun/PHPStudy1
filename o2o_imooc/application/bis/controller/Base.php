<?php
namespace app\bis\controller;
use think\Controller;
class Base extends Controller{
    public $account;
    public function _initialize()
    {
        //判断用户是否登陆
        $isLogin=$this->isLogin();
        if (!$isLogin){
            return $this->redirect('login/index');
        }
    }
    //判断登陆
    public function isLogin(){
        $user=$this->getLoginUser();
        if ($user&&$user->id){
            return true;
        }
        return false;
    }

    //获取session值
    public function getLoginUser(){
        if (!$this->account){
            $this->account = session('Bisaccount','','bis');
        }
        return $this->account;
    }

    public function logout(){
            //清空session，退出登录
            session(null,'bis');
            $this->redirect(url('login/index'));
        }
}