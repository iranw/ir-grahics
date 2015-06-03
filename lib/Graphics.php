<?php
namespace Ir\Graphics;

abstract class Graphics
{

    const THUMB_PRXFIX = "s_";
    const CROP_PRIFIX  = "c_";
    const GZIP_PRIFIX  = "g_";
    const WATER_PRIFIX = "w_";

    public $fontsize  = 16;
    public $fontcolor = '#eee';
    public $fontstyle = null;
    public $sourceimg;

    protected function __construct($sourceimg = '')
    {
        $this->sourceimg = $sourceimg;
    }

    public function setSourceImg($sourceimg)
    {
        $this->sourceimg = $sourceimg;
    }

    public function getSourceImg()
    {
        return $this->sourceimg;
    }

    public function setFontSize($fontsize)
    {
        $this->fontsize = $fontsize;
    }

    public function getFontSize()
    {
        return $this->fontsize;
    }

    public function setFontColor($fontcolor)
    {
        $this->fontcolor = $fontcolor;
    }

    public function getFontColor()
    {
        return $this->fontcolor;
    }

    public function setFontStyle($fontstyle)
    {
        $this->fontstyle = $fontstyle;
    }

    public function getFontStyle()
    {
        return $this->fontstyle;
    }

    /**
     * 生成缩略图/截图图片的名字
     * @param  [type] $sourceimg 原图片地址
     * @param  [type] $mode      目标图片模式 0:加前缀 1:随机名 2:源名字
     * @return [type]            [description]
     */
    protected function getThumbName($sourceimg, $prefix = "s_", $mode = 0)
    {
        $thumbname = '';
        $fileinfo  = pathinfo($this->sourceimg);
        if ($mode == 0) {
            $thumbname = $fileinfo['dirname'] . '/' . $prefix . $fileinfo['basename'];
        } else if ($mode == 1) {
            $thumbname = $fileinfo['dirname'] . '/' . $prefix . time() . mt_rand(1, 10000) . '.' . $fileinfo['extension'];
        } else if ($mode == 2) {
            $thumbname = $sourceimg;
        }
        return $thumbname;
    }

}
