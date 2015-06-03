<?php
namespace Ir\Graphics;

interface GraphicsInterface
{

    /**
     * 设置图片
     * @param [type] $imgDir [description]
     */
    // public function setImages($imgDir);

    /**
     * 生成缩略图
     * @param  [type] $code   [description]
     * @param  [type] $width  [description]
     * @param  [type] $height [description]
     * @param  [type] $mode   [description]
     * @return [type]         [description]
     */
    public function getCaptcha($code, $width, $height, $mode);

    /**
     * 压缩图片
     * @param  integer $thumbname 生成后的压缩图片
     * @return [type]             [description]
     */
    public function compress($thumbname = 0);

    /**
     * 生成缩略图
     * @param  [int] $width       缩略图宽度
     * @param  [int] $height      缩略图高度
     * @param  [type] $thumb_name 生成缩略图名字
     * @param  [type] $mode       生成缩略图模型 true:等比例 false:非等比例
     * @return [string]           返回生成缩略图的名字
     */
    public function getThumbnail($width, $height, $thumbname = 0, $mode = true);

    /**
     * 添加字符串水印
     * @param  [type] $string     [description]
     * @param  string $thumb_name [description]
     * @param  [type] $mode       [description]
     * @return [type]             [description]
     */
    public function getStrWater($text, $thumbname = 2, $mode = 0);

    /**
     * 添加图片水印
     * @param  [type] $img        [description]
     * @param  string $thumb_name [description]
     * @param  [type] $mode       [description]
     * @return [type]             [description]
     */
    public function getImgWater($logoimg, $thumbname = 2, $mode = 0);

    /**
     * 截取图片
     * @param  [type] $x 截取图片x坐标
     * @param  [type] $y 截图图片y坐标
     * @param  [type] $w 截取图片宽度
     * @param  [type] $h 截取图片高度
     * @return [type]    [description]
     */
    public function getCropImage($x, $y, $w, $h);

}
