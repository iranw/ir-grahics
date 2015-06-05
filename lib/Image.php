<?php
namespace Ir\Graphics;

class Image
{
    public static function getObj($obj, $sourceimg = '')
    {
        if ($obj == 'Im') {
            $obj = new \Ir\Graphics\Im($sourceimg);
        } else if ($obj == 'Gm') {
            $obj = new \Ir\Graphics\Gm($sourceimg);
        }
        return $obj;
    }
}
