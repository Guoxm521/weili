<?php

namespace app\index\controller;


use think\Db;

class Index extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('link','index');
        $this->banner('网站首页');
    }

    public function index()
    {
        $this->assign('link', 'index');
        $this->news();
        $this->joninfo();
        $this->ent();
        $this->link();
        return $this->fetch();
    }

    public function news()
    {
        $dongtai = Db::name('news')
            ->where('sortname', '=', '公司动态')
            ->where('publish','=','发布')
            ->limit(0, 3)->order('id', 'desc')
            ->select();
        $this->assign('dongtai',$dongtai);
        $kuaixun = Db::name('news')->where('sortname', '=', '行业快讯')
            ->where('publish','=','发布')
            ->limit(0, 3)
            ->order('id', 'desc')
            ->select();
        $this->assign('kuaixun',$kuaixun);
        $zhengce = Db::name('news')
            ->where('sortname', '=', '政策法规')
            ->where('publish','=','发布')
            ->limit(0, 7)->order('id', 'desc')
            ->select();
        $this->assign('zhengce',$zhengce);
    }
    public function joninfo() {
        $jobinfo = Db::name('job_info')
            ->where('publish','=','发布')
            ->limit(0, 6)
            ->order('id', 'desc')
            ->select();
        $this->assign('jobinfo',$jobinfo);
    }
    public function ent() {
        $ent = Db::name('ent_services')
            ->where('publish','=','发布')
            ->limit(0, 3)
            ->order('id', 'desc')
            ->select();
        $this->assign('ent',$ent);
    }
    public function link () {
        $link = Db::name('links')
            ->where('publish','=','发布')
            ->limit(0, 8)
            ->order('id', 'desc')
            ->select();
        $this->assign('links',$link);
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
