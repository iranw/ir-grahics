# 图片处理类

Gm/Im/Gd


###### 使用文档文档

```php
<?php
require './vendor/autoload.php';

//生成验证码
$code = 'r2h4';
$code = mt_rand(1000, 9999);
$obj  = new \Ir\Graphics\Gm();
$obj->setFontSize(20);
$obj->setFontColor('#eee');
// $obj->setFontStyle('../ttf/Amatic-Bold.ttf');
$obj->getCaptcha($code, 45, 20, 1);

//生成缩略图
$obj = new \Ir\Graphics\Gm('./a.png');
echo $obj->getThumbnail(100, 100, 0, true);

// 截取图片
$obj = new \Ir\Graphics\Gm('./a.png');
echo $obj->getCropImage(500, 500, 0, 4);

//添加文字水印
$obj = new \Ir\Graphics\Gm('./a.png');
echo $obj->getStrWater('www.gongchang.com', 0, 4);

//添加图片水印
$obj = new \Ir\Graphics\Gm('./a.png');
echo $obj->getImgWater('./water.png', 0, 4);

//压缩图片
$obj = new \Ir\Graphics\Gm('./a.png');
echo $obj->compress(); //enhanceimage
```