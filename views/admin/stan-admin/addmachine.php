<?php
use yii\helpers\Url;

/* @var $machine array - Id in stock new machine */
$session = yii::$app->session;
$this->registerJsFile('@web/sadm/js/uploadFile.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?=Url::to('/stan-admin/main')?>">Admin</a>
        <i class="fa fa-angle-right"></i>
        <a href="<?=Url::to('/stan-admin/stock')?>">Stock</a>
    </li>
</ol>
<!--grid-->
<div class="validation-system">
    <div class="validation-form">
        <p id="topName" class="text-warning" align="center">Add New Machine:</p>
        <!---->

        <form id="login_form" method="post" action="<?=Url::to(['/stan-admin/editmachine/'. $machine['id'] ])?>" enctype="multipart/form-data">
            <div class="vali-form">
                <div class="col-md-6 form-group1">
                    <label for="short_name_ru">*Short Name RU</label>
                    <input name="short_name_ru" id="short_name_ru" type="text" value="">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="short_name_en">*Short Name EN</label>
                    <input name="short_name_en" id="short_name_en" type="text" value="">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="name_ru">*Full Name RU</label>
                    <input name="name_ru" id="name_ru" type="text" value="">
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="name_en">*Full Name EN</label>
                    <input id="name_en" name="name_en" type="text" value="" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="vali-form form-group1">
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_ru">Description RU</label>
                    <textarea name="description_ru" id="description_ru" rows="10" type="text"></textarea>
                </div>
                <div class="col-md-6 form-group1 form-last">
                    <label for="description_en">Description EN</label>
                    <textarea name="description_en" id="description_en" rows="10" type="text"></textarea>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 vali-form " id="picts">
                <div class="col-md-12 gallery-grids-left">
                    <label class="control-label">Pictures:</label>
                </div>
                <div class="col-md-3 gallery-grids-left" style="margin-bottom: 10px!important;" id="add_bef_this">
                    <div class="ratio img-thumbnail">
                        <div class="ratio-inner ratio-4-3">
                            <div class="ratio-content">
                                <div class="image-zoom responsive">
                                    <center>
                                        <a class="btn" role="button" title="Add Image" id="add_img">
                                            <img src="<?=URL::to('/web/img/uploadImg.png')?>" style="max-height: 100%!important;">
                                        </a>
                                    </center>
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
                    <option selected value="null">No</option>
                    <option value="hot">Hot</option>
                    <option value="sold">Sold</option>
                </select>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-6 form-group1 group-mail">
                <label class="control-label" for="date">Дата размещения</label>
                <input type="text" name="date" id="date" value="<?=$machine['date']?>" />
            </div>
            <div class="col-md-6 form-group1 group-mail">
                <label class="control-label" for="views">Просмотры</label>
                <input type="text" name="views" id="views" value="" />
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12 form-group">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <input type="reset" class="btn btn-default" value="Reset">
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