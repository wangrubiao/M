<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class LineGroup extends Model {
    //设置模型表
    //protected $name = 'admin';


    /**
     * 返回所有分类列表
     * @access public
     * @param  int       $uid|null     用户ID|null
     * @return array
     */
    public function calssList()
    {
        $result = Db::name('line_group')->select();
        return $result;
    }

}