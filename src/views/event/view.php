<?php
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $googleId string */

$this->registerJsFile('https://apis.google.com/js/client.js?onload=checkAuth');
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?callback=initialize');
$this->registerJsFile('/js/gCalendar.js', ['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;
$ownerLink = Html::a($model->owner->username, ['/user/view', 'id' => $model->userId]);

$user = [];
foreach ($model->users as $user) {
    $users[] = Html::a($user->username, ['/user/view', 'id' => $user->id]);
}
if (empty($users)) {
    $users = Yii::t('app', 'Empty');
} else {
    $users = implode(', </br>', $users);
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1 id="type"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <p>
        <?php if ($model->userIsOwner()): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
        <?= Html::button(FA::icon('marker') . Yii::t('app', 'Export event to Google Calendar'), [
            'class' => 'btn btn-success',
            'onclick' => "app.gCalendarExport('{$googleId}', {$model->getJsonData()})",
        ]) ?>
        <?php if (!$model->userIsSubscriber()): ?>
            <?= Html::a(Yii::t('app', 'Subscribe'), ['subscribe', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php else: ?>
            <?= Html::a(Yii::t('app', 'Unsubscribe'), ['unsubscribe', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        <?php endif ?>
    </p>

    <div class="row">
        <div class="col-md-3"> <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => Yii::t('app', 'Owner'),
                        'value' => $ownerLink,
                        'format' => 'raw',
                    ],
                    'placeName',
                    'start',
                    'end',
                    [
                        'label' => Yii::t('app', 'Users'),
                        'format' => 'raw',
                        'value' => $users,
                    ],
                ],
            ]) ?> </div>
        <div class="col-md-9"> <?= $model->description ?></div>
    </div>

</div>

<div id="map"></div>

<?php if (!empty($model->photos)): ?>
    <span><?= Yii::t('app', 'Photos') ?></span>
    <div class="row">
        <?php foreach ($model->photos as $photo): ?>
            <div class="col-md-3">
                <?= Yii::$app->formatter->asFancyImage($photo) ?>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'awesomeuawc';
    var disqus_identifier = 'event-<?= $model->id ?>';
    var disqus_url = document.location.href;
    var disqus_title = 'title-<?= $model->id ?>';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>


<script type="text/javascript">
    function initialize() {
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
            draggable: false
        });
    }
    ;
</script>
