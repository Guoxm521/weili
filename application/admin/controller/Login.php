<?php


namespace app\admin\controller;


use app\facade\Common;
use think\Controller;
use think\Db;
use think\facade\Session;

class Login extends Controller
{
    public function index() {
        if(Session::get('name')) {
            $this->success('该用户已经登陆，正在跳转',url('admin/index/index'));
        }
        return $this->fetch();
    }
    public function save() {
        $data = $this->request->post();
        $info = $this->validate($data,[
            'vercode|验证码'=>'require|captcha'
        ]);
        //判断验证码
        if($info != 1) {
            $data = [
                'code'=>2,
                'msg'=>'验证码错误，请输入正确的验证码',
                'data'=>$data
            ];
            return $data;
        }else {
        //    判断用户名或者密码
            $name = $data['name'];
            $password = Common::getEnc($data['password']);
            $back = Db::name('user')->where(['nickname'=>$name,'password'=>$password])->find();
            if(!$back) {
                $data = [
                    'code'=>3,
                    'msg'=>'用户名或密码错误,请重新输入'
                ];
                return $data;
            }else {
                Session::set('nickname',$back['nickname']);
                Session::set('id',$back['id']);
                Session::set('name',$back['name']);
                $data = [
                    'code'=>1,
                    'msg'=>'登录成功'
                ];
                return $data;
            }
        }
    }
    public function out() {
        Session::clear();
        return ['code'=>1,'msg'=>'退出成功'];
    }
}