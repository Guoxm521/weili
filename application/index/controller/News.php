<?php


namespace app\index\controller;

use think\Db;
class News extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('新闻资讯');
        $this->assign('link',"news");
    }

    public function index(){
        //默认显示公司动态
        $param= $this->request->get();
        if(!array_key_exists('classid',$param)) {
            $classid = 40;
        }else {
            $classid =$param['classid'];
        };
        if(array_key_exists('keyword',$param)) {
            $keyword = $param['keyword'];
            $classid = "";
            $query = ['classid'=>$classid];
            $list = Db::name('news')->where('title','like',"%".$keyword."%")->where('publish','=','发布')->paginate(7,false,['query'=>$query]);
            $page = $list->render();
        }else {
            //列表
            $sortname = Db::name('sort')->where('id','=',$classid)->value('sortname');
            //分页条件
            $query = ['classid'=>$classid];
            $list = Db::name('news')->where('sortname','=',$sortname)->where('publish','=','发布')->paginate(7,false,['query'=>$query]);
            $page = $list->render();
        }
        $this->news_title($classid );
        $this->assign('list',$list);
        $this->assign('page',$page);
        //头部导航 link标识

        return $this->fetch();
    }
    public function show() {
        $param = $this->request->param();
        $classid = $param['classid'];
        $id=$param['id'];
        $res = Db::name('news')->where('id','=',$id)->find();
        $views = $res['views']+10;
        Db::name('news')->where('id','=',$id)->data(['views'=>$views])->update();
        $next =  Db::name('news')->where('id','>',$id)->order('id','asc')->find();
        $pre = Db::name('news')->where('id','<',$id)->order('id','desc')->find();
        //类别id
        $this->news_title($classid);
        $this->assign('res',$res);
        $this->assign('next',$next);
        $this->assign('pre',$pre);
        return $this->fetch();
    }
}