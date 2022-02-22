<?php
use dtw\HtmlHelper;
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?= $this->title ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?= HtmlHelper::URL('admin/views/css/bootstrap.min.css')?>" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link rel='stylesheet' href="<?= HtmlHelper::URL('admin/views/css/style.css?v='.time())?>" type='text/css' />
<link rel="stylesheet" href="<?= HtmlHelper::URL('admin/views/css/morris.css')?>" type="text/css"/>
<!-- Graph CSS -->
<link href="<?= HtmlHelper::URL('admin/views/css/font-awesome.css')?>" rel="stylesheet"> 
<script src="<?= HtmlHelper::URL('admin/views/js/jquery-2.1.4.min.js')?>"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?= HtmlHelper::URL('admin/views/css/icon-font.min.css')?>" type='text/css' />
<?php $this->head() ?>
</head>

<body style="background: #3b8fc5">
<?php $this->beginBody() ?>
    
<?= $content; ?>

<script src="<?= HtmlHelper::URL('admin/views/js/bootstrap.min.js') ?>"></script>
<?php $this->endBody() ?>
</body>
</html>

