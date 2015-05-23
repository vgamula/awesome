<?php

use app\components\Helper;
use app\models\Event;
use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?callback=initialize');
$this->registerJs(<<<JS
function setPosition(marker, pos, map) {
    marker.setMap(null);
    marker.position = pos;
    marker.setMap(map);
    document.getElementById("lat").value = pos.lat();
    document.getElementById("lng").value = pos.lng();
}
function initialize() {
    var marker = null;
    var centerLatLng = new google.maps.LatLng('$model->lat', '$model->lng');

    var mapProp = {
        center: centerLatLng,
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = window.map = new google.maps.Map(document.getElementById("map"), mapProp);
    marker = new google.maps.Marker({
        position: centerLatLng,
        map: map,
        draggable: true
    });
    google.maps.event.addListener(marker, 'mouseup', function (event) {
        setPosition(marker, event.latLng, map);
    });
    google.maps.event.addListener(map, "click", function (event) {
        setPosition(marker, event.latLng, map);
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            coords = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
            setPosition(marker, coords, map);
            map.setCenter(coords);
        });
    }
}
JS
    , View::POS_BEGIN);

$this->registerJs(<<<JS
var tplRow = jQuery('#tpl-table tr'),
    table = jQuery('#photos'),
    counter = 0,
    removeRowHandler = function (e) {
        e.preventDefault(e);
        jQuery(this).parents('tr').remove();
        return false;
    };
jQuery('#add-new-photo').click(function (e) {
    e.preventDefault(e);
    var newRow = tplRow.clone(),
        id = 'new_w' + counter;
    counter++;
    newRow.find('input').attr('id', id);
    newRow.find('button').attr('id', id + '_button');
    newRow.find('.btn-remove').click(removeRowHandler);
    mihaildev.elFinder.register(id, function (file, id) {
        $('#' + id).val(file.url).trigger('change');
        return true;
    });
    newRow.find('button').on('click', function () {
        mihaildev.elFinder.openManager({
            "url": "/elfinder/manager?filter=image&callback=" + id + "&lang=en",
            "width": "auto",
            "height": "auto",
            "id": "id"
        });
    });

    table.append(newRow);
    return false;
});
table.find('.btn-remove').click(removeRowHandler);
JS
)
?>

<div class="hide">
    <table id="tpl-table">
        <tr>
            <td>
                <?= InputFile::widget(Helper::getInputFileOptions(['name' => 'Event[photos][]'])) ?>
            </td>
            <td>
                <button class="btn btn-danger btn-remove"><?= Yii::t('yii', 'Delete') ?></button>
            </td>
        </tr>
    </table>
</div>
<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'placeName')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'start')->widget(DateTimePicker::classname()) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'end')->widget(DateTimePicker::classname()) ?>
                </div>
            </div>


            <?= $form->field($model, 'visible')->dropDownList(Event::getVisibilities()) ?>

            <?= $form->field($model, 'status')->dropDownList(Event::getStatuses()) ?>

        </div>
        <div class="col-md-6">

            <?= Html::activeHiddenInput($model, 'lat', ['id' => 'lat']) ?>
            <?= Html::activeHiddenInput($model, 'lng', ['id' => 'lng']) ?>
            <div id="map">
            </div>
        </div>
    </div>


    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder',], [
            'preset' => 'basic',
            'height' => 200,
        ]),
    ]) ?>

    <?= $form->beginField($model, 'photos[]') ?>

    <?= Html::activeLabel($model, 'photos[]') ?>

    <table class="table table-striped table-bordered" id="photos">
        <?php foreach ($model->photos as $photo): ?>
            <tr>
                <td>
                    <?= InputFile::widget(Helper::getInputFileOptions(['name' => 'Project[photos][]', 'value' => $photo])) ?>
                </td>
                <td>
                    <button class="btn btn-danger btn-remove"><?= Yii::t('yii', 'Delete') ?></button>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <div>
        <button class="btn btn-primary" id="add-new-photo"><?= Yii::t('admin', 'Add new photo') ?></button>
    </div>
    <?= $form->endField() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script type="text/javascript">
    </script>

</div>
