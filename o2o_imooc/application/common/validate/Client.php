<?php
namespace app\common\validate;
use think\Validate;

class Client extends Validate{
    protected $rule=[
        'username'=>'require|max:25',
        'email'=>'require|email',
        'password'=>'require',
        'repassword'=>'require',
    ];

    protected $scene=[
        'client_base_info'=>['username','email','password','repassword'],
        'client_login_info'=>['username','password']
    ];
}