<?php
return [
    'allowTypes' => array('image/png', 'image/jpeg', 'image/pjpeg', 'image/jpeg', 'image/gif'),
    'maxSize' => 1024 * 1024 * 1,
    'uploadDir' => storage_path('upload'),
    'watermark' => true,
    'watermarkImage' => public_path('images/watermark.png'),
    'watermarkPosition' => 'bottom-right',
    'watermarkPositionX' => 15,
    'watermarkPositionY' => 10,
];
