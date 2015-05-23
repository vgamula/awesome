<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <span class="lead"><?= Yii::t('app', 'Welcome')/*Ласкаво просимо*/ ?></span>
    </div>

    <div class="body-content">

        <div>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_event',
            ]) ?>
        </div>

    </div>
</div>
