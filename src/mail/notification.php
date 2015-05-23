<?php
/** @var $this \yii\web\View */
/** @var $event \app\models\Event */
?>
<div>
    <h1><?= $event->title ?></h1>
    <p>
        Don't forget about upcoming event: <?= $event->title ?>.
    </p>
    <p>Start: <?= Yii::$app->formatter->asDatetime($event->start) ?></p>
    <p>End: <?= Yii::$app->formatter->asDatetime($event->start) ?></p>
</div>