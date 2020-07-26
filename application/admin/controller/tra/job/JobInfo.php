<?php


namespace app\admin\controller\tra\job;
use app\common\model\JobInfo as JobInfoModel;
trait JobInfo
{
    /*
     * 求职招聘信息
     * */
    public function job_info() {
        $param = $this->request->param();
        $title ='';
        $sortname ='';
        //当有查询条件传来的时候
        if (array_key_exists('title', $param) || array_key_exists('sortnmae', $param)) {
            $title = $param['title'];
            $sortname = $param['sortname'];
            if ($title) {
                $map[] = ['title','like','%'.$title.'%'];
            };
            if ($sortname) {
                $map[]=['sortname','like','%'.$sortname."%"];
            }
            if (!array_key_exists('page', $param) || !array_key_exists("limit", $param)) {
                $limit = 6;
                $page = 1;
            } else {
                $limit = $param['limit']; //每页展示条数
                $page = $param['page'];//当前页
            }
            $count = JobInfoModel::where($map)->count();
            $curr = $page;
            $start = ($page-1)*$limit;
            $result = JobInfoModel::where($map)->limit($start, $limit)->order('id', 'asc')->select();
        } else {
            //判断没有页码传来的时候
            if (!array_key_exists('page', $param) || !array_key_exists("limit", $param)) {
                $limit = 6;
                $page = 1;
            } else {
                $limit = $param['limit']; //每页展示条数
                $page = $param['page'];//当前页
            }
            $curr = $page;
            $start = ($page-1)*$limit;
            $count = JobInfoModel::count();
            $result = JobInfoModel::limit($start, $limit)->order('id', 'asc')->select();
        }
        $this->assign('title',$title);
        $this->assign('sortname',$sortname);
        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }
    public function job_infoadd() {
        return $this->fetch();
    }
    public function job_infomodify() {
        return $this->fetch();
    }
    //添加数据
    public function jobinfo_save()
    {
        $result = $this->request->param();
        $result['add_time'] = time();
        $back = JobInfoModel::create($result);
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
    public function jobinfo_delete()
    {
        $id = $this->request->param()['id'];
        $back = JobInfoModel::destroy($id);
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
    // 点击页面获取内容
    public function jobinfo_getcontent()
    {
        $id = $this->request->param()['id'];
        return JobInfoModel::where('id', $id)->select();
    }

    //修改文章的发布情况
    public function jobinfo_changepublish()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        if ($publish == '发布') {
            JobInfoModel::where('id', $id)->update(['publish' => '草稿']);
        } elseif ($publish == '草稿') {
            JobInfoModel::where('id', $id)->update(['publish' => '发布']);
        };
    }

    //根据id查询出数据库信息
    public function jobinfo_selectbyid()
    {
        $id = $this->request->param()['id'];
        $result = JobInfoModel::where('id', $id)->find();
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
    public function jobinfo_update()
    {
        $result = $this->request->param();
        $id = $result['id'];
        $news = new JobInfoModel();
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