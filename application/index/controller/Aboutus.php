<?php


namespace app\index\controller;


use think\Db;

class Aboutus extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('关于我们');
        $this->assign('link', 'aboutus');
    }

    public function index()
    {
        $culture = Db::name('aboutus')
            ->where('sortname', '=', '企业文化')
            ->where('publish', '=', '发布')
            ->order('id', 'asc')
            ->find();
        $intro = Db::name('aboutus')
            ->where('sortname', '=', '公司简介')
            ->where('publish', '=', '发布')
            ->order('id', 'asc')
            ->find();
        foreach ($intro as $k => &$v) {
            if ($k == 'img') {
                $v = json_decode($v);
            }
        };
        $honour = Db::name('aboutus')
            ->where('sortname', '=', '荣誉资质')
            ->where('publish', '=', '发布')
            ->order('id', 'asc')
            ->find();
        foreach ($honour as $k => &$v) {
            if ($k == 'img') {
                $v = json_decode($v);
            }
        };
        $this->assign('culture', $culture);
        $this->assign('intro', $intro);
        $this->assign('honour', $honour);
        return $this->fetch();
    }
}