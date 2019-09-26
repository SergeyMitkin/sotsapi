<?php
use yii\helpers\Url;
/** @var $model \app\models\tables\Picture*/

?>
<?
//echo 'pictures';
?>
<img src="../img/banner/small/АО 7.jpg">
<div class="task-container">
        <a href="<?//=Url::to(['gallery/one', 'id' => $model->id]);?>"
        <img src="<?//=Yii::getAlias('@uploads') . '/small/' . $model->picture_source?>"
             alt="<?//=$model->picture_alt?>" title="<?//=$model->picture_title?>">
<?//= '<img src = ../img/small/' . $model->picture_source . '>'?>
        </a>
    <p class="caption"><?//=$model->picture_title?></p>
</div>





