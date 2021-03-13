<?php
namespace app\huanran\controller;
use think\Controller;

class Photoframe extends Controller{
	public function index(){
		return $this->fetch();
	}
}