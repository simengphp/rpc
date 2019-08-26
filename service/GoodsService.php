<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/8/23
     * Time: 16:13
     */
class GoodsService
{
    public function __construct()
    {

    }

    public function getGoodsList()
    {
        $arr = [
            ['title'=>'苹果', 'price'=>10],
            ['title'=>'香蕉', 'price'=>20]
        ];
        return json_encode($arr);
    }
}