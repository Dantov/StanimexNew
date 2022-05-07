<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Html;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="металлорежущие станки и оборудование">
    <meta name="author" content="Станимэкс">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link rel="icon" href="/web/img/favicon.png">
    <title>Stanimex - металлорежущие станки и оборудование</title>

    <!-- Google font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

    <div class="container-fluid p0">
        <nav class="navbar navbar-fixed-top cpnav">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= Url::to(['/']); ?>">
                        <!-- <img src="css/img/logo_gear.png" class="brand-gear">
                        <div class="stanimex">
                            <span>Stanimex</span>
                            <p>станки и оборудование</p>
                        </div>-->
                        <div class="stan-logo" title="Stanimex - Металлорежущие станки и оборудование"></div>
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onClick="$('.slidr').animatescroll({scrollSpeed:2000, padding:80});" href="<?= Url::to(['/']) ?>">Домой</a></li>
                        <li><a onClick="$('.about').animatescroll({scrollSpeed:2000, padding:80});" href="<?= !$this->params['isHome'] ? Url::to(['/home#about']) : '#about' ?>">О Нас</a></li>
                        <li><?= \yii\helpers\Html::a('Прайс-Лист', Url::to(['/price-list']) ) ?></li>
                        <li><a onClick="$('.hotsell').animatescroll({scrollSpeed:2000, padding:80});" class="hot" href="<?= !$this->params['isHome'] ? Url::to(['/home#hotsell']) : '#hotsell' ?>"><strong>Срочно!</strong></a></li>
                        <li><a onClick="$('.webuy').animatescroll({scrollSpeed:2000, padding:80});" href="<?= !$this->params['isHome'] ? Url::to(['/home#webuy']) : '#webuy' ?>">Мы Покупаем</a></li>
                        <li><?= \yii\helpers\Html::a('Отгрузки', Url::to(['/shipment']) ) ?></li>
                        <li><a onClick="$('.contact').animatescroll({scrollSpeed:2000, padding:80});" href="<?= !$this->params['isHome'] ? Url::to(['/home#contact']) : '#contact' ?>">E-mail</a></li>
                    </ul>
                    <ul class="loginBtn nav">
                        <li>
                            <a href="<?= Url::to(['/stan-admin']) ?>" style="font-size: x-large;">
                                <span class="glyphicon glyphicon-log-in"></span>
                            </a>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--container-->
        </nav>
        <div class="clearfix"></div>

        <div class="content <?= $this->params['isHome'] ? "" : "mt-60"?>">
            <?= $content ?>
        </div>

        <div class="ftbg">
            <div class="container">
                <div class="row">
                    <span style="position:relative; top: 0; left: 0; display: block;">
                        <img src="/web/img/S.png" class="footer-logo">
                    </span>
                    <div class="col-md-4 copy col-sm-6">
                        <p>
                            <?php foreach ($this->params['contacts']??[] as $contact): ?>
                                <?= $contact['description_ru'] ?><br/>
                            <?php endforeach; ?>
                        </p>
                    </div>
                    <div class="col-md-6 ftnav col-md-offset-2 col-sm-6">
                        <ul>
                            <li><a onClick="$('.slidr').animatescroll({scrollSpeed:2000, padding:80});" href="<?= Url::to(['/']) ?>">Домой</a></li>
                            <li><a onClick="$('.about').animatescroll({scrollSpeed:2000, padding:80});" href="<?= !$this->params['isHome'] ? Url::to(['/home#about']) : '#about' ?>">О Нас</a></li>
                            <li><?= \yii\helpers\Html::a('Прайс-Лист', Url::to(['/price-list']) ) ?></li>
                            <li><a onClick="$('.hotsell').animatescroll({scrollSpeed:2000, padding:80});" class="hot" href="<?= !$this->params['isHome'] ? Url::to(['/home#hotsell']) : '#hotsell' ?>"><strong>Срочно!</strong></a></li>
                            <li><a onClick="$('.webuy').animatescroll({scrollSpeed:2000, padding:80});" href="<?= !$this->params['isHome'] ? Url::to(['/home#webuy']) : '#webuy' ?>">Мы Покупаем</a></li>
                            <li><?= \yii\helpers\Html::a('Отгрузки', Url::to(['/shipment']) ) ?></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 copy padd-bott-copy">
                        <span><center>&copy; Stanimex <?= date('Y') ?>. Все права защищены</center></span>
                    </div>
                </div>
            </div>
        </div><!--footerbg-->

    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
