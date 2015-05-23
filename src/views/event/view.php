<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->registerJsFile('https://apis.google.com/js/client.js?onload=checkAuth');
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?callback=initialize');
$this->registerJsFile('/js/gCalendar.js');

$this->title = $model->name;
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

<div id="map" style="width: 300px; height: 300px;">
</div>

<button type="button" onclick="gCalendarExport()">Export Event</button>

<script type="text/javascript">
    function initialize(){
        var centerLatLng = new google.maps.LatLng(<?= $model->lat ?>, <?= $model->lng ?>);
        var mapProp = {
            center: centerLatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = window.map = new google.maps.Map(document.getElementById("map"), mapProp);
        marker = new google.maps.Marker({
            position: centerLatLng,
            map: map,
            draggable: false,
        });
    };
</script>