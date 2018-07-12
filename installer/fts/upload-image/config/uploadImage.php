<?php
return [
    //允许上传的文件类型
    'allowTypes' => array('image/png', 'image/jpeg', 'image/pjpeg', 'image/jpeg', 'image/gif'),
    //允许上传的文件大小
    'maxSize' => 1024 * 1024 * 1,
    //上传目录
    'uploadDir' => storage_path('upload'),
    //是否开启水印
    'watermark' => true,
    //水印图片路径
    'watermarkImage' => public_path('images/watermark.png'),
    //水印位置
    'watermarkPosition' => 'bottom-right',
    //水印x轴偏移数
    'watermarkPositionX' => 15,
    //水印Y轴偏移数
    'watermarkPositionY' => 10,
];
