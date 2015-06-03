<?php
namespace Ir\Graphics;

class Im extends Graphics implements GraphicsInterface
{

    public function __construct($sourceimg = '')
    {
        if (!extension_loaded('imagick')) {
            die('imagick extension is not loaded');
        }
        parent::__construct($sourceimg);
    }

    /**
     * 生成验证码
     * @param  string     $code    验证码字符串
     * @param  integer  $width  宽度
     * @param  integer  $height 高度
     * @param  integer $mode   验证码类型  0:一般 1:复杂
     * @return string          图像字符串
     */
    public function getCaptcha($code, $width, $height, $mode = 0)
    {

        $draw = new \ImagickDraw();
        $draw->setFillColor($this->fontcolor);
        if (!is_null($this->fontstyle)) {
            $draw->setFont($this->fontstyle);
        }
        $draw->setFontSize($this->fontsize);
        $draw->annotation(5, 15, $code);

        // $draw->line(5,5,0,0);
        // $draw->point(10,10);

        $im = new \Imagick();
        $im->newImage($width, $height, "gray", 'png');
        $im->drawImage($draw);

        header('Content-type: image/png');
        echo $im;
        $im->clear();
        $im->destroy();
    }

    /**
     * 压缩图片
     * @param  [type] $sourceImage [description]
     * @param  [type] $targetImage [description]
     * @return [type]              [description]
     */
    public function compress($thumbname = 2)
    {
        if (!is_string($thumbname)) {
            $thumbname = parent::getThumbName($this->sourceimg, parent::GZIP_PRIFIX, $thumbname);
        }
        $im = new \Imagick($this->sourceimg);
        $im->enhanceImage();
        $im->writeImage($thumbname);
        $im->clear();
        $im->destroy();
        return $thumbname;
    }

    /**
     * 生成缩略图
     * @param  [int]  $width      缩略图宽度
     * @param  [int]  $height     缩略图高度
     * @param  string  $thumb_name 生成缩略图名称 如果是图片地址 生成图片 如果$thumb_name 0:前缀 1:随机 2:自身
     * @param  integer $mode       是否等比例生成缩略图
     * @return [string]  $thumb_name    返回缩略图的名称
     */
    public function getThumbnail($width, $height, $thumbname = 0, $mode = true)
    {
        if (!is_string($thumbname)) {
            $thumbname = parent::getThumbName($this->sourceimg, parent::THUMB_PRXFIX, $thumbname);
        }
        $im = new \Imagick($this->sourceimg);
        $im->thumbnailImage($width, $height, $mode);
        $im->writeImage($thumbname);
        $im->clear();
        $im->destroy();
        return $thumbname;
    }

    /**
     * 截取图片
     * @param  [int]  $w          截取的宽度
     * @param  [int]  $h          截取的高度
     * @param  integer $thumb_name 生成的截图名称
     * @param  integer $mode       截图模式0:正中间 1:坐上 2:右上 3:右下 4:左下
     * @return [string]              返回截图名称
     */
    public function getCropImage($w, $h, $thumbname = 0, $mode = 0)
    {
        if (!is_string($thumbname)) {
            $thumbname = parent::getThumbName($this->sourceimg, parent::CROP_PRIFIX, $thumbname);
        }
        $im = new \Imagick($this->sourceimg);
        if ($mode == 0) {
            $x = ($im->getimagewidth() - $w) / 2;
            $y = ($im->getimageheight() - $h) / 2;
        } else if ($mode == 1) {
            $x = 0;
            $y = 0;
        } else if ($mode == 2) {
            $x = $im->getimagewidth() - $w;
            $y = 0;
        } else if ($mode == 3) {
            $x = $im->getimagewidth() - $w;
            $y = $im->getimageheight() - $h;
        } else if ($mode == 4) {
            $x = 0;
            $y = $im->getimageheight() - $h;
        }

        $im->cropImage($w, $h, $x, $y);
        $im->enhanceImage();
        $im->writeImage($thumbname);
        $im->clear();
        $im->destroy();
        return $thumbname;
    }

    /**
     * 添加字符串水印
     * @param  [type] $string     [description]
     * @param  string $thumb_name [description]
     * @param  [type] $mode       文字存放位置 0:正中间 1:坐上 2:右上 3:右下 4:左下
     * @return [type]             [description]
     */
    public function getStrWater($text, $thumbname = 2, $mode = 0)
    {
        if (!is_string($thumbname)) {
            $thumbname = parent::getThumbName($this->sourceimg, parent::WATER_PRIFIX, $thumbname);
        }

        $draw = new \ImagickDraw();
        if ($mode == 0) {
            $draw->setGravity(\Imagick::GRAVITY_CENTER); //中间
        } else if ($mode == 1) {
            $draw->setGravity(\Imagick::GRAVITY_NORTHWEST); //左上
        } else if ($mode == 2) {
            $draw->setGravity(\Imagick::GRAVITY_NORTHEAST); //右上
        } else if ($mode == 3) {
            $draw->setGravity(\Imagick::GRAVITY_SOUTHEAST); //右下
        } else if ($mode == 4) {
            $draw->setGravity(\Imagick::GRAVITY_SOUTHWEST); //左下
        }

        $draw->setFillColor($this->fontcolor);
        if (!is_null($this->fontstyle)) {
            $draw->setFont($this->fontstyle);
        }
        $draw->setFontSize($this->fontsize);
        $im = new \Imagick($this->sourceimg);
        $im->annotateimage($draw, 5, 5, 0, $text);
        $im->enhanceImage();
        $im->writeImage($thumbname);
        $im->clear();
        $im->destroy();
        return $thumbname;
    }

    /**
     * 添加图片水印
     * @param  string $logoimg      水印图片地址dir
     * @param  string $thumbname    生成的水印图片名字
     * @param  [type] $mode         水印存放位置 0:正中间 1:坐上 2:右上 3:右下 4:左下
     * @return [string] $thumbname  返回加了水印后的图片地址
     */
    public function getImgWater($logoimg, $thumbname = 2, $mode = 0)
    {
        if (!is_string($thumbname)) {
            $thumbname = parent::getThumbName($this->sourceimg, parent::WATER_PRIFIX, $thumbname);
        }
        $waterImg = new \Imagick($logoimg);
        $im       = new \Imagick($this->sourceimg);

        if ($mode == 0) {
            $x = ($im->getimagewidth() - $waterImg->getimagewidth()) / 2;
            $y = ($im->getimageheight() - $waterImg->getimageheight()) / 2;
        } else if ($mode == 1) {
            $x = 0;
            $y = 0;
        } else if ($mode == 2) {
            $x = $im->getimagewidth() - $waterImg->getimagewidth();
            $y = 0;
        } else if ($mode == 3) {
            $x = $im->getimagewidth() - $waterImg->getimagewidth();
            $y = $im->getimageheight() - $waterImg->getimageheight();
        } else if ($mode == 4) {
            $x = 0;
            $y = $im->getimageheight() - $waterImg->getimageheight();
        }

        $im->compositeimage($waterImg, \Imagick::COMPOSITE_DEFAULT, $x, $y);
        $im->enhanceimage();
        $im->writeImage($thumbname);
        $im->clear();
        $im->destroy();
        $waterImg->clear();
        $waterImg->destroy();
        return $thumbname;
    }
}
