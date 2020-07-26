<?php


namespace app\common\model;


use think\Model;

class JobMessage extends Model
{
    public function getAddTimeAttr($v) {
        return date('Y-m-d H:i:s',$v);
    }
    public function getVerifyTimeAttr($v) {
        if($v) {
            return date('Y-m-d H:i:s',$v);
        }
    }
}