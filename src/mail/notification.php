<?php
/** @var $this \yii\web\View */
/** @var $model \app\models\News */
?>
<div>
    <h1><?= $event->title ?></h1>
    <p>
        Don't forget about upcoming event: <?= $event->title ?>.
    </p>
    <p>Start: <?= Yii::$app->formatter->asDatetime($event->start) ?></p>
    <p>End: <?= Yii::$app->formatter->asDatetime($event->start) ?></p>
    <p>
        You can access event by <?= \yii\helpers\Html::a(Yii::t('app', 'this link.'), ['/event/view','id'=>$model->id])
        ?>
    </p>
</div>