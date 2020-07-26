<?php


namespace app\admin\controller\tra\system;

use app\common\model\Contactus as ContactusModel;
use think\Db;
trait Contactus
{
    public function contactus() {
        $result = ContactusModel::order('id','asc')->select();
        $this->assign('res',$result);
        return $this->fetch();
    }
    public function contactus_save(){
        $result = $this->request->post();
        $titleList =$result['titleList'];
        $contentList = $result['contentList'];
        $length = count($titleList);
        $data = [];
        for($i=0;$i<$length;$i++) {
            $data[$i]['title']=$titleList[$i];
            $data[$i]['content']=$contentList[$i];
        };
        $Contactusmodel = new \app\common\model\Contactus();
        //存储之前先删除
        Db::name('contactus')->where('id','>','0')->delete();
        $back = $Contactusmodel->saveAll($data);
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
    public function contactus_delete()
    {
        $id = $this->request->param()['id'];
        $back = ContactusModel::where('id','=',$id)->delete();
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