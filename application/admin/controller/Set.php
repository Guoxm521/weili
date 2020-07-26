<?php


namespace app\admin\controller;


use http\Client\Curl\User;
use think\Controller;
use app\facade\Common;
use think\Db;
class Set extends Controller
{
    public function info() {
        $result = Db::name('user')->find();
        $this->assign('res',$result);
        return $this->fetch();
    }
    public function password() {
        return $this->fetch();
    }
    public function save() {
        $data = $this->request->post();
        $data['password']=Common::getEnc($data['password']);
        $back = Db::name('user')->data($data)->insert();
    }
    public function update() {
        $data = $this->request->post();
        $id = $data['id'];
        $back=Db::name('user')->where('id',$id)->data($data)->update();
        if($back) {
            $data=[
                'code'=>1,
                'msg'=>'修改成功'
            ];
        }else {
            $data = [
                'code'=>2,
                'msg'=>'修改失败'
            ];
        };
        return $data;
    }
    public function changepassword() {
        $result = $this->request->post();
        $oldpassword = Common::getEnc($result['oldpassword']);
        $repassword = $result['repassword'];
        $pass = Db::name('user')->find();
        $id = $pass['id'];
        $pass = $pass['password'];
    //    密码比对
        if($pass !== $oldpassword) {
            $data = [
                'code'=>2,
                'msg'=>'初始密码错误'
            ];
        }else {
            $newspassword = Common::getEnc($repassword);
            Db::name('user')->where('id',$id)->update(['password'=>$newspassword]);
            $data = [
                'code'=>1,
                'msg'=>"密码修改成功"
            ];
        }
        return $data;
    }
}