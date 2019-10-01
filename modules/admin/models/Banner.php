<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 20.09.2019
 * Time: 0:13
 */
namespace app\modules\admin\models;

use yii\helpers\FileHelper;

class Banner extends \yii\base\Model
{
    public static function searchImages(){
        $path = '@imgUploads/banner/small/';
        $images = FileHelper::findFiles(\Yii::getAlias($path));

        //получаем имена файлов
        $images=array_map(function($path){return basename($path);},$images);

        return $images;
    }

    public static function findOne($images){
        $image = '../img/banner/' . $images;
        return $image;
    }
}