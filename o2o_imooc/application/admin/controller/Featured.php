<?php
namespace app\admin\controller;
use think\Controller;
class Featured extends Controller{
	private $obj;
	public function _initialize(){
		$this->obj=model("Featured");
	}

	public function index(){

	}

	public function add(){
		return $this->fetch();
	}
}