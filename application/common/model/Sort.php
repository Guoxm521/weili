<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Sort extends Model
{
    /*
  * 软删除
  * */
    use SoftDelete;
    protected $delete_time = 'delete_time';
}