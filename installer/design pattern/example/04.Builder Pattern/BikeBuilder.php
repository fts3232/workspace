<?php

namespace Builder;

class BikeBuilder implements Builder
{
    private $bike;

    public function __construct()
    {
        $this->bike = new Bike();
    }

    public function buildTyres()
    {
        $this->bike->setTyre("橙色轮胎");
    }

    // 组装车架
    public function buildFrame()
    {
        $this->bike->setFrame("橙色轮胎");
    }

    // 组装GPS定位装置
    public function buildGPS()
    {
        $this->bike->setGPS("橙色轮胎");
    }

    // 获取自行车
    public function getBike()
    {
        return $this->bike;
    }
}
