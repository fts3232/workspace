<?php

return [
    //验证码字符集
    'characters' => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ',
    //默认配置
    'default' => [
        //字符串长度
        'length' => 5,
        //验证码宽度
        'width' => 120,
        //验证码高度
        'height' => 36,
        //图片质量
        'quality' => 90,
    ],
    //简单配置
    'flat' => [
        //字符串长度
        'length' => 6,
        //验证码宽度
        'width' => 160,
        //验证码高度
        'height' => 46,
        //图片质量
        'quality' => 90,
        //干扰线数量
        'lines' => 6,
        //背景颜色
        'bgColor' => '#ecf2f4',
        //字体颜色
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
    ],
    //迷你配置
    'mini' => [
        //字符串长度
        'length' => 3,
        //验证码宽度
        'width' => 60,
        //验证码高度
        'height' => 32,
    ],
    //颠倒配置
    'inverse' => [
        //字符串长度
        'length' => 5,
        //验证码宽度
        'width' => 120,
        //验证码高度
        'height' => 36,
        //图片质量
        'quality' => 90,
        //大小写敏感
        'sensitive' => true,
        //字体角度
        'angle' => 12,
        //图片锐化
        'sharpen' => 10,
        //图片模糊
        'blur' => 2,
        //字体颠倒
        'invert' => true,
    ]
];
