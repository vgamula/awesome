<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1 id="type"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget(['dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [['class' => 'yii\grid\SerialColumn'],

            'name',
            'placeName',
            'start',
            'end',

            ['class' => 'yii\grid\ActionColumn'],],]); ?>

</div>
