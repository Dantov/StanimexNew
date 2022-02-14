<?php
use yii\helpers\Url;

/* @var $machine array */
/* @var $mainImage array */
/* @var $machineCrumbs array */

//debug($machineCrumbs);

$this->registerJsFile('@web/js/machine.js?v=' . time(),['depends'=>['yii\web\YiiAsset']]);
?>

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

            <h4 id="topName" class="text-primary well well-sm"><strong><?= $machine['name_ru'];?></strong></h4>

            <div class="col-xs-12 col-sm-6" id="images_block">
                <div class="row">

                    <div class="col-xs-12 mainImg">
                        <div class="image-zoom responsive">
                            <center><img src="/web/Stockimages/<?=$mainImage['img_name']?>" class="img-responsive image machinePicture" num="<?= $num++; ?>"></center>
                        </div>
                    </div>
                    <?php foreach( $machine['images'] as $image ):?>
                        <div class="col-xs-12 col-sm-6 col-md-4 image">
                            <div class="ratio">
                                <div class="ratio-inner ratio-4-3">
                                    <div class="ratio-content">
                                        <div class="image-zoom responsive">
                                            <center>
                                                <img src="/web/Stockimages/<?= $image['img_name']?>" class="img-responsive image machinePicture" num="<?= $num++; ?>">
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
            </div>

        </div><!--row-->

        <div class="row bg-info butt-inf">
            <input type="hidden" name="status" id="status" value="<?= $machine['status']; ?>" />
            <small class="glyphicon glyphicon-calendar pull-left" title="Дата">&#160;<?php echo date_create( $machine['date'] )->Format('d.m.Y'); ?></small>
            <small class="glyphicon glyphicon-eye-open pull-right" title="Просмотры">&#160;<?= $machine['views']?></small>
            <div class="clearfix"></div>
        </div><!--section header-->

        <div class="clearfix"></div>

        <div class="row">
            <hr />
            <a class="btn btn-primary" role="button" href="<?= Url::to(['/price-list'])?>">
                <span class="glyphicon glyphicon-triangle-left"></span> Назад в Прайс
            </a>
        </div><!--row-->
    </div><!--container-->
</div><!--about-->

<!-- Modal -->
<div class="modal fade" id="ShowImageModal" tabindex="-1" role="dialog" aria-labelledby="ShowImageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ShowImageModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <center><img src="" class="img-responsive"></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>