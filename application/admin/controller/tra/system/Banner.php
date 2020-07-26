<?php


namespace app\admin\controller\tra\system;

use app\common\model\Banner as BannerModel;
use app\common\model\Sort as SortModel;
use app\facade\Common;
trait Banner
{
    public function banner() {
        $result = BannerModel::select();
        $coption = SortModel::where('parent_id','=','0')->select();
        $this->assign('optionlenLen',count($coption));
        $this->assign('res',$result);
        return $this->fetch();
    }
    public function banner_add(){
        $option = SortModel::where('parent_id','=','0')->select();
        $coption = BannerModel::column('sortname');
        $this->assign('coption',$coption);
        $this->assign('options',$option);
        return $this->fetch();
    }
    //保存
    public function banner_save() {
        $result = $this->request->param();
        $file = request()->file('files');
        $info = $file->move( './uploads');
        if($info){
            $result['img'] =$info->getSaveName();
        }else{
            return $file->getError();
        };
        $result['add_time'] = time();
        $back = BannerModel::create($result);
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
    public function banner_changepublish() {
        $param = $this->request->param();
        $publish=$param['publish'];
        $id=$param['id'];
        if($publish == '发布') {
            BannerModel::where('id',$id)->update(['publish'=>'草稿']);
        }elseif($publish == '草稿') {
            BannerModel::where('id',$id)->update(['publish'=>'发布']);
        };
    }
    //删除数据
    public function banner_delete() {
        $id = $this->request->param()['id'];
        $back = BannerModel::destroy($id,true);
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
    // 点击页面获取内容
    public function banner_getcontent() {
        $id = $this->request->param()['id'];
        return BannerModel::where('id',$id)->select();
    }
    //获去所有的类别
    public function getoption() {
        return SortModel::where('parent_id','=','0')->select();
    }
    public function banner_modify() {
        $id = $this->request->param()['id'];
        $result = BannerModel::where('id',$id)->select();
        $this->assign('res',$result[0]);
        return $this->fetch();
    }

    //修改页面
    public function banner_update()
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
        $result['add_time']=time();
        $news = new BannerModel();
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