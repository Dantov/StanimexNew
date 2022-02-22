<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $orders array */

$session = yii::$app->session;

//$this->registerJsFile('@web/sadm/js/webuy.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a><i class="fa fa-angle-right"></i>Orders</li>
</ol>

<div class="validation-system">
    <div class="validation-form">
        <!---->
        <?php if ( $session->hasFlash('success_upd') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> <?=$session->getFlash('success_upd');?> </strong>
            </div>
        <?php endif; ?>
        <?php if ( $session->hasFlash('success_add') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> <?=$session->getFlash('success_add');?> </strong>
            </div>
        <?php endif; ?>
        <h4 id="topName" class="text-warning" align="center"><strong>Заказы, Письма</strong></h4>
    </div>

    <form id="webuy_form" method="post" action="<?=Url::to(['/stan-admin/webuy'])?>">
        <div class="hidden" id="addBeforeThisTop"></div>
        <?php foreach( $orders??[] as $order ): ?>
        <div class="validation-form">
                <div class="row">

                </div>
            <hr/>
            <input type="button" class="btn btn-default pull-right" onclick="removePos(this,<?= $order['id'] ?>)" value="Delete" >
            <div class="clearfix"></div>
        </div>
        <?php endforeach; ?>
    </form>
</div>