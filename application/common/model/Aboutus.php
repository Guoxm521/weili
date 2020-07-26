<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Aboutus extends Model
{
    use SoftDelete;
    protected $delete_time = 'delete_time';
    public function getAddTimeAttr($v) {
        return date('Y-m-d H:i:s',$v);
    }
}
