<?php

namespace Builder;

interface Builder
{
    // 组装轮胎
    public function buildTyres();

    // 组装车架
    public function buildFrame();

    // 组装GPS定位装置
    public function buildGPS();

    // 获取自行车
    public function getBike();
}
