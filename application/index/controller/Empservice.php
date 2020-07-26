<?php


namespace app\index\controller;


use think\Db;

class Empservice extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('员工服务');
        $this->assign('link','empservice');
    }

    public function index() {
        //默认显示公司动态
        $param= $this->request->get();
        if(!array_key_exists('classid',$param)) {
            $classid = 53;
        }else {
            $classid =$param['classid'];
        };
        $this->emp_title($classid);
        //列表
        $sortname = Db::name('sort')->where('id','=',$classid)->value('sortname');
        //分页条件
        $query = ['classid'=>$classid];
        $list = Db::name('emp_services')->where('sortname','=',$sortname)->where('publish','=','发布')->paginate(7,false,['query'=>$query]);
        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
        //头部导航 link标识
        $this->assign('link',"empservice");
        return $this->fetch();
    }
    public function show() {
        $param = $this->request->param();
        $classid = $param['classid'];
        $id=$param['id'];
        $res = Db::name('emp_services')->where('id','=',$id)->find();
        $views = $res['views']+10;
        Db::name('emp_services')->where('id','=',$id)->data(['views'=>$views])->update();
        $next =  Db::name('emp_services')->where('id','>',$id)->order('id','asc')->find();
        $pre = Db::name('emp_services')->where('id','<',$id)->order('id','desc')->find();
        //类别id
        $this->emp_title($classid);
        $this->assign('res',$res);
        $this->assign('next',$next);
        $this->assign('pre',$pre);
        return $this->fetch();
    }
}