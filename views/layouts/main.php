<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        'brandLabel' => 'Matcha',
        'brandUrl' => Yii::$app->homeUrl . 'site/index',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Chat', 'url' => ['/chat/index']],
            ['label' => 'Visits' . Html::tag('span', '9', ['class' => 'badge']), 'url' => ['/site/visits']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'SignUp', 'url' => ['/users/signup'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Settings', 'url' => ['/users/settings'], 'visible' => !Yii::$app->user->isGuest],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/users/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->user_name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Matcha by Vladimir (like Vladimir Klitchko) Sosevich (vsosevic, 42school) <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<script type="text/javascript">
    var pathArray = location.href.split( '/' );
    var protocol = pathArray[0]; //http:
    var host = pathArray[2]; //localhost
    var website = pathArray[3] + '/' + pathArray[4]; //matcha/web
    var coreUrl = protocol + '//' + host + '/' + website; //http://localhost/matcha/web

    var statusOnline = new EventSource(coreUrl + "/users/set-online-status");
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
