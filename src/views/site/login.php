<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1 class="text-center" id="type"><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>
    <div class="soc-btn text-center">
      <?php echo \nodge\eauth\Widget::widget(['action' => 'site/login', 'popup' => true]); ?>
    </div>
</div>
