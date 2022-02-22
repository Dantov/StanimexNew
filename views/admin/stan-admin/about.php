<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $about array */
/* @var $contacts array */
$session = yii::$app->session;
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a><i class="fa fa-angle-right"></i>AboutUs</li>
</ol>

<div class="validation-system" id="aboutus">
    <div class="validation-form">
        <p id="topName" class="text-warning" align="center">Редактировать: <strong>About Us</strong></p>
        <!---->
        <?php if ( $session->hasFlash('no_upd') ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> <?=$session->getFlash('no_upd');?> </strong>
            </div>
        <?php endif; ?>
        <?php if ( $session->hasFlash('success_upd') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> <?=$session->getFlash('success_upd');?> </strong>
            </div>
        <?php endif; ?>
        <?php if ( $session->hasFlash('success_img') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong> <?=$session->getFlash('success_img');?> </strong>
            </div>
        <?php endif; ?>

            <div class="vali-form">
                <form id="login_form" method="post" action="<?=Url::to(['/stan-admin/about'])?>">
                    <div class="col-md-6 form-group1">
                        <label>ABOUT US - RU</label>
                    </div>
                    <div class="col-md-6 form-group1">
                        <label>ABOUT US - EN</label>
                    </div>
                    <?php foreach ( $about as $us ): ?>
                        <div class="col-md-6 form-group1">
                            <textarea name="<?= "aboutus-text_ru-" . $us['id'] ?>" id="" cols="30" rows="5"><?= $us['text_ru'] ?></textarea>
                        </div>
                        <div class="col-md-6 form-group1">
                            <textarea name="<?= "aboutus-text_en-" . $us['id'] ?>" id="" cols="30" rows="5"><?= $us['text_en'] ?></textarea>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-md-12 form-group1">
                        <hr/>
                    </div>
                    <div class="col-md-6 form-group1">
                        <label>CONTACTS - RU</label>
                    </div>
                    <div class="col-md-6 form-group1">
                        <label>CONTACTS - EN</label>
                    </div>
                    <?php foreach ( $contacts as $contact ): ?>
                        <div class="col-md-6 form-group1">
                            <textarea name="<?= "contacts-description_ru-" . $contact['id'] ?>" id="" cols="30" rows="2"><?= $contact['description_ru'] ?></textarea>
                        </div>
                        <div class="col-md-6 form-group1">
                            <textarea name="<?= "contacts-description_en-" . $contact['id'] ?>" id="" cols="30" rows="2"><?= $contact['description_en'] ?></textarea>
                        </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    <div class="col-md-12 form-group1 form-last">
                        <input type="submit" class="btn btn-primary" value="Сохранить">
                    </div>
                </form>
            </div>

            <div class="clearfix"></div>
            <br/>
            <div class="col-md-12 form-group">

            </div>
            <div class="clearfix"></div>

        <!---->
    </div>
</div>

