<?php


namespace app\admin\controller\tra\system;

use app\common\model\Download as DownloadModel;

trait Download
{
    public function download()
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
        $count = DownloadModel::count();
        $result = DownloadModel::limit($start, $limit)->order('id', 'asc')->select();

        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }

    public function download_add()
    {
        return $this->fetch();
    }

    public function download_save()
    {
        $result = $this->request->param();
        $file = request()->file('file');
        $info = $file->move('./downloads');
        if ($info) {
            $result['file'] = $info->getSaveName();
        } else {
            return $file->getError();
        };
        $result['add_time'] = time();
        $back = DownloadModel::create($result);
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

    //修改文章的发布情况
    public function download_changepublish()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        if ($publish == '发布') {
            DownloadModel::where('id', $id)->update(['publish' => '草稿']);
        } elseif ($publish == '草稿') {
            DownloadModel::where('id', $id)->update(['publish' => '发布']);
        };
    }

    //删除数据
    public function download_delete()
    {
        $id = $this->request->param()['id'];
        $back = DownloadModel::destroy($id, true);
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
}