# 图片处理类

####图片类优势
> * 压缩图片可以减少30%的磁盘空间 节省开支
> * 用户加载速度快 体验增强
> * 比起GD，执行效率要高 坑大并发

Gm/Im/Gd


###### Gmagick操作图片使用文档

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

###### Imagick操作图片使用文档

```php
<?php
require './vendor/autoload.php';

//生成缩略图
$code = 'r2h4';
$code = mt_rand(1000, 9999);
$obj  = new \Ir\Graphics\Im();
$obj->setFontSize(20);
$obj->setFontColor('#eee');
// $obj->setFontStyle('../ttf/Amatic-Bold.ttf');
$obj->getCaptcha($code, 45, 20, 1);

//生成缩略图
$obj = new \Ir\Graphics\Im('./a.png');
echo $obj->getThumbnail(100, 100, 0, true);

// // 截取图片
$obj = new \Ir\Graphics\Im('./a.png');
echo $obj->getCropImage(500, 500, 0, 4);

// //添加文字水印
$obj = new \Ir\Graphics\Im('./a.png');
echo $obj->getStrWater('www.gongchang.com', 0, 4);

//添加图片水印
$obj = new \Ir\Graphics\Im('./a.png');
echo $obj->getImgWater('./water.png', 0, 4);

// //压缩图片
$obj = new \Ir\Graphics\Im('./a.png');
echo $obj->compress(); //enhanceimage
```