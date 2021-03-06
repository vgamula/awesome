<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\catalog\Category;
use app\models\catalog\Vendor;
use rmrevin\yii\fontawesome\FA;
use app\widgets\Cart;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => FA::icon('star') . ' ' . Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => FA::icon('home') . ' ' . Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app', 'Profile'), 'visible' => !Yii::$app->user->isGuest, 'items' => [
                ['label' => Yii::t('app', 'My Events'), 'url' => ['/event']],
                ['label' => Yii::t('app', 'Users'), 'url' => ['/user']],
            ]],
            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            Yii::$app->user->isGuest ?
                ['label' => FA::icon('sign-in') . ' ' . Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                ['label' => FA::icon('sign-out') . ' ' . Yii::t('app', 'Logout ({user})', ['user' => Yii::$app->user->identity->username]),
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $text): ?>

            <div class="alert alert-<?= $type ?>">
                <?= $text ?>
            </div>

        <?php endforeach; ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; undefined Developers <?= date('Y') ?></p>
        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
