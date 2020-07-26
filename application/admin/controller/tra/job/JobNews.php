<?php


namespace app\admin\controller\tra\job;
use app\facade\Common;
use app\common\model\JobNews as JobNewsModel;
trait JobNews
{
    /*
   * 求职招聘新闻
   * */
    public function job_news() {
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
            $count = JobNewsModel::where($map)->count();
            $curr = $page;
            $start = ($page-1)*$limit;
            $result = JobNewsModel::where($map)->limit($start, $limit)->order('id', 'asc')->select();
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
            $count = JobNewsModel::count();
            $result = JobNewsModel::limit($start, $limit)->order('id', 'asc')->select();
        }
        $this->assign('title',$title);
        $this->assign('sortname',$sortname);
        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }
    public function job_newsadd() {
        return $this->fetch();
    }
    public function job_newsmodify() {
        return $this->fetch();
    }
    //    获取添加时候的类别选项
    public function jobnews_getoption()
    {
        $result = Common::getoption('求职招聘');
        $arr=['招聘信息','在线求职'];
        $newarr = [];
        foreach ($result as $k=>$v) {
            if(!in_array($v['sortname'],$arr)) {
                $newarr[]=$v;
            }
        }
        return $newarr;
    }
    //添加数据
    public function jobnews_save()
    {
        //files为上传的文件名称
        $result = $this->request->param();
        $result['add_time'] = time();
        $back = JobNewsModel::create($result);
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
    public function jobnews_delete()
    {
        $id = $this->request->param()['id'];
        $back = JobNewsModel::destroy($id, true);
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
    public function jobnews_getcontent()
    {
        $id = $this->request->param()['id'];
        return JobNewsModel::where('id', $id)->select();
    }

    //修改文章的发布情况
    public function jobnews_changepublish()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        if ($publish == '发布') {
            JobNewsModel::where('id', $id)->update(['publish' => '草稿']);
        } elseif ($publish == '草稿') {
            JobNewsModel::where('id', $id)->update(['publish' => '发布']);
        };
    }

    //根据id查询出数据库信息
    public function jobnews_selectbyid()
    {
        $id = $this->request->param()['id'];
        $result = JobNewsModel::where('id', $id)->find();
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
    public function jobnews_update()
    {
        $result = $this->request->param();
        $id = $result['id'];
        $news = new JobNewsModel();
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