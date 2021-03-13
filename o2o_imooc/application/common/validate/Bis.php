<?php
namespace app\common\validate;
use think\Validate;

class Bis extends Validate{
    protected $rule=[
        'name'=>'require|max:25',
        'city_id'=>'require',
        'se_city_id'=>'require',
        'bank_info'=>'require',
        'bank_name'=>'require',
        'bank_user'=>'require',
        'faren'=>'require',
        'faren_tel'=>'require',
        'email'=>'email',
        'tel'=>'require',
        'contact'=>'require',
        'category_id'=>'require',
        'address'=>'require',
        'open_time'=>'require',
        'content'=>'require',
        'username'=>'require|max:25',
        'password'=>'require',
        'status'=>'number|in:-1,0,1'
    ];

    protected $scene=[
        'bis_base_info'=>['name','email'],
        'bis_zongdian_info'=>['category_id'],
        'bis_user_info'=>['username','password'],
        'bis_status'=>['status']
    ];
}