<?php


namespace app\admin\controller;


use think\Controller;

class Error extends Controller
{
    public function error404() {
        return $this->fetch();
    }
}