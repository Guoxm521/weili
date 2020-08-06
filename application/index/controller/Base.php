<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
class Base extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->assign('link','index');
        $this->header();
        $this->footer();
    }
   /*
    * 头部数据查询
    * @return $this
    * */
    public function header() {
        $result = Db::name('sort')->where('parent_id','=',0)->select();
        foreach ($result as $k=>&$v) {
            $id = $v['id'];
            $children = Db::name('sort')->where('parent_id','=',$id)->select();
            $v['children']=$children;
        }
        $this->assign('nav',$result);
    }
    /*
     *banner图
     * */
    public function banner($sortname) {
        $res = Db::name('banner')->where('sortname','=',$sortname)->where('publish','=','发布')->find();
        $this->assign('banner',$res);
    }

    /*底部查询*/
    public function footer() {
        $list1 = Db::name('sort')->where('parent_id','=',0)->limit(0,3)->select();
        $list2 = Db::name('sort')->where('parent_id','=',0)->limit(4,3)->select();
        $res = Db::name('contactus')->order('id','asc')->select();
        $this->assign('contact_footer',$res);
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
    }
    /*
     * 新闻页面的头部
     * */
    public function news_title($classid) {
        //导航栏
        $parent_id = Db::name('sort')->where('sortname','=','新闻资讯')->find()['id'];
        $news_nav = Db::name('sort')->where('parent_id','=',$parent_id)->select();
        $this->assign('news_nav',$news_nav);
        //新闻title  标识
        $this->assign("classid",$classid);
    }

    /*
     *员工服务页面的头部
     * */
    public function emp_title($classid) {
        //导航栏
        $parent_id = Db::name('sort')->where('sortname','=','员工服务')->find()['id'];
        $news_nav = Db::name('sort')->where('parent_id','=',$parent_id)->select();
        $this->assign('news_nav',$news_nav);
        //新闻title  标识
        $this->assign("classid",$classid);
    }

    /*
     * 求职招聘的头部
     * */
    public function jobs_title($classid) {
        //导航栏
        $parent_id = Db::name('sort')->where('sortname','=','求职招聘')->find()['id'];
        $news_nav = Db::name('sort')->where('parent_id','=',$parent_id)->select();
        $this->assign('news_nav',$news_nav);
        //新闻title  标识
        $this->assign("classid",$classid);
    }

    /*
 * 联系我们
 * */
    public function contact_title($classid) {
        //导航栏
        $parent_id = Db::name('sort')->where('sortname','=','联系我们')->find()['id'];
        $news_nav = Db::name('sort')->where('parent_id','=',$parent_id)->select();
        $this->assign('news_nav',$news_nav);
        //新闻title  标识
        $this->assign("classid",$classid);
    }

}