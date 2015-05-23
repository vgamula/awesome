<?php

use app\models\Event;
use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?callback=initialize');
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start')->widget(DateTimePicker::classname()) ?>

    <?= $form->field($model, 'end')->widget(DateTimePicker::classname()) ?>

    <?= $form->field($model, 'placeName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder',], [
            'preset' => 'full',
            'height' => 200,
        ]),
    ]) ?>


    <?= $form->field($model, 'lat')->textInput(['maxlength' => true, 'id'=>'lat']) ?>
    <?= $form->field($model, 'lng')->textInput(['maxlength' => true, 'id'=>'lng']) ?>

    <div id="map" style="width: 500px; height: 380px;">
    </div>

    <?= $form->field($model, 'visible')->dropDownList(Event::getVisibilities()) ?>

    <?= $form->field($model, 'status')->dropDownList(Event::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script type="text/javascript">
        function setPosition(marker, pos, map) {
            marker.setMap(null);
            marker.position = pos;
            marker.setMap(map);
            document.getElementById("lat").value = pos.lat();
            document.getElementById("lng").value = pos.lng();
        }
        function initialize(){
            var marker = null;
            <?php if ($model->lat && $model->lng): ?>
                var centerLatLng = new google.maps.LatLng('<?= $model->lat ?>', '<?= $model->lng ?>');
            <?php else: ?>
                var centerLatLng = new google.maps.LatLng(30.545581470360048, 50.43576711617286);
            <?php endif ?>
            var mapProp = {
                center: centerLatLng,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = window.map = new google.maps.Map(document.getElementById("map"), mapProp);
            marker = new google.maps.Marker({
                position: centerLatLng,
                map: map,
                draggable:true,
            });
            google.maps.event.addListener(marker, 'mouseup', function(event) {
                setPosition(marker, event.latLng, map);
            });
            google.maps.event.addListener(map, "click", function(event)
            {
                setPosition(marker, event.latLng, map);
            });
            <?php if (!$model->lat || !$model->lng): ?>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    coords = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
                    setPosition(marker, coords, map);
                    map.setCenter(coords);
                });
            }
            <?php endif ?>
        };
    </script>

</div>
