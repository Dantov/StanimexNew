<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $machine array */
/* @var $images array */
/* @var $machineCrumbs array */
/* @var $shipmentID int */
$session = yii::$app->session;
$this->registerJsFile('@web/sadm/js/uploadFile.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?=Url::to('/stan-admin/stock')?>">Stock</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?=Url::to('/machine/'. $machine['id'])?>" title="Просмотр"><?=$machine['short_name_ru']?></a>
    </li>
</ol>
<!--grid-->
<div class="validation-system">
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
    <?php if ( $session->hasFlash('success_add') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$session->getFlash('success_add');?> </strong>
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

    <div class="validation-form">
        <p id="topName" class="text-warning" align="center">Редактировать: <strong><?=$machine['short_name_ru']?></strong></p>
        <!---->
        <form id="machine_form" method="post" action="<?=Url::to(['/stan-admin/editmachine/'. $machine['id'] ])?>" enctype="multipart/form-data">
            <div class="vali-form">
                <div class="col-md-6 form-group1">
                    <label for="short_name_ru">Short Name RU (max 28)</label>
                    <input name="short_name_ru" id="short_name_ru" maxlength="28" type="text" value="<?=$machine['short_name_ru']?>">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="short_name_en">Short Name EN</label>
                    <input name="short_name_en" id="short_name_en" maxlength="28" type="text" value="<?=$machine['short_name_en']?>">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="name_ru">Full Name RU</label>
                    <input name="name_ru" id="name_ru" type="text" value="<?=$machine['name_ru']?>">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="name_en">Full Name EN</label>
                    <input id="name_en" name="name_en" type="text" value="<?=$machine['name_en']?>" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="vali-form form-group1">
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_ru">Description RU</label>
                    <textarea name="description_ru" id="description_ru" rows="10" type="text"><?=html_entity_decode($machine['description_ru'])?></textarea>
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_en">Description EN</label>
                    <textarea name="description_en" id="description_en" rows="10" type="text"><?=html_entity_decode($machine['description_en'])?></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 vali-form " id="picts">
                <div class="col-md-12 gallery-grids-left">
                    <label class="control-label">Pictures:</label>
                </div>
                <?php foreach ( $images??[] as $image): ?>
                    <div class="col-md-3 gallery-grids-left" style="margin-bottom: 10px!important;">
                        <div class="ratio img-thumbnail">
                            <div class="ratio-inner ratio-4-3">
                                <div class="ratio-content">
                                    <div class="image-zoom responsive">
                                        <center>
                                            <img src="/web/Stockimages/<?=$image['img_name']?>" alt="<?=$machine['name_ru']?>" style="width: 100%;!important;">
                                        </center>
                                    </div>
                                </div>
                                <label for="mainImg_<?=$image['id']?>" class="btn btn-info pull-left mainImgLabel">Главная картинка
                                    <?php if( $image['main'] == 1 ) $cheched = "checked" ?>
                                    <input type="radio" <?=$cheched?> id="mainImg_<?=$image['id']?>" name="main" value="<?=$image['id']?>">
                                    <?php $cheched = ""; ?>
                                </label>
                            </div>
                        </div>
                        <a class="btn btn-danger btn-rem pull-right" role="button" title="Delete" onclick="removeImgFromPos(this,<?=$image['id']?>)">
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

            <div class="col-md-12 form-group2 group-mail">
                <label class="control-label" for="statusSelect">Статус</label>
                <select name="status" id="statusSelect">
                    <option <?php if(empty($machine['status'])) echo "selected"; ?> value="null">No</option>
                    <option <?php if($machine['status'] == 'hot') echo "selected"; ?> value="hot">Hot</option>
                    <option <?php if($machine['status'] == 'sold') echo "selected"; ?> value="sold">Sold</option>
                </select>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-6 form-group1 group-mail">
                <label class="control-label" for="date">Дата размещения</label>
                <input type="text" name="date" id="date" value="<?=$machine['date']?>" />
            </div>
            <div class="col-md-6 form-group1 group-mail">
                <label class="control-label" for="views">Просмотры</label>
                <input type="text" name="views" id="views" value="<?=$machine['views']?>" />
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12 form-group">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="hidden" id="machineID" name="machineID" value="<?=$machine['id'] ?>" />
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <input type="reset" class="btn btn-default" value="Reset">

                <?php if( !$shipmentID ): ?>
                    <a href="<?=URL::to(['/stan-admin/shipment/','a'=>'add','pos_id'=>$machine['id']])?>" class="btn btn-default">
                        <span class="glyphicon glyphicon-file"></span>
                        Add new shipment
                    </a>
                <?php endif; ?>
                <?php if( $shipmentID ): ?>
                    <a href="<?=URL::to(['/stan-admin/shipment/'.$shipmentID,'a'=>'edit'])?>" class="btn btn-default">
                        <span class="glyphicon glyphicon-file"></span>
                        Edit shipment
                    </a>
                <?php endif; ?>

                <a class="btn btn-default pull-right" role="button" onclick="dellPosition(<?=$machine['id'] ?>)">
                    <span class="glyphicon glyphicon-remove"></span>
                    Delete Machine
                </a>
            </div>
            <div class="clearfix"></div>
        </form>
        <input type="file" multiple class="hidden uploadImagesInput" accept="image/jpeg,image/png,image/webp,image/gif">
    </div>
</div>

<div class="col-md-3 gallery-grids-left protoImgRow hidden" data-file-id="" style="margin-bottom: 10px!important;">
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
