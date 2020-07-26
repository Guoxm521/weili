<?php


namespace app\admin\controller;


use think\Controller;
use app\admin\controller\tra\system as SystemTra;

class System extends Controller
{
    use SystemTra\links;
    use SystemTra\Banner;
    use SystemTra\Download;
    use SystemTra\Contactus;

}