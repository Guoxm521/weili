<?php


namespace app\admin\controller;


use think\console\Command;
use think\Controller;
use app\common\model\Sort as SortModel;
use app\common\tra\Common;


class Sort extends Controller
{
    public function index() {
        $prepareMenu = new Common();
        $result = $prepareMenu->prepareMenu();
        $this->assign('list',$result);
        return $this->fetch();
    }
    public function add() {
        return $this->fetch();
    }
    //添加数据
    public function save() {
        $param = $this->request->post();
        $parent_id = $param['parent_id'];
        if($parent_id != 0) {
            $id =$parent_id;
            $result = SortModel::get($id);
            $level = $result['level'];
            $param['level']=$level+1;
        }else {
            $param['level']=1;
        }
        SortModel::create($param);
    }
    //删除数据  使用的是软删除方法
    public function delete() {
        $param = $this->request->param();
        $id = $param['id'];
        //删除钱判断有没有子项
        $parent_id = $id;
        $children = SortModel::where('parent_id',$parent_id)->find();
        if($children) {
            $data = [
                'code'=>2,
                'msg'=>'该类别存在子类别，无法删除！',
            ];
        }else {
            $data = [
                'code'=>1,
                'msg'=>'删除成功！'
            ];
            SortModel::destroy($id);
        }
        return $data;
    }

    /*
     * 修改数据前需要先根据id获得值
     * 然后在进行修改保存
     * */
    public function getcontent() {
        $param = $this->request->param();
        $id = $param['id'];
        return SortModel::get($id);
    }
    public function update() {
        $param = $this->request->param();
        $id = $param['parent_id'];
        $sortname = $param['sortname'];
        $linkname = $param['linkname'];
        $result =  SortModel::where('id',$id)->update(['sortname'=>$sortname,'linkname'=>$linkname]);
        if($result) {
            $data = [
                'code'=>1,
                'msg'=>'修改成功'
            ];
        }else {
            $data = [
                'code'=>1,
                'msg'=>'修改成功'
            ];
        }
        return $data;
    }
}