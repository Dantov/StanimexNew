<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $shipments array */

$jsImgLoad = <<<JS
    function onImgLoad(self) {
        let prevImg = self.previousElementSibling;
            prevImg.classList.add('hidden');
        self.classList.remove('hidden');
    };
JS;

$this->registerJs($jsImgLoad, View::POS_BEGIN);
$this->registerJsFile('@web/js/shipments.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>'']);
?>
<div class="machineTopBg"></div>
<div class="clearfix"></div>
<div class="service">
    <div class="container">
        <br />
        <br />
        <br />
        <br />
        <div class="col-md-12 sect-headr">
            <h2>Наши<span> Отгрузки</span></h2>
            <h4 id="date"></h4>
        </div><!--section header-->

        <div class="clearfix"></div>
        <div class="row shipmentsBlock">
            <?php foreach( $shipments as $key => $shipment ): ?>
                <?php $sName = $shipment['stock']['short_name_ru']??$shipment['description_ru']??$shipment['description_en']; ?>
                <div class="col-xs-6 col-md-3 prj-item col-sm-4 openImgModal" data-shipment-name="<?=$sName?>" data-shipment-id="<?=$shipment['id']?>" data-shipment-images="<?=implode('-;!',$shipment['img'])?>">
                    <div class="ratio img-thumbnail">
                        <a href="#" class="">
                            <div class="ratio-inner ratio-4-3">
                                <div class="ratio-content">
                                    <img src="/web/shipments/<?=$shipment['img'][0]?>" class="img-responsive">
                                    <div class="info">
                                        <i></i>
                                        <h5 class="topName"><?=$sName?></h5>
                                        <h6>Open</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="text-muted margtop"><small class="glyphicon glyphicon-calendar pull-left"> <?= date_create( $shipment['date'] )->Format('d.m.Y'); ?></small></div>
                        <div class="clearfix"></div>
                        <span class="text-primary"><strong><?=$sName?></strong></span>
                    </div>
                </div><!--item-->
            <?php endforeach; ?>
        </div><!--row-->
    </div><!--container-->
</div><!--about-->


<!-- Modal Images -->
<div class="modal fade" id="ShowImageModal" tabindex="-1" role="dialog" aria-labelledby="ShowImageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ShowImageModalLabel"></h4>
            </div>
            <div class="modal-body">
                <!-- Carousel -->
                <div id="carousel-shipments" class="carousel slide" data-ride="">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-shipments" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-shipments" role="button" data-slide="next">
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

    <li data-target="#carousel-shipments" data-slide-to="" class="protoLI hidden"></li>
    <div class="itemProto hidden <?= $k==0 ? "active" : "" ?>">
        <div class="row">
            <div class="col-xs-12">
                <center>
                    <img src="" alt="" style="max-width: 100%!important;">
                </center>
            </div>
        </div>
    </div>

</div>