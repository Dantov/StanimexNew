<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $machine array */
/* @var $mainImage array */
/* @var $machineCrumbs array */
/* @var $editBtn bool */

//debug($machineCrumbs);
$jsImgLoad = <<<JS
    function onImgLoad(self) {
        let prevImg = self.previousElementSibling;
            prevImg.classList.add('hidden');
        self.classList.remove('hidden');
    };
JS;

$this->registerJs($jsImgLoad, View::POS_BEGIN);
$this->registerJsFile('@web/js/machine.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<div class="machineTopBg"></div>
<div class="clearfix"></div>
<div class="about">
    <div class="container">
        <br />
        <br />
        <div class="row">
            <a class="text-info pull-left" href="<?= Url::to(['/machine/' . $machineCrumbs['prev']['id']] ) ?>" id="topprev"><h4><?=
                    isset($machineCrumbs['prev']['short_name_ru']) ? "←" . $machineCrumbs['prev']['short_name_ru'] : ""; ?></h4>
            </a>
            <a class="text-info pull-right" href="<?= Url::to(['/machine/' . $machineCrumbs['next']['id']] ) ?>" id="topnext"><h4><?=
                    isset($machineCrumbs['next']['short_name_ru']) ? $machineCrumbs['next']['short_name_ru'] . "→" : ""; ?></h4>
            </a>
            <hr/>
            <div class="clearfix"></div>

            <h4 id="topName" class="text-primary well well-sm">
                <strong><?= $machine['name_ru'];?></strong>

                <?php if( $machine['status'] === 'sold' ): ?>
                    <span class="label label-danger pull-right">ПРОДАН</span>
                <?php endif; ?>
                <?php if( $machine['status'] === 'hot' ): ?>
                    <span class="label label-success pull-right">
                      <span class="glyphicon glyphicon-fire"></span>Срочная продажа!
                    </span>
                <?php endif; ?>
            </h4>

            <div class="col-xs-12 col-sm-6" id="images_block">
                <div class="row">

                    <div class="col-xs-12 mainImg">
                        <div class="image-zoom responsive">
                            <center>
                                <img src="/web/img/loading_circle.gif" class="img-responsive image">
                                <img src="/web/Stockimages/<?=$mainImage['img_name']?>" class="img-responsive hidden image machinePicture" data-num="<?= $mainImage['num'] ?>" onload="onImgLoad(this);">
                            </center>
                        </div>
                    </div>
                    <?php foreach( $machine['images'] as $image ):?>
                        <div class="col-xs-12 col-sm-6 col-md-4 image">
                            <div class="ratio">
                                <div class="ratio-inner ratio-4-3">
                                    <div class="ratio-content">
                                        <div class="image-zoom responsive">
                                            <center>
                                                <img src="/web/img/loading_circle.gif" class="img-responsive image">
                                                <img src="/web/Stockimages/<?= $image['img_name']?>" class="img-responsive image hidden machinePicture" data-num="<?= $num++; ?>" onload="onImgLoad(this);">
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- small img end -->
                    <?php endforeach; ?>
                </div>
            </div><!-- images block -->

            <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-1 descr">
                <p>
                    <strong>Описание:</strong>
                </p>
                <p style="font-size: large"><?= html_entity_decode($machine['description_ru']) ?></p>
                <br/>
                <p>
                    <input type="button" id="makeOrder" class="btn btn-primary" value="Сделать заказ">
                </p>
            </div>

        </div><!--row-->

        <div class="row bg-info butt-inf">
            <input type="hidden" name="status" id="status" value="<?= $machine['status']; ?>" />
            <div class="col-xs-12 col-sm-4">
                <span class="glyphicon glyphicon-calendar pull-left" title="Дата">&#160;<?php echo date_create( $machine['date'] )->Format('d.m.Y'); ?></span>
            </div>
            <div class="col-xs-12 col-sm-4">
            <?php if ( $editBtn ): ?>
            <a type="button" class="btn btn-outline-danger center-block" href="<?=URL::to(['/stan-admin/editmachine/'. $machine['id'] ])?>">Edit Machine</a>
            <?php endif; ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <span class="glyphicon glyphicon-eye-open pull-right" title="Просмотры">&#160;<?= $machine['views']?></span>
            </div>
            <div class="clearfix"></div>
        </div><!--section header-->

        <div class="clearfix"></div>

        <div class="row">
            <hr />
        </div><!--row-->
    </div><!--container-->
</div><!--about-->

<!-- Modal Images -->
<div class="modal fade" id="ShowImageModal" tabindex="-1" role="dialog" aria-labelledby="ShowImageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ShowImageModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <!--<center><img src="" class="img-responsive"></center>-->
                <!-- Carousel -->
                <div id="carousel-machine-<?=$machine['id']?>" class="carousel slide" data-ride="">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php foreach ( $machine['images'] as $k => $image ): ?>
                            <li data-target="#carousel-machine-<?=$machine['id']?>" data-slide-to="<?=$k?>" class="<?= $k==0 ? "active" : "" ?>"></li>
                        <?php endforeach; ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ( $machine['images'] as $k => $image ): ?>
                            <div class="item <?= $k==0 ? "active" : "" ?>">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <center>
                                            <img src="/web/Stockimages/<?=$image['img_name']?>" alt="<?=$machine['name_ru']?>" style="max-width: 100%!important;">
                                        </center>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-machine-<?=$machine['id']?>" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-machine-<?=$machine['id']?>" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Orders -->
<div class="modal fade" id="ShowOrderModal" tabindex="-1" role="dialog" aria-labelledby="ShowOrderModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ShowOrderModalLabel">Заказать Оборудование: </h4>
            </div>
            <div class="modal-body">

                <div class="row ">
                    <form id="send_order_form" >
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-6 connm">
                                    <label for="your-name">Ваше Имя <span id="nameValid">*</span></label>
                                    <input type="text" class="form-control" value="" name="name" id="your-name">
                                </div>
                                <div class="form-group col-md-6 conem">
                                    <label for="your-email">Ваш Email <span id="your-email">*</span></label>
                                    <input type="email" class="form-control" value="" name="email" id="your-email">
                                </div>
                                <div class="form-group col-md-6 conem">
                                    <label for="your-phone">Телефон</label>
                                    <input type="text" class="form-control" value="" name="phone" id="your-phone">
                                </div>
                                <div class="form-group col-md-6 conem">
                                    <label for="your-company">Компания</label>
                                    <input type="text" class="form-control" value="" name="company" id="your-company">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-12 conmm">
                                    <label for="your-message">Комментарий <span id="messageValid">*</span></label>
                                    <textarea class="form-control" rows="4" cols="40" name="message" id="your-message"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center">
                            <input type="button" class="subbtn" value="Отправить">
                        </div>
                        <input type="hidden" class="form-control hidden" value="<?=$machine['id']?>" name="pos_id">
                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                    </form>

                    <div class="col-md-12 text-center hidden" id="orderOK">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-link">
                                Спасибо! Заказ отправлен. В ближайшее время мы свяжемся с Вами!
                            </h4>
                        </div>
                    </div>
                    <div class="col-md-12 text-center hidden" id="orderError">
                        <div class="alert alert-danger" role="alert">
                            <a href="#" type="button" class="close"><span class="glyphicon glyphicon-remove"></span></a>
                            <h4 class="alert-link">
                                При отправке заказа произошла ошибка! Повторите попытку позже.
                            </h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>