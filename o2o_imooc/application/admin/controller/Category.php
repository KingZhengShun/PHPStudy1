 <?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj=model('Category');
    }

    /**
     * @return mixed
     * 生活服务类数据获取
     */
    public function index()
    {
        $parentId=input('get.parent_id',0,'intval');
        $categorys=$this->obj->getFirstCagetorys($parentId);
        //模拟获取静态地图信息并将数据返回前端页面。
        $url=\Map::staticImage('天台客运中心');
        $this->assign('urlDtImage',$url);

	    return $this->fetch('',[
            'categorys'=>$categorys,
        ]);
    }

    /**
     * @return mixed
     * 添加分类
     */
    public function add(){
        $categorys=$this->obj->getNormalFirstCagetory();
        return $this->fetch('',[
            'categorys'=>$categorys,
        ]);
    }

    /**
     * @param int $id 分类商品的主键id
     * @return mixed
     */
    public function edit($id=0){
        if(intval($id)<1){
            $this->error("参数不合法！");
        }
        $category=$this->obj->get($id);
        $categorys=$this->obj->getNormalFirstCagetory();
        return $this->fetch('',[
            'category'=>$category,
            'categorys'=>$categorys
        ]);

    }
    /**
     * 对商品进行上传和更新
     */
  public function save() {
      /**
       * 做严格判断！
       */
        if (!request()->isPost()){
            $this->error('请求失败！');
        }
        $data = input('post.');
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        if(!empty($data['id'])){
            return $this->update($data);
        }
        $res = $this->obj->add($data);
        if($res){
            $this->success('添加成功！');
        }else{
            $this->error('插入失败！');
        }
    }

    /**
     * @param $data
     * 跟新数据
     */
    public function update($data){
        $res=$this->obj->save($data,['id'=>intval($data['id'])]);
        if($res){
            $this->success('更新成功!');
        }else{
            $this->error('跟新失败！');
        }
    }

    /**
     * 逻辑排序
     * @param $id   商品的主键id
     * @param $listorder 商品的排序序号
     */
    public function listorder($id,$listorder){
        $res=$this->obj->save(['listorder'=>$listorder],['id'=>$id]);
        if ($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'更新失败！');
        }
    }

    /**
     * 修改状态
     */
    public function status(){
        $data = input('get.');
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        $res=$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if ($res){
            $this->success('状态更新成功！');
        }else{
            $this->error('状态更新失败');
        }

    }

}