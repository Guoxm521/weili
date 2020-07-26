<?php


namespace app\admin\controller;


use app\common\model\Aboutus as AboutusModel;
use app\facade\Common;
use think\Controller;

class Aboutus extends Controller
{
    //首页
    public function index()
    {
        $result = AboutusModel::select();
        $this->assign('res', $result);
        return $this->fetch();
    }

    //添加页
    public function add()
    {
        return $this->fetch();
    }
    //修改页面
    public function modify() {
        return $this->fetch();
    }
    //添加数据
    public function save()
    {
        //files为上传的文件名称
        $result = $this->request->param();
        $files = Common::upload('files');
        if ($files) {
            $img = json_encode($files);
            $result['img'] = $img;
        }
        $result['add_time'] = time();
        $back = AboutusModel::create($result);
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
    public function delete() {
        $id = $this->request->param()['id'];
        $back = AboutusModel::destroy($id,true);
        if($back) {
            $data = [
                'code'=>1,
                'msg'=>'删除成功',
            ];
        }else {
            $data = [
                'code'=>2,
                'msg'=>'删除失败'
            ];
        }
        return $data;
    }
    //获取添加时的类别选项
    public function getoption()
    {
        return Common::getoption('关于我们');
    }

    // 点击页面获取内容
    public function getcontent() {
        $id = $this->request->param()['id'];
        return AboutusModel::where('id',$id)->select();
    }
    //修改文章的发布情况
    public function changepublish() {
        $param = $this->request->param();
        $publish=$param['publish'];
        $id=$param['id'];
        if($publish == '发布') {
            AboutusModel::where('id',$id)->update(['publish'=>'草稿']);
        }elseif($publish == '草稿') {
            AboutusModel::where('id',$id)->update(['publish'=>'发布']);
        };
    }
    //根据id查询出数据库信息
    public function selectbyid() {
        $id = $this->request->param()['id'];
        $result = AboutusModel::where('id',$id)->find();
        if($result) {
            $data = [
                'code'=>1,
                'result'=>$result
            ];
        }else {
            $data = [
                'code'=>2
            ];
        };
       return $data;
    }
    //修改页面
    public function update() {
        $result = $this->request->param();
        $files = Common::upload('files');
        if ($files) {
            $img = json_encode($files);
            $data['img'] = $img;
        }
        $id = $result['id'];
        if( $result['sortname']) {
            $data['sortname'] = $result['sortname'];
        }
        if($result['content']) {
            $data['content'] = $result['content'];
        }
        if($result['publish']) {
            $data['publish'] = $result['publish'];
        }
        $aboutus = new AboutusModel();
        $back = $aboutus->save($data,['id'=>$id]);
        if($back) {
            $data = [
                'code'=>1,
                'msg'=>'更新成功'
            ];
        }else {
            $data =[
                'code'=>2,
                'msg'=>'更新失败'
            ];
        }
        return $data;
    }
}