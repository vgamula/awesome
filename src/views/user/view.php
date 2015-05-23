<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$events = [];
foreach ($model->events as $event) {
    $events[] = Html::a($event->getTitle(), ['/event/view', 'id' => $event->id]);
}
if (empty($events)) {
    $events = Yii::t('app', 'Empty');
} else {
    $events = implode(', ', $events);
}
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'avatar:image',
            'createdAt:datetime',
            [
                'label' => Yii::t('app', 'Events'),
                'value' => $events,
                'format' => 'raw',
            ]
        ],
    ]) ?>

</div>
