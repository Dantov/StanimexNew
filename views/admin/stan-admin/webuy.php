<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $webuy array */
/* @var $contacts array */
$session = yii::$app->session;

$this->registerJsFile('@web/sadm/js/webuy.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a><i class="fa fa-angle-right"></i>We Buy</li>
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
        <h4 id="topName" class="text-warning" align="center">Редактировать: <strong>We Buy</strong></h4>
        <input type="button" class="btn btn-success addWebuy" data-position="top" value="Add" title="Add Position" >
    </div>

    <form id="webuy_form" method="post" action="<?=Url::to(['/stan-admin/webuy'])?>">
        <div class="hidden" id="addBeforeThisTop"></div>
        <?php foreach( $webuy as $position ): ?>
        <div class="validation-form">
                <div class="row">
                    <div class="col-md-6 form-group1">
                        <label for="<?= "name_ru_" . $position['id'] ?>">*Text Ru</label>
                        <textarea name="<?= "webuy-name_ru-" . $position['id'] ?>" id="<?= "name_ru_" . $position['id'] ?>" cols="10" rows="1"><?= $position['name_ru'] ?></textarea>
                    </div>
                    <div class="col-md-6 form-group1">
                        <label for="<?= "name_en_" . $position['id'] ?>">*Text En</label>
                        <textarea name="<?= "webuy-name_en-" . $position['id'] ?>" id="<?= "name_en_" .$position['id'] ?>" cols="10" rows="1"><?= $position['name_en'] ?></textarea>
                    </div>
                </div>
            <hr/>
            <input type="button" class="btn btn-default pull-right" onclick="removePos(this,<?= $position['id'] ?>)" value="Delete" >
            <div class="clearfix"></div>
        </div>
        <?php endforeach; ?>
    <div class="validation-form" id="addBeforeThisBottom">
        <div class="row">
            <div class="col-md-12 form-group">
                <input type="button" class="btn btn-success addWebuy" data-position="bottom" value="Add" title="Add Position" >
                <input type="Submit" class="btn btn-primary" id="Save" title="Save All" value="Save All">
            </div>
        </div>
    </div>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    </form>
</div>


<div class="validation-form hidden protorow">
    <div class="row">
        <div class="col-md-6 form-group1">
            <label for="name_ru_">*Text Ru</label>
            <textarea name="webuy-name_ru-" id="name_ru_" cols="10" rows="1"></textarea>
        </div>
        <div class="col-md-6 form-group1">
            <label for="name_en_">*Text En</label>
            <textarea name="webuy-name_en-" id="name_en_" cols="10" rows="1"></textarea>
        </div>
    </div>
    <hr/>
    <input type="button" class="btn btn-default pull-right" onclick="" value="Delete" >
    <div class="clearfix"></div>
</div>