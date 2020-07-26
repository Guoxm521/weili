<?php


namespace app\index\controller;


use think\Db;

class Download extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('下载中心');
        $this->assign('link','download');
    }
    public function index() {
        $list = Db::name('download')->where('publish','=','发布')->paginate(8);
        // 获取分页显示
        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function times() {
        $param = $this->request->param();
        $id = $param['id'];
        $times = $param['times']+10;
        $back = Db::name('download')->where('id','=',$id)->data(['times'=>$times])->update();
        if($back) {
            $data = [
                'code'=>1,
                'msg'=>'更新成功'
            ];
        }else {
            $data=[
                'code'=>2,
                'msg'=>'更新失败'
            ];
        }
        return $data;
    }
}