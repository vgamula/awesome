<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var $this \yii\web\View */
/** @var $model \app\models\catalog\Category */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$harChildren = !empty($model->categories);
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => ['/site/products']];
foreach ($model->getParents() as $category) {
    $this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/site/category', 'id' => $category->id]];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-category">

    <div class="row">
        <div class="col-md-3">
            <div class="thumbnail">
                <?= Html::img($model->picture); ?>
            </div>
        </div>
        <div class="col-md-<?= $harChildren ? 6 : 9 ?>">
            <h1><?= $model->title ?></h1>

            <div class="description"><?= Yii::$app->formatter->asReadMore($model->description) ?></div>
        </div>
        <?php if ($harChildren): ?>
            <div class="col-md-3">
                <div class="list-group">
                <span class="list-group-item active">
                    <?= Yii::t('app', 'Subcategories:') ?>
                </span>
                    <?php foreach ($model->categories as $category): ?>
                        <?= Html::a($category->title, ['/site/category', 'id' => $category->id], ['class' => 'list-group-item']) ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="products">
        <div class="title">
            <span><?= Yii::t('app', 'Products of category {category}:', ['category' => $model->title]) ?></span>
        </div>
        <?= ListView::widget([
            'itemView' => '_index-product',
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n<div class='clearfix'></div>\n{summary}\n{pager}",
            'options' => ['class' => 'list-view row'],
        ]) ?>
    </div>
</div>