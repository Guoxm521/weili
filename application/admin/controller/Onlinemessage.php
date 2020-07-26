<?php


namespace app\admin\controller;


use app\common\model\OnlineMessage as OLmessagemodel;
use think\Controller;

class Onlinemessage extends Controller
{
    public function index()
    {
        $param = $this->request->param();

        //判断没有页码传来的时候
        if (!array_key_exists('page', $param) || !array_key_exists("limit", $param)) {
            $limit = 10;
            $page = 1;
        } else {
            $limit = $param['limit']; //每页展示条数
            $page = $param['page'];//当前页
        }
        $curr = $page;
        $start = ($page - 1) * $limit;
        $count = OLmessagemodel::count();
        $result = OLmessagemodel::limit($start, $limit)->order('id', 'desc')->select();

        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }
    //添加数据
    public function save()
    {
        //files为上传的文件名称
        $result = $this->request->param();
        $result['add_time'] = time();
        $back = OLmessagemodel::create($result);
        if ($back) {
            $data = [
                'code' => 1,
                'msg' => '添加成功'
            ];
        } else {
            $data = [
                'code' => 2,
                'msg' => '添加失败'
            ];
        }
        return $data;
    }
    //修改求职者信息的审核情况  并且添加审核时间
    public function changeverify()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        $verify_time = time();
        if ($publish == '已审核') {
            OLmessagemodel::where('id', $id)->update(['publish' => '未审核','verify_time'=>$verify_time]);
        } elseif ($publish == '未审核') {
            OLmessagemodel::where('id', $id)->update(['publish' => '已审核','verify_time'=>$verify_time]);
        };

    }
}