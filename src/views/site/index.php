<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $model \app\models\EventSearch */
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <span class="lead"><?= Yii::t('app', 'Welcome')/*Ласкаво просимо*/ ?></span>
        <br/>
        <?= $this->render('_search', ['model' => $model]) ?>
    </div>

    <div class="body-content">

        <div>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_event',
                'layout' => '<div class="row">{items}</div>',
                'emptyText' => '',
            ]) ?>
        </div>

    </div>
</div>
