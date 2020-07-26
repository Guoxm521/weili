<?php


namespace app\admin\controller\tra\system;

use app\common\model\Links as linksmodel;

trait links
{
    //友情链接列表页
    public function links()
    {
        $param = $this->request->param();
        //判断没有页码传来的时候
        if (!array_key_exists('page', $param) || !array_key_exists("limit", $param)) {
            $limit = 8;
            $page = 1;
        } else {
            $limit = $param['limit']; //每页展示条数
            $page = $param['page'];//当前页
        }
        $curr = $page;
        $start = ($page - 1) * $limit;
        $count = linksmodel::count();
        $result = linksmodel::limit($start, $limit)->order('id', 'asc')->select();
        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }

    //友情链接添加
    public function link_add()
    {
        return $this->fetch();
    }

    public function link_modify()
    {
        $id = $this->request->param()['id'];
        $res = linksmodel::where('id',$id)->select();
        $this->assign('res',$res[0]);
        return $this->fetch();
    }

    //添加数据
    public function links_save()
    {
        $result = $this->request->param();
        $result['add_time'] = time();
        $back = linksmodel::create($result);
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

    //删除数据
    public function links_delete()
    {
        $id = $this->request->param()['id'];
        $back = linksmodel::destroy($id, true);
        if ($back) {
            $data = [
                'code' => 1,
                'msg' => '删除成功',
            ];
        } else {
            $data = [
                'code' => 2,
                'msg' => '删除失败'
            ];
        }
        return $data;
    }

    //修改文章的发布情况
    public function changepublish()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        if ($publish == '发布') {
            linksmodel::where('id', $id)->update(['publish' => '草稿']);
        } elseif ($publish == '草稿') {
            linksmodel::where('id', $id)->update(['publish' => '发布']);
        };
    }

    //根据id查询出数据库信息
    public function selectbyid()
    {
        $id = $this->request->param()['id'];
        $result = linksmodel::where('id', $id)->find();
        if ($result) {
            $data = [
                'code' => 1,
                'result' => $result
            ];
        } else {
            $data = [
                'code' => 2
            ];
        };
        return $data;
    }

    //修改页面
    public function links_update()
    {
        $result = $this->request->post();
        $id = $result['id'];
        $result['add_time']=time();
        $news = new linksmodel();
        $back = $news->save($result, ['id' => $id]);
        if ($back) {
            $data = [
                'code' => 1,
                'msg' => '更新成功'
            ];
        } else {
            $data = [
                'code' => 2,
                'msg' => '更新失败'
            ];
        }
        return $data;
    }
}