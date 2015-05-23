<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var $this \yii\web\View */
/** @var $model \app\models\catalog\Vendor */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => ['/site/products']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-vendor">

    <div class="row">
        <div class="col-md-3">
            <div class="thumbnail">
                <?= Html::img($model->picture); ?>
            </div>
        </div>
        <div class="col-md-9">
            <h1><?= $model->title ?></h1>

            <div class="description"><?= Yii::$app->formatter->asReadMore($model->description) ?></div>
        </div>
    </div>
    <div class="products">
        <div class="title">
            <span><?= Yii::t('app', 'Products of vendor {vendor}:', ['vendor' => $model->title]) ?></span>
        </div>
        <?= ListView::widget([
            'itemView' => '_index-product',
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n<div class='clearfix'></div>\n{summary}\n{pager}",
            'options' => ['class' => 'list-view row'],
        ]) ?>
    </div>
</div>