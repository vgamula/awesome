<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::t('app', 'This site for offline events') ?>
    </p>
</div>
