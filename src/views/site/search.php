<?php
use yii\widgets\ListView;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Event search');
?>
<div class="site-search">

    <div class="jumbotron">
        <?= $this->render('_search', ['model' => $model]) ?>
    </div>
    <div class="events-list">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_event',
            'layout' => '<div class="row">{items}</div>',
        ]) ?>
    </div>
</div>