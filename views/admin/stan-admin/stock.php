<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $machines array */
$session = yii::$app->session;
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a><i class="fa fa-angle-right"></i>Stock</li>
</ol>
<?php if ( $session->hasFlash('error_dellPosition') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('error_dellPosition');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('success_dellPosition') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('success_dellPosition');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('success_add') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('success_add');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('error_add') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('error_add');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('uplFiles_success') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('uplFiles_success');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('uplFiles_error') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('uplFiles_error');?> </strong>
    </div>
<?php endif; ?>
<?php if ( $session->hasFlash('imgFlag_upd') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong> <?=$session->getFlash('imgFlag_upd');?> </strong>
    </div>
<?php endif; ?>

<div class="row" style="margin: 1em 0 1em 0">
    <?php foreach ( $machines as $i => $machine ): ?>
    <div class="col-md-3 col-sm-6">
        <?php if ( $machine['status'] == 'hot' ): ?>
            <span class="label label-success hotLable_main">
                <span class="glyphicon glyphicon-fire"></span>Горячий
            </span>
        <?php endif;?>
        <?php if ( $machine['status'] == 'sold' ): ?>
            <span class="label label-danger hotLable_main">ПРОДАН</span>
        <?php endif;?>
        <div class="ratio">
            <div class="ratio-inner ratio-4-3">
                <div class="ratio-content">
                    <div class="text-primary">
                        <strong><?= $machine['short_name_ru'] ?></strong>
                    </div>
                    <img src="/web/Stockimages/<?=$machine['images'][0]['img_name']?>" class="img-responsive">
                </div>
            </div>
            <div class="text-muted margtop">
                <small class="glyphicon glyphicon-calendar pull-left"> <?= date_create( $machine['date'] )->Format('d.m.Y') ?></small>
                <small class="glyphicon glyphicon-eye-open pull-right"> <?= $machine['views'] ?></small>
            </div>
            <div class="clearfix"></div>
            <a href="<?=URL::to(['/stan-admin/editmachine/'.$machine['id']])?>" class="btn btn-default">
                <span class="glyphicon glyphicon-pencil"></span>
                Edit
            </a>
            <div class="clearfix"></div>
            <br/>
        </div>
    </div><!--item-->
    <?php endforeach; ?>

    <div class="col-md-3 col-sm-6">
        <div class="text-primary">&nbsp;</div>
        <a href="<?=URL::to('/stan-admin/addmachine')?>" class="btn btn-default">
            <span class="glyphicon glyphicon-file"></span>
            Add new machine
        </a>
    </div><!--item-->

</div>
