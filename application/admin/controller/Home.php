<?php


namespace app\admin\controller;


use think\Controller;
use app\common\model as model;
use app\facade\Common ;
use think\Db;

class Home extends Controller
{
    public function index(){
        //待发布的新闻
        $news = model\News::where('publish','草稿')->count();
        //待发布的求职信息
        $job_info = model\JobInfo::where('publish','草稿')->count();
        //待查看留言
        $message = model\OnlineMessage::where('publish','未审核')->count();
        //待看求职信息
        $job_message = model\JobMessage::where('publish','未审核')->count();

        $result = Db::name('user')->find();
        $this->assign('res',$result);
        ////获取新闻类别
        //$newsoption = Common::getoption('新闻资讯');
        //$newsList = [];
        //foreach ($newsoption as $v) {
        //    $newsList[] = $v['sortname'];
        //};
        ////获取每个类别的新闻发布情况
        //$newspublish = [];
        //$newsdraft =[];
        //foreach($newsList as $v) {
        //    $newspublish[] = model\News::where('publish','发布')->where('sortname',$v)->count();
        //    $newsdraft[] = model\News::where('publish','草稿')->where('sortname',$v)->count();
        //};

        $this->assign('news',$news);
        $this->assign('job_info',$job_info);
        $this->assign('message',$message);
        $this->assign('job_message',$job_message);

        return $this->fetch();
    }
    public function echart() {
        //获取新闻类别
        $newsoption = Common::getoption('新闻资讯');
        $newsList = [];
        foreach ($newsoption as $v) {
            $newsList[] = $v['sortname'];
        };
        //获取每个类别的新闻发布情况
        $newspublish = [];
        $newsdraft =[];
        foreach($newsList as $v) {
            $newspublish[] = model\News::where('publish','发布')->where('sortname',$v)->count();
            $newsdraft[] = model\News::where('publish','草稿')->where('sortname',$v)->count();
        };
        //企业服务
        $entservices = Common::getoption('企业服务');
        $entList =[];
        foreach ($entservices as $v) {
            $entList[] = $v['sortname'];
        };
        $entpublish = [];
        foreach ($entList as $v ) {
            $entpublish[] = model\EntServices::where('publish','发布')->where('sortname',$v)->count();
        };
        return [
            'newsList'=>$newsList,
            'newspublish'=>$newspublish,
            'newsdraft'=>$newsdraft,
            'entList'=>$entList,
            'entpublish'=>$entpublish
        ];
    }
}