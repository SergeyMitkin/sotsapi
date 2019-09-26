<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10.11.2018
 * Time: 5:19
 */

namespace app\widgets;

//use app\models\tables\Picture;
use yii\base\Widget;

class PicturePreview extends Widget
{
    /** @var  Picture */

    public $images;

    public function run()
    {
        //return 'pictures';
        //if (is_a($this->model, Picture::class)) {
            return $this->render('picture_preview', ['images' => $this->images]);
        //}
        //throw new \Exception("Невозможно отобразить модель!");

    }
}