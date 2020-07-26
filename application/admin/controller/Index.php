<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\facade\Session;

class Index extends Controller
{
    public function index() {
        $result = Db::name('user')->find();
        $this->assign('res',$result);
        return $this->fetch();
    }
}