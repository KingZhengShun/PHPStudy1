<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
class Featured extends Base{
	private $obj;
	public function _initialize(){
		$this->obj=model("Featured");
	}

	public function index(){
		//获取推荐位的类别
		$types=config('Featured.featured_type');
		$type=input('get.type',0,'intval');
		//获取列表数据
		$results=$this->obj->getFeaturedsByType($type);
		// print_r($results);exit;
		return $this->fetch("",[
			'types'=>$types,
			'results'=>$results
		]);
	}

	public function add(){
		if(request()->isPost()){
			$data=input('post.');
			// print_r($data);exit;
			$file=request()->file('imgs');
			 // print_r($file);exit;
			$info = $file->move('uploads/image');
			if($info){
	            // 成功上传后 获取上传信息
	            $data['image'] = '/uploads/image/'.$info->getSaveName();
	            // print_r($data);exit;
	            $featid=model('Featured')->add($data);
	            if($featid){
	            	$this->success('数据插入成功');
	            }else{
	            	$this->error('数据插入失败');
	            }
	        }
		}else{
			//获取推荐位
			$types=config('Featured.featured_type');
			return $this->fetch('',[
				'types'=>$types
			]);
		}
		
	}
	
}