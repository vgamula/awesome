<?php

use yii\widgets\ListView;

/** @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Catalog');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-products">

    <div>
        <?= ListView::widget([
            'itemView' => '_index-product',
            'dataProvider' => $dataProvider,
            'layout' => "{items}",
            'options' => ['class' => 'list-view row'],
        ]) ?>
    </div>
</div>