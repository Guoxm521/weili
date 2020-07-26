<?php


namespace app\index\controller;


use think\Db;

class Contact extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->banner('联系我们');
        $this->assign('link', 'contact');
    }

    public function index()
    {
        //默认显示公司动态
        $param = $this->request->get();
        if (!array_key_exists('classid', $param)) {
            $classid = 62;
        } else {
            $classid = $param['classid'];
        };
        switch ($classid) {
            case 62:
                $type='联系我们';
                $this->contact();
                break;
            case 63:
                $type='在线留言';
                break;
            default:
                $type='无';
        };
        $this->assign('type',$type);
        $this->contact_title($classid);
        return $this->fetch();
    }

    public function contact()
    {
        $res = Db::name('contactus')->order('id','asc')->select();
        $this->assign('res',$res);
    }
    public function save() {
        $param = $this->request->post();
        $param['add_time'] = time();
        $param['publish']='未审核';
        $back = Db::name('online_message')->data($param)->insert();
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