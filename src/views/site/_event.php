<?php
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Event */
?>
<div class="event-item col-md-6 col-sm-12 table-bordered padding-10">
    <h3><?= $model->getTitle() ?></h3>

    <p><?= Yii::t('app', 'Start:') ?> <?= Yii::$app->formatter->asDatetime($model->start) ?></p>

    <p><?= Yii::t('app', 'End:') ?> <?= Yii::$app->formatter->asDatetime($model->end) ?></p>
    <?= Html::a(FA::icon('eye') . ' ' . Yii::t('app', 'View'), ['/event/view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>
