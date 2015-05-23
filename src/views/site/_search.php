<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\EventSearch */
?>
<div class="search-form">
    <span><?= Yii::t('app', 'Find the event you are interested in:') ?></span>
    <?php $form = ActiveForm::begin([
        'action' => ['search'],
        'method' => 'get',
    ]); ?>
    <?= Html::activeTextInput($model, 'title', ['class' => 'padding-10']) ?>
    <br/>
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
