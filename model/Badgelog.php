<?php

namespace addons\badge\model;

use think\Model;


class Badgelog extends Model
{

    // 表名
    protected $name = 'badge_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    


    public function user()
    {
        return $this->belongsTo('\app\common\model\User', "user_id", "id");
    }




}
