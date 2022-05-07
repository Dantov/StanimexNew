<?php
use yii\helpers\Url;

/* @var $one array - Id in shipment table */
/* @var $action string -  */
$session = yii::$app->session;
$this->registerJsFile('@web/sadm/js/shipment.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?=Url::to('/stan-admin/shipments')?>">Shipments</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?=Url::to('/stan-admin/editmachine/'.$one['stock']['id'])?>">Edit in stock: <?= $one['stock']['short_name_ru'] ?></a>
    </li>
</ol>
<!--grid-->
<div class="validation-system">
    <div class="validation-form">
        <p id="topName" class="text-warning" align="center"><?= $action == 'edit' ? "Edit Shipment" : "Add new Shipment" ?></p>
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

        <form id="login_form" method="post" action="<?=Url::to(['/stan-admin/shipment/'. $one['id'],'a'=>'edit'])?>" enctype="multipart/form-data">
            <div class="vali-form form-group1">
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_ru">Description RU</label>
                    <textarea name="description_ru" id="description_ru" rows="5"><?= $one['description_ru'] ?></textarea>
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_en">Description EN</label>
                    <textarea name="description_en" id="description_en" rows="5"><?= $one['description_en'] ?></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 vali-form " id="picts">
                <div class="col-md-12 gallery-grids-left">
                    <label class="control-label">Pictures:</label>
                </div>
                <?php foreach ( $one['img']??[] as $src_image): ?>
                    <div class="col-md-3 gallery-grids-left" style="margin-bottom: 10px!important;">
                        <div class="ratio img-thumbnail">
                            <div class="ratio-inner ratio-4-3">
                                <div class="ratio-content">
                                    <div class="image-zoom responsive">
                                        <center>
                                            <img src="/web/shipments/<?=$src_image?>" alt="<?=$one['stock']['short_name_ru']?>" style="width: 100%;!important;">
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-danger btn-rem pull-right" role="button" title="Delete" onclick="removeImgFromPos(this,<?=$one['id']?>,'<?=$src_image?>')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>

                <div class="col-md-3 gallery-grids-left" style="margin-bottom: 10px!important;" id="add_bef_this">
                    <div class="ratio img-thumbnail">
                        <div class="ratio-inner ratio-4-3">
                            <div class="ratio-content">
                                <div class="responsive center-block">
                                    <a class="btn" role="button" title="Add Image" id="add_img">
                                        <img src="<?=URL::to('/web/img/uploadImg2.png')?>" style="max-width: 72%!important;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-6 form-group1 group-mail">
                <label class="control-label" for="date">Дата</label>
                <input type="date" name="date" id="date" value="<?=$one['date']?>" />
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12 form-group">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="hidden" id="shipmentID" name="shipmentID" value="<?=$one['id']?>" />
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <a class="btn btn-default pull-right" role="button" onclick="dellPosition(<?=$one['id'] ?>)">
                    <span class="glyphicon glyphicon-remove"></span>
                    Delete
                </a>
            </div>
            <div class="clearfix"></div>

            <input type="file" multiple class="hidden uploadImagesInput" name="" accept="image/jpeg,image/png,image/webp,image/gif">
        </form>
        <!---->

    </div>

</div>

<div class="col-md-3 gallery-grids-left protoImgRow hidden" style="margin-bottom: 10px!important;">
    <input type="hidden" multiple class="hidden" data-file-id="">
    <div class="ratio img-thumbnail">
        <div class="ratio-inner ratio-4-3">
            <div class="ratio-content">
                <div class="image-zoom responsive">
                    <center>
                        <img src="" alt="" style="width: 100%;!important;">
                    </center>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-danger btn-rem pull-right" role="button" title="Delete" onclick="dellImgPreview(this)">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <div class="clearfix"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="uploadImgModal" tabindex="-1" role="dialog" aria-labelledby="uploadImgModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Images are uploading. Please wait...
            </div>
        </div>
    </div>
</div>