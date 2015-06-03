<?php
namespace Ir\Graphics;

class Gm extends Graphics implements GraphicsInterface
{

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
        $draw = new GmagickDraw();
        $draw->setfillcolor($this->fontcolor);
        if (!is_null($this->fontstyle)) {
            $draw->setFont($this->fontstyle);
        }
        $draw->setfontsize($this->fontsize);
        $draw->annotate(5, 15, $code);

        if ($mode == 1) {
            $xArr = range(1, $width);
            shuffle($xArr);
            $yArr = range(1, $height);
            shuffle($yArr);

            for ($i = 0; $i < 20; $i++) {
                $draw->point($xArr[$i], $yArr[$i]);
            }

            shuffle($xArr);
            shuffle($yArr);
            for ($i = 0; $i < 5; $i++) {
                $draw->line($xArr[$i], $xArr[$i], $xArr[$i + 5], $yArr[$i + 5]);
            }
        }
        // $draw->line(5,5,0,0);
        // $draw->point(10,10);

        $gm = new Gmagick();
        $gm->newimage($width, $height, "gray", 'png');
        $gm->drawimage($draw);

        header('Content-type: image/png');
        echo $gm;
        $gm->clear();
        $gm->destroy();
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
        $gm = new Gmagick($this->sourceimg);
        $gm->enhanceimage();
        $gm->write($thumbname);
        $gm->clear();
        $gm->destroy();
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
        $gm = new Gmagick($this->sourceimg);
        $gm->thumbnailimage($width, $height, $mode);
        $gm->write($thumbname);
        $gm->clear();
        $gm->destroy();
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
        $gm = new Gmagick($this->sourceimg);
        if ($mode == 0) {
            $x = ($gm->getimagewidth() - $w) / 2;
            $y = ($gm->getimageheight() - $h) / 2;
        } else if ($mode == 1) {
            $x = 0;
            $y = 0;
        } else if ($mode == 2) {
            $x = $gm->getimagewidth() - $w;
            $y = 0;
        } else if ($mode == 3) {
            $x = $gm->getimagewidth() - $w;
            $y = $gm->getimageheight() - $h;
        } else if ($mode == 4) {
            $x = 0;
            $y = $gm->getimageheight() - $h;
        }

        $gm->cropimage($w, $h, $x, $y);
        $gm->enhanceimage();
        $gm->write($thumbname);
        $gm->clear();
        $gm->destroy();
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
            $thumbname = parent::getThumbName($this->sourceimg, parent::CROP_PRIFIX, $thumbname);
        }

        $draw = new GmagickDraw();
        if ($mode == 0) {
            $draw->setgravity(Gmagick::GRAVITY_CENTER); //中间
        } else if ($mode == 1) {
            $draw->setgravity(Gmagick::GRAVITY_NORTHWEST); //左上
        } else if ($mode == 2) {
            $draw->setgravity(Gmagick::GRAVITY_NORTHEAST); //右上
        } else if ($mode == 3) {
            $draw->setgravity(Gmagick::GRAVITY_SOUTHEAST); //右下
        } else if ($mode == 4) {
            $draw->setgravity(Gmagick::GRAVITY_SOUTHWEST); //左下
        }

        $draw->setfillcolor($this->fontcolor);
        if (!is_null($this->fontstyle)) {
            $draw->setFont($this->fontstyle);
        }
        $draw->setfontsize($this->fontsize);
        $gm = new Gmagick($this->sourceimg);
        $gm->annotateimage($draw, 10, 15, 1, $text);
        $gm->enhanceimage();
        $gm->write($thumbname);
        $gm->clear();
        $gm->destroy();
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
            $thumbname = parent::getThumbName($this->sourceimg, parent::CROP_PRIFIX, $thumbname);
        }
        $waterImg = new Gmagick($logoimg);
        $gm       = new Gmagick($this->sourceimg);

        if ($mode == 0) {
            $x = ($gm->getimagewidth() - $waterImg->getimagewidth()) / 2;
            $y = ($gm->getimageheight() - $waterImg->getimageheight()) / 2;
        } else if ($mode == 1) {
            $x = 0;
            $y = 0;
        } else if ($mode == 2) {
            $x = $gm->getimagewidth() - $waterImg->getimagewidth();
            $y = 0;
        } else if ($mode == 3) {
            $x = $gm->getimagewidth() - $waterImg->getimagewidth();
            $y = $gm->getimageheight() - $waterImg->getimageheight();
        } else if ($mode == 4) {
            $x = 0;
            $y = $gm->getimageheight() - $waterImg->getimageheight();
        }

        $gm->scaleimage($gm->getimagewidth(), $gm->getimageheight());
        $gm->compositeimage($waterImg, 2, $x, $y);
        $gm->enhanceimage();
        $gm->write($thumbname);
        $gm->clear();
        $gm->destroy();
        $waterImg->clear();
        $waterImg->destroy();
        return $thumbname;
    }

}
