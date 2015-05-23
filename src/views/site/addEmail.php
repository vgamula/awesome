<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Add email');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
        'action' => ['set-email'],
        'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>