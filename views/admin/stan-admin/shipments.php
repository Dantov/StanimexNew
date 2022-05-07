<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $all array */

$session = yii::$app->session;
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a><i class="fa fa-angle-right"></i>Our Shipments</li>
</ol>

<div class="validation-form">
    <p id="topName" class="text-warning" align="center">Редактировать: <strong>Our Shipments</strong></p>
    <?php if ( $session->hasFlash('error') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$session->getFlash('error');?> </strong>
        </div>
    <?php endif; ?>
    <?php if ( $session->hasFlash('success') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$session->getFlash('success');?> </strong>
        </div>
    <?php endif; ?>
    <div class="agile3-grids">
        <div class="gallery-grids">
            <div class="row" style="margin: 1em 0 1em 0">
            <?php if( !$all ): ?>
                <p>Пока пусто...</p>
            <?php endif; ?>
            <?php foreach( $all as $one ): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="ratio">
                        <div class="ratio-inner ratio-4-3">
                            <div class="ratio-content">
                                <div class="text-primary">
                                    <strong><?= $one['stock']['short_name_ru']??$one['description_ru']??$one['description_en'] ?></strong>
                                </div>
                                <img src="/web/shipments/<?=$one['img']?>" class="img-responsive">
                            </div>
                        </div>
                        <div class="text-muted margtop">
                            <small class="glyphicon glyphicon-calendar pull-left"> <?= date_create( $one['date'] )->Format('d.m.Y') ?></small>
                        </div>
                        <div class="clearfix"></div>
                        <a href="<?=URL::to(['/stan-admin/shipment/'.$one['id'],'a'=>'edit'])?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-pencil"></span>
                            Edit
                        </a>
                        <div class="clearfix"></div>
                        <br/>
                    </div>
                </div><!--item-->
            <?php endforeach; ?>

            </div>
        </div>
        <p>Что бы добавить отгрузку, нужно зайти на стр. Stock -> редактирование позиции -> Add New Shipment.</p>
    </div>
</div>