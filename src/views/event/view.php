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

<div id="map" style="width: 300px; height: 300px;">
</div>

<button type="button" onclick="gCalendarExport()">Export Event</button>

<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'awesomeuawc';
    var disqus_identifier = 'event-<?= $model->id ?>';
    var disqus_url = document.location.href;
    var disqus_title = 'title-<?= $model->id ?>';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>




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
