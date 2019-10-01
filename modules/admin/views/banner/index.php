<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 20.09.2019
 * Time: 21:54
 */

echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($images) {
        return \app\widgets\PicturePreview::widget([
            'images' => $images
        ]);
    },
    'summary' => false,
    'options' => [
        'class' => 'preview-container'
    ]
])
?>
    <p>Загрузить баннер</p>
<?
$form = \yii\widgets\ActiveForm::begin();
echo $form->field($modelFileUpload, 'file')->fileInput();
echo \yii\helpers\Html::submitButton('Send', ['class' => 'btn btn-success']);
$form::end();