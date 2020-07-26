<?php


namespace app\admin\controller;


use app\common\model\EntServices as EntServicesModel;
use app\facade\Common;
use think\Controller;

class EntServices extends Controller
{
    public function index()
    {
        $param = $this->request->param();
        $title = "";
        $sortname = "";
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
            $count = EntServicesModel::where($map)->count();
            $curr = $page;
            $start = ($page-1)*$limit;
            $result = EntServicesModel::where($map)->limit($start, $limit)->order('id', 'desc')->select();

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
            $count = EntServicesModel::count();
            $result = EntServicesModel::limit($start, $limit)->order('id', 'desc')->select();
        }
        $this->assign('title',$title);
        $this->assign('sortname',$sortname);
        $this->assign('res', $result); //返回结果
        $this->assign('count', $count); //总数
        $this->assign('curr', $curr); //当前页
        return $this->fetch();
    }
    //添加页面
    public function add()
    {
        return $this->fetch();
    }
    //修改页面
    public function modify() {
        return $this->fetch();
    }
    //    获取添加时候的类别选项
    public function getoption()
    {
        return Common::getoption('企业服务');
    }
    //添加数据
    public function save()
    {
        //files为上传的文件名称
        $result = $this->request->param();
        $file = request()->file('files');
        $info = $file->move( './uploads');
        if($info){
            $result['img'] =$info->getSaveName();
        }else{
            return $file->getError();
        };
        $result['add_time'] = time();
        $back = EntServicesModel::create($result);
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
    public function delete()
    {
        $id = $this->request->param()['id'];
        $back = EntServicesModel::destroy($id, true);
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
    public function getcontent()
    {
        $id = $this->request->param()['id'];
        return EntServicesModel::where('id', $id)->select();
    }

    //修改文章的发布情况
    public function changepublish()
    {
        $param = $this->request->param();
        $publish = $param['publish'];
        $id = $param['id'];
        if ($publish == '发布') {
            EntServicesModel::where('id', $id)->update(['publish' => '草稿']);
        } elseif ($publish == '草稿') {
            EntServicesModel::where('id', $id)->update(['publish' => '发布']);
        };
    }
    //根据id查询出数据库信息
    public function selectbyid()
    {
        $id = $this->request->param()['id'];
        $result = EntServicesModel::where('id', $id)->find();
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
    public function update()
    {
        $result = $this->request->param();
        if(array_key_exists('isupfile',$result)) {
            $file = request()->file('files');
            $info = $file->move( './uploads');
            if($info){
                $result['img'] =$info->getSaveName();
            }else{
                return $file->getError();
            };
        }
        $id = $result['id'];
        $news = new EntServicesModel();
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