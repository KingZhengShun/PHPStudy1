<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    public function login()
    {
	return $this->fetch('login');

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
}