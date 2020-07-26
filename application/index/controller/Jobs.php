<?php


namespace app\index\controller;


use think\Db;

class Jobs extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('求职招聘');
        $this->assign('link','jobs');
    }
    public function index() {
        //默认显示公司动态
        $param= $this->request->get();
        if(!array_key_exists('classid',$param)) {
            $classid = 57;
        }else {
            $classid =$param['classid'];
        };
        $this->jobs_title($classid);

        switch ($classid) {
            case 57 : $type=1;  //信息
            $this->job_info($classid);
            break;
            case 58: $type=2;  //求职
            break;
            default: $type=3; //新闻
            $this->jobs_news($classid);
        }
        $this->assign('type',$type);

        return $this->fetch();
    }
    public function job_info($classid) {
        $sortname = Db::name('sort')->where('id','=',$classid)->value('sortname');
        //分页条件
        $query = ['classid'=>$classid];
        $list = Db::name('job_info')->where('publish','=','发布')->paginate(8,false,['query'=>$query]);
        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
    }
    public function jobs_news($classid) {
        //列表
        $sortname = Db::name('sort')->where('id','=',$classid)->value('sortname');
        //分页条件
        $query = ['classid'=>$classid];
        $list = Db::name('job_news')->where('sortname','=',$sortname)->where('publish','=','发布')->paginate(7,false,['query'=>$query]);
        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
    }
    public function show() {
        $param = $this->request->param();
        $classid = $param['classid'];
        $id=$param['id'];
        $res = Db::name('job_news')->where('id','=',$id)->find();
        $views = $res['views']+10;
        Db::name('job_news')->where('id','=',$id)->data(['views'=>$views])->update();
        $next =  Db::name('job_news')->where('id','>',$id)->order('id','asc')->find();
        $pre = Db::name('job_news')->where('id','<',$id)->order('id','desc')->find();
        //类别id
        $this->jobs_title($classid);
        $this->assign('res',$res);
        $this->assign('next',$next);
        $this->assign('pre',$pre);
        return $this->fetch();
    }
    public function save() {
        $param = $this->request->post();
        $param['add_time'] = time();
        $param['publish']='未审核';
        $back = Db::name('job_message')->data($param)->insert();
        if ($back) {
            $data = [
                'code'=>1,
                'msg'=>'留言成功'
            ];
        }else {
            $data = [
                'code'=>2,
                'msg'=>'留言失败'
            ];
        }
        return json($data);
    }
}