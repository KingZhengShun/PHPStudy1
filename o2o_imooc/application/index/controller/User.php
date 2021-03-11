<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    public function userLogin()
    {
	return $this->fetch('login');

    }


     public function userRegister()
    {
	return $this->fetch('register');
    }


}