<?php
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use yii\jui\Spinner;

/** @var $this \yii\web\View */
/** @var $model \app\models\catalog\Product */
?>

<div class="index-product col-lg-3">

    <h2><?= Html::a($model->title, ['/site/product', 'id' => $model->id]) ?></h2>

    <p>
        <?= Html::a(Html::img($model->picture), $model->picture, ['rel' => 'fancybox', 'class' => 'thumbnail']); ?>
    </p>

    <div class="order-form">
        <p>
            <?= Spinner::widget(['name' => 'amount', 'clientOptions' => ['min' => 1, 'max'=>$model->amount], 'options' => ['readonly' => true], 'value' => 1]); ?>
            <?= Yii::t('app', 'Price: ') . Yii::$app->formatter->asMoney($model->price) ?>
        </p>

        <p>
            <?= Html::a(Yii::t('app', 'Buy') . ' ' . FA::icon('shopping-cart'), ['/cart/add', 'id' => $model->id], ['class' => 'btn btn-success btn-buy']) ?>
            <?= Html::a(Yii::t('app', 'View') . ' ' . FA::icon('arrow-circle-right'), ['/site/product', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

</div>