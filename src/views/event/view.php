<?php
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->registerJsFile('https://apis.google.com/js/client.js?onload=checkAuth');
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?callback=initialize');
$this->registerJsFile('/js/gCalendar.js', ['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;
$this->gKey = '723383549848-a2988ciq9d1jsie29v79seui32trsbko.apps.googleusercontent.com';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button(FA::icon('marker') . Yii::t('app', 'Export event to Google Calendar'), [
            'class' => 'btn btn-success',
            'onclick' => "app.gCalendarExport({$model->getJsonData()})",
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'lat',
            'lng',
            'placeName',
            'visible',
            'status',
        ],
    ]) ?>

</div>
