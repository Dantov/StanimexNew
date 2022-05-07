<?php
use yii\helpers\Url;
use yii\web\View;

/* @var $aboutUs array */
/* @var $weBuy array */
/* @var $stock array */
/* @var $contacts array */
/* @var $shipments array */
/* @var $sliderImg array */
$imgEncode = json_encode($sliderImg,JSON_UNESCAPED_UNICODE);
$js = <<<JS
    let _sliderImages_ = {$imgEncode};
    //console.log(sliderImages);
JS;
$this->registerJs($js, View::POS_BEGIN );
$this->registerJsFile('@web/js/StanSlider.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>''] );
$this->registerJsFile('@web/js/send_mail.js?v=' . time(),['depends'=>['yii\web\YiiAsset'],'defer'=>''] );
?>
<a name="hotsell"></a>
<div class="slidr slidr-small" data-current-slide="" id="slidr">
    <div class="container-fluid">
        <div class="row mt-90 mb-20">
            <div class="col-sm-12 text-center mb5">
                <h2 class=""><span class="p1 plr3" style="font-size: 1em; background-color: rgba(255,255,255,0.71); color: #18c08f;">
                        <span style="color: #2c2c2c;">Срочная</span>&nbsp;
                        <span style="text-shadow: 1px 1px 1px #2c2c2c;">Продажа</span>
                </h2>
            </div>
            <?php foreach ( $stock as $machine ): ?>
                <div class="col-sm-6 col-md-3" style="margin-bottom: 15px!important;">
                    <a href="<?= Url::to(["/machine/{$machine['id']}"]); ?>">
                        <?php if( $machine['status'] === 'sold' ): ?>
                            <span class="label label-danger hotLable_main">ПРОДАН</span>
                        <?php endif; ?>
                        <?php if( $machine['status'] === 'hot' ): ?>
                            <span class="label label-success hotLable_main">
                                  <span class="glyphicon glyphicon-fire"></span>Горячий
                                </span>
                        <?php endif; ?>

                        <div id="carousel-machine-<?=$machine['id']?>" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ( $machine['images'] as $k => $image ): ?>
                                    <div class="item <?= $k==0 ? "active" : "" ?>" style="max-height: 100%!important;">
                                        <div class="ratio">
                                            <div class="ratio-inner ratio-4-3">
                                                <div class="ratio-content">
                                                    <div class="image-zoom responsive">
                                                        <center>
                                                            <img src="/web/Stockimages/<?=$image['img_name']?>" alt="<?=$machine['name_ru']?>" style="max-width: 100%;!important;">
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="carousel-caption p0" style="bottom: 0px!important;">
                                    <h3 style="text-shadow: #0f0f0f;"><?=$machine['short_name_ru']?></h3>
                                </div>
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
                    </a>
                </div><!--item-->
            <?php endforeach; ?>
        </div><!--row-->
    </div>
    <div class="buttons hidden">
        <button class="controls" id="previous">&lt;</button>
        <button class="controls" id="pause">&#10074;&#10074;</button>
        <button class="controls" id="next">&gt;</button>
    </div>

</div><!--slider-->

<div class="col-md-12 call-to-action p0" style="font-size: 0.2em">&nbsp;</div>

<div class="clearfix"></div>

<div class="about">
    <a name="about"></a>
    <div class="container">
        <div class="col-md-12 sect-headr">
            <h2>О <span>Нас</span></h2>
            <h4><?= $aboutUs[0]['text_ru'] ?></h4>
        </div><!--section header-->
        <div class="clearfix"></div>

        <div class="about-text">

            <p><?= $aboutUs[1]['text_ru'] ?></p>
            <h4></h4><br /><br />
            <p><?= $aboutUs[2]['text_ru'] ?></p>
            <h4></h4><br /><br />
            <p><?= $aboutUs[3]['text_ru'] ?><p>

            </p>
            <h4>Контакты</h4>
            <p>
                <?php foreach ($contacts??[] as $contact): ?>
                <?= $contact['description_ru'] ?><br/>
                <?php endforeach; ?>
            </p>
        </div><!--about text-->
        <a name="hotsell"></a>
    </div><!--container-->
</div><!--about-->

<a name="webuy"></a>
<div class="projects webuy">
    <div class="container">

        <div class="col-md-12 sect-headr">
            <h2>Мы <span>Покупаем</span></h2>
            <h4>Сегодня мы покупаем</h4>
        </div><!--section header-->
        <div class="clearfix"></div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr class="">
                    <th>Наименование</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $weBuy as $d => $itemMachine ): ?>
                    <tr>
                        <td><?php echo $itemMachine['name_ru']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div><!--container-->
</div><!--projects-->

<div class="service shipments">
    <div class="container">
        <div class="col-md-12 sect-headr">
            <h2>Последние <span>Отгрузки</span></h2>
            <h4>Наше оборудование при погрузке</h4>
        </div><!--section header-->

        <div class="clearfix"></div>
        <div class="row">
            <?php foreach ( $shipments as $shipment ): ?>
                <div class="col-sm-4 col-md-3" style="margin-bottom: 15px!important;">
                    <a href="<?= Url::to(["/shipment"]); ?>">
                        <div id="carousel-shipment-<?=$shipment['id']?>" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ( $shipment['img'] as $k => $image ): ?>
                                    <div class="item <?= $k==0 ? "active" : "" ?>" style="max-height: 100%!important;">
                                        <div class="ratio">
                                            <div class="ratio-inner ratio-4-3">
                                                <div class="ratio-content">
                                                    <div class="image-zoom responsive">
                                                        <center>
                                                            <img src="/web/shipments/<?=$image?>" alt="<?=$shipment['stock']['short_name_ru']?>" style="max-width: 100%;!important;">
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="carousel-caption">
                                    <h3 style="text-shadow: #0f0f0f"><?=$shipment['description_ru']??$shipment['description_en']?></h3>
                                </div>
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-shipment-<?=$shipment['id']?>" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-shipment-<?=$shipment['id']?>" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </a>
                </div><!--item-->
            <?php endforeach; ?>
        </div><!--row-->
    </div>
</div>

<!--Brands-->
<div class="clients">
    <div class="container">
        <div class="morelogos">
            <img src="/web/img/brand_logos/WMW_logo.JPG">
            <img src="/web/img/brand_logos/Sedin.JPG">
            <img src="/web/img/brand_logos/studer_logo.png">
            <img src="/web/img/brand_logos/Churchill_logo.JPG">
            <img src="/web/img/brand_logos/hause-bienne_logo.jpg">
            <img src="/web/img/brand_logos/kellenberger-studer_logo.jpg">
            <img src="/web/img/brand_logos/jones-shipman_logo.jpg">
            <img src="/web/img/brand_logos/sip_logo.png">
            <img src="/web/img/brand_logos/WMW_Schriftzug_logo.jpg">
            <img src="/web/img/brand_logos/bwf-logo.jpg">
            <img src="/web/img/brand_logos/microsa_logo.gif">
            <img src="/web/img/brand_logos/TOS_logo.JPG">
            <img src="/web/img/brand_logos/schaudt_logo.jpg">
            <img src="/web/img/brand_logos/voumard_logo.jpg">
            <img src="/web/img/brand_logos/elb_logo.gif">
            <img src="/web/img/brand_logos/blohm_logo.jpg">
            <img src="/web/img/brand_logos/dixi_logo.jpg">
            <img src="/web/img/brand_logos/MIKRON-Logo.jpg">
            <img src="/web/img/brand_logos/htg_logo.jpg">
            <img src="/web/img/brand_logos/sip_logo-1.jpg">
            <img src="/web/img/brand_logos/tripet-machines_logo.jpg">
        </div>
    </div>
</div>
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d906.9315787503408!2d36.2369984398198!3d49.98904947577284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sru!4v1508611878073" height="444" style="border-bottom:3px solid #18c08f;width:100%; border-top:0 none; border-left:0 none; border-right:0 none;"></iframe>
</div><!--map-->
<!--Contacts Start-->
<a name="contact"></a>
<div class="contact">
    <div class="container">

        <div class="col-md-12 sect-headr">
            <h2>Свяжитесь <span>с Нами</span></h2>
            <h4></h4>
        </div><!--section header-->
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 hidden alertOKSend">
                <div class="alert alert-success" role="alert">
                    <h5 class="alert-link">Спасибо! В ближайшее время мы свяжемся с Вами!</h5>
                </div>
            </div>
            <div class="col-md-12 hidden alertErrorSend">
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-link">При отправке сообщения произошла ошибка!</h5>
                </div>
            </div>
            <form id="send_mail_form" method="post" action="">
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="form-group col-md-12 connm">
                            <label for="your-name">Ваше Имя <span id="nameValid">*</span></label>
                            <input type="text" class="form-control" size="40" value="" name="name" id="your-name">
                        </div>

                        <div class="form-group col-md-12 conem">
                            <label for="your-email">Ваш Email <span id="emailValid">*</span></label>
                            <input type="email" class="form-control" size="40" value="" name="email" id="your-email">
                        </div>

                        <div class="form-group col-md-12 conem">
                            <label for="your-subject">Тема <span id="subjectValid">*</span></label>
                            <input type="text" class="form-control" size="40" value="" name="theme" id="your-subject">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="form-group col-md-12 conmm">
                            <label for="message">Сообщение <span id="messageValid">*</span></label>
                            <textarea class="form-control" rows="10" cols="40" name="message" id="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-md-12 text-center"><input data-loading-text="Отправление..." type="button" class="subbtn sendMail" value="Отправить"></div>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            </form>

        </div><!--row-->
    </div><!--container-->
</div><!--contact-->
