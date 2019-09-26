<?php
use yii\helpers\Url;
/** @var $model \app\models\tables\Picture*/

?>
<div class="task-container">
        <a href=<?=Url::to(['banner/one', 'images' => $images])?>" alt="<?=$images?>" >
            <img src="../img/banner/small/<?=$images?>">
        </a>
    <?= \yii\helpers\Html::a('Delete', ['delete', 'images' => $images], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</div>





