<?php
 namespace app\bis\controller;
 use think\Controller;
 class Login extends Controller{
     public function index(){
         //登陆的逻辑判断
         if (request()->isPost()){
             //获取相关的数据信息
             $data=input("post.");
             //基本数据校验
             $validate_base_info=validate('bis');
             if(!$validate_base_info->scene('bis_user_info')->check($data)){
                $this->error($validate_base_info->getError());
             }
             //通过用户命获取用户的相关信息
             $ret=model('Bisaccount')->get(['username'=>$data['username']]);
             //对登陆信息进行严格的判断
             if (!$ret||$ret->status!=1){
                $this->error('该用户不存在，或者用户还未被审核通过！');
             }

             if ($ret->password!=md5($data['password'].$ret->code)){
                $this->error('密码不正确！');
             }
            //更新最后登陆的时间
             model('Bisaccount')->updateById(['last_login_time'=>time()],$ret->id);
             //保存用户信息
             session('Bisaccount',$ret,'bis');

             return $this->success('登陆成功',url('index/index'));

         }else{
             //获取session的值
             $account=session('Bisaccount','','bis');
             if($account&&$account->id){
                 return $this->redirect('index/index');
             }
             return $this->fetch();
         }


     }

     public function logout(){
         //清除session数据
         session(null,'bis');
         //跳转登陆页面
         $this->redirect('login/index');
     }
 }
