<?php
use yii\helpers\Url;

/* @var $stock array */
?>
<div class="service">
    <div class="container">

        <div class="col-md-12 sect-headr pricelist">
            <h2>Прайс-<span>Лист</span></h2>
            <h4 id="date"></h4>
            <script>
                let date = new Date();
                let dt = document.getElementById('date');
                let strDate = date.toLocaleString("ru", { year: 'numeric', month: 'long' } );
                let arr = strDate.split('');
                    arr[0] = arr[0].toUpperCase();
                dt.innerHTML = arr.join('');
            </script>
        </div><!--section header-->

        <div class="clearfix"></div>
        <div class="row">
            <?php //debug($stock) ?>
            <?php foreach( $stock as $key => $machine ): ?>
                <div class="col-xs-6 col-md-3 prj-item col-sm-4">
                    <div class="ratio img-thumbnail">
                        <?php if ( $machine['status'] == 'sold' ): ?>
                            <span class="label label-danger hotLable_main">ПРОДАН</span>
                        <?php elseif ( $machine['status'] == 'hot' ): ?>
                            <span class="label label-success hotLable_main">
                                <span class="glyphicon glyphicon-fire"></span>Горячий
                            </span>
                        <?php endif; ?>
                        <a href="<?= Url::to(["/machine/{$machine['id']}" ]) ?>">
                            <div class="ratio-inner ratio-4-3">
                                <div class="ratio-content">
                                    <img src="/web/Stockimages/<?=$machine['images'][0]['img_name']?>" class="img-responsive">
                                    <div class="info">
                                        <i></i>
                                        <h5><?= $machine['name_ru'];?></h5>
                                        <h6>Перейти</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="text-muted margtop"><small class="glyphicon glyphicon-calendar pull-left"> <?= date_create( $machine['date'] )->Format('d.m.Y'); ?></small><small class="glyphicon glyphicon-eye-open pull-right"> <?= $machine['views'];?></small></div>
                            <div class="clearfix"></div>
                            <span class="text-primary"><strong><?= $machine['short_name_ru'];?></strong></span>
                        </a>
                    </div>
                </div><!--item-->
            <?php endforeach; ?>

        </div><!--row-->
    </div><!--container-->
</div><!--about-->
