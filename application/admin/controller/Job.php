<?php


namespace app\admin\controller;



use think\Controller;

use app\admin\controller\tra\job as Jobtra;

class Job extends Controller
{
    use Jobtra\JobNews;
    use Jobtra\JobInfo;
    use Jobtra\JobMessage;


}