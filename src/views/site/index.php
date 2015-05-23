<?php
use \yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <span class="lead">Ласкаво просимо до магазину м’яких іграшок</span>

        <h1>Plush!</h1>
    </div>

    <div class="body-content">

        <div>
            <?= ListView::widget([
                'itemView' => '_index-product',
                'dataProvider' => $dataProvider,
                'layout' => "{items}",
                'options' => ['class' => 'list-view row'],
            ]) ?>
        </div>

    </div>
</div>
