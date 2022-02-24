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
        <h4 id="topName" class="text-warning" align="center"><strong>Заказы</strong> (Дублируются на адрес: stanimex@machines.com)</h4>
        <?php if ( empty($orders['orders']) ):?>
            <p>Пока пусто...</p>
        <?php endif;?>
    </div>

    <?php foreach( $orders['orders'] as $order ): ?>
    <div class="validation-form">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel-group" role="tablist">
                        <div class="panel panel-success">
                            <div class="panel-heading" role="tab" id="collapse<?=$order['id']?>_Heading">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapse<?=$order['id']?>" aria-expanded="false" aria-controls="collapseListGroup1">
                                        Заказ от: <span><?=$order['name']?></span> - <?=formatDate($order['date'])?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?=$order['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapse<?=$order['id']?>_Heading" aria-expanded="false" style="height: 0px;">
                                <ul class="list-group">
                                    <li class="list-group-item">От компании: <strong><?=$order['company']?></strong></li>
                                    <li class="list-group-item">E-mail: <strong><?=$order['email']?></strong></li>
                                    <li class="list-group-item">Телефон: <strong><?=$order['phone']?></strong></li>
                                    <li class="list-group-item">Сообщение: <strong><?=$order['message']?></strong></li>
                                    <li class="list-group-item"><a href="<?=Url::to(['/stan-admin/editmachine/'.$order['pos_id'] ])?>"><?=$order['machineName']?></a></li>
                                </ul>
                                <div class="panel-footer">
                                    <input type="button" class="btn btn-default pull-right" onclick="removePos(this,<?= $order['id'] ?>)" value="В Архив" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="clearfix"></div>
    </div>
    <?php endforeach; ?>

    <div class="validation-form">
        <div class="row"></div>
        <h4 id="topName" class="text-warning" align="center"><strong>Письма</strong> (Дублируются на адрес: stanimex@machines.com)</h4>
        <?php if ( empty($orders['mails']) ):?>
            <p>Пока пусто...</p>
        <?php endif;?>
    </div>

    <?php foreach( $orders['mails'] as $mail ): ?>
        <div class="validation-form">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel-group" role="tablist">
                        <div class="panel panel-info">
                            <div class="panel-heading" role="tab" id="collapse<?=$mail['id']?>_Heading">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapse<?=$mail['id']?>" aria-expanded="false" aria-controls="collapseListGroup1">
                                        Письмо от: <span><?=$mail['name']?></span> - <?=formatDate($mail['date'])?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?=$mail['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapse<?=$mail['id']?>_Heading" aria-expanded="false" style="height: 0px;">
                                <ul class="list-group">
                                    <li class="list-group-item">Тема: <strong><?=$mail['theme']?></strong></li>
                                    <li class="list-group-item">E-mail: <strong><?=$mail['email']?></strong></li>
                                    <li class="list-group-item">Сообщение: <strong><?=$mail['message']?></strong></li>
                                </ul>
                                <div class="panel-footer">
                                    <input type="button" class="btn btn-default pull-right" onclick="removePos(this,<?= $mail['id'] ?>)" value="В Архив" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; ?>

</div>