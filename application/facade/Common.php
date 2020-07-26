<?php


namespace app\facade;


use app\common\model\Sort;
use think\Facade;

class Common extends Facade
{
    /*
     * 给公共代码块注册门面
     * */


    public static function getoption($sortname)
    {
        $id = Sort::where('sortname',$sortname)->column('id')[0];
        $parent_id = $id;
        return Sort::where('parent_id',$parent_id)->all();
    }

    protected static function getFacadeClass() {
        return 'app\common\tra\Common';
    }

    //密码加密
    public static function getEnc($password){
        $password = md5($password);
        $password = substr($password,0,15);
        return md5($password);
    }
}