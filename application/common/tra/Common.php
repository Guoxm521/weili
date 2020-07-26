<?php


namespace app\common\tra;

use app\common\model\Sort;
class Common
{
    /*
     * 类别表  展示成父子树
     * */
    public function prepareMenu($parent_id = 0, &$arr = array(), $space = "", $level = 0, $children = "")
    {
        if (empty($children)) {
            $children = Sort::where('parent_id', 0)->all();
        }
        if ($children) {
            foreach ($children as $row) {
                if ($level == 0) {
                    $row['space'] = $space;
                } elseif ($level == 1) {
                    $row['space'] = $space = "　　　　|------>";
                } else {
                    $row['space'] = $space;
                }
                $arr[] = $row;
                $parent_id = $row['id'];
                $children = Sort::where('parent_id', $parent_id)->all();
                if ($children) {
                    $this->prepareMenu($parent_id, $arr, "　　　　|------>" . $space, $level + 1, $children);
                }
            }
        }
        return $arr;
    }

    /*
        * 自定义打印数组
        * */
    public function dump_self($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    /*
     * 获取类别查询类别
     * */
    public function getoption($sortname)
    {
        $id = Sort::where('sortname',$sortname)->column('id')[0];
        $parent_id = $id;
        return Sort::where('parent_id',$parent_id)->all();
    }
    /*
     * 文件上传
     *长传文件名称  filename
     * */
    public function upload($filename) {
        $files = request()->file($filename);
        //判断是否有文件上传
        if (!$files) {
            return false;
            die();
        }
        $data = [];
        foreach ($files as $file){
            $info = $file->move( './uploads');
            if($info){
                $data[]=$info->getSaveName();
            }else{
                echo $file->getError();
            }
        }
        return $data;
    }
}


























