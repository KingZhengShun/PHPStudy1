<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    public function login()
    {
	   //获取session
        $user=session('o2o_user','','o2o');
        if($user&&$user->id){
            $this->redirect(url('index/index'));
        }
        return $this->fetch();

    }


     public function register()
    {
	    if(request()->isPost()){
	    	//获取表单数据
	    	$data=input('post.');
	    	//校验表单数据 TP5 validate
	    	$user_info=validate("Client");
	    	if(!$user_info->scene('client_base_info')->check($data)){
	    		$this->error($user_info->geterror());
	    	}
	    	//两次输入密码是否相同
	    	if($data['password']!=$data['repassword']){
	    		$this->error('两次输入密码不同！');
	    	}
	    	//校验验证码是否正确！
	    	if(!captcha_check($data['verifyCode'])){   		
	    		$this->error('验证码不正确！');
	    	}
	    	//密码进行md5加密
	    	$data['code']=mt_rand(100,10000);
	    	$data['password']=md5($data['password'].$data['code']);
	    	//数据入库
	    	try{
	    		$clientInfoId=model('User')->add($data);
	    	}catch(\Exception $e){
	    		$this->error($e->getMessage());
	    	}
	    	if($clientInfoId){
	    		$this->success('注册成功！',url("user/login"));
	    	}else{
	    		$this->error("请重新注册！");
	    		return $this->fetch('register');
	    	}
	    }
		return $this->fetch('register');
    }

    public function loginCheck(){
            
            //检查信息提交方式
            if (!request()->isPost()) {
                $this->error('信息提交方式有误！');
            }
            //获取表单信息
            $data=input('post.');
            
            //对表单继续校验
            $valid=validate('Client');
            if (!$valid->scene('client_login_info')->check($data)) {
                $this->error($valid->geterror());
            }
            
            //回去账户信息和密码
            try{
                $clientInfo=model('User')->getClientInfoByUserName($data['username']);
            }catch(\Exception $e){
                $this->error($e->getMessage());
            } 

            //校验账户是否存在
            if(!$clientInfo||$clientInfo->status!=1){
                $this->error('账户不存在！');
            }

            //校验密码是否正确
            $password=md5($data['password'].$clientInfo->code);
            if($password!=$clientInfo->password){
                $this->error("密码不正确");
            }
            //登录成功
            model('User')->updateById(['last_login_time'=>time()],$clientInfo->id); 
            //把用户的信息记录到session
            session('o2o_user',$clientInfo,'o2o');
            //跳转到首页；
            $this->success('登录成功',url('index/index'));
        }


        public function logout(){
            //清空session，退出登录
            session(null,'o2o');
            $this->redirect(url('user/login'));
        }
}