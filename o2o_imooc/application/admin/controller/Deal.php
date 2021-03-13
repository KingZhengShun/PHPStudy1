<?php
namespace app\admin\controller;
use think\Controller;

class Deal extends Controller{

	private $obj;
    public function _initialize()
    {
        $this->obj=model('Deal');
    }

	public function index(){
		//获取form表单数据
		$data=input('get.');
		var_dump($data);
		// //
		// if($data[id]){

		// }

		//获取一级分类的数据
		$categorys=model('Category')->getNormalCagetorysByParentId();
		//获取省份数据
		$provinces=model('Regions')->getNormalCitysByParentId();
		return $this->fetch('',[
			'categorys'=>$categorys,
			'provinces'=>$provinces
		]);

	}


	public function apply(){
		return $this->fetch();
	}
}