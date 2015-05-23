<?php
use yii\helpers\Html;
use yii\jui\Spinner;
use rmrevin\yii\fontawesome\FA;

/** @var $this \yii\web\View */
/** @var $model \app\models\catalog\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => ['/site/products']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-product">
    <div class="row">
        <div class="col-md-3">
            <?= Html::a(Html::img($model->picture, ['data-zoom-image' => $model->picture]), $model->picture, ['rel' => 'fancybox', 'class' => 'thumbnail']); ?>
        </div>
        <div class="col-md-9">
            <h1><?= $model->title ?></h1>

            <div class="order-form">
                <p class="price"><?= Yii::t('app', 'Price: ') . Yii::$app->formatter->asMoney($model->price) ?></p>
                <?= Spinner::widget(['name' => 'amount', 'clientOptions' => ['min' => 1, 'max'=>$model->amount], 'options' => ['readonly' => true], 'value' => 1]); ?>
                <?= Yii::t('app', 'pcs.') ?>
                <?= Html::a(Yii::t('app', 'Buy') . ' ' . FA::icon('shopping-cart'), ['/cart/add', 'id' => $model->id], ['class' => 'btn btn-success btn-buy']) ?>
            </div>

            <p class="vendor"><?= Yii::t('app', 'Vendor: ') . Html::a($model->vendor->title, ['/site/vendor', 'id' => $model->vendorId]) ?></p>

            <div class="description"><?= Yii::$app->formatter->asReadMore($model->description) ?></div>

        </div>
    </div>
</div>