<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Event',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="event-update">

  <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1 id="type"><?= Html::encode($this->title) ?></h1>
        </div>
      </div>
  </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
