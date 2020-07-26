<?php


namespace app\index\controller;


use think\Db;

class Entservice extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('企业服务');
    }
    public function index() {
        $param = $this->request->param();
        if(!array_key_exists('classid',$param)){
            $classid = 45;
        }else {
            $classid = $param['classid'];
        };
        //导航栏
        $parent_id = Db::name('sort')->where('sortname','=','企业服务')->find()['id'];
        $ent_nav = Db::name('sort')->where('parent_id','=',$parent_id)->select();

        $sortname = Db::name('sort')->where('id','=',$classid)->find()['sortname'];
        $res = Db::name('ent_services')->where('sortname','=',$sortname)->where('publish','=','发布')->find();
        $views = $res['views']+10;
        $id = $res['id'];
        Db::name('ent_services')->where('id','=',$id)->data(['views'=>$views])->update();
        $this->assign('ent_nav',$ent_nav);
        //新闻title  标识
        $this->assign("classid",$classid);
        $this->assign('res',$res);
        //导航栏判断标识
        $this->assign('link','entservice');
        return $this->fetch();
    }
}