<?php
use yii\helpers\Url;

/* @var $aboutUs array */
/* @var $stock array */
/* @var $contacts array */

$this->registerJsFile('@web/js/mainSlider.js?v=' . time() );
?>
<div class="slidr" id="slidr">
    <img src="/web/img/mainslidr.gif">
    <div class="container">
        <div class="row position-relative">
            <div class="col-sm-12">
                <span class="bg-light border-dark"></span>
            </div>
        </div>
    </div>
    <div class="buttons">
        <button class="controls" id="previous">&lt;</button>
        <button class="controls" id="pause">&#10074;&#10074;</button>
        <button class="controls" id="next">&gt;</button>
    </div>
</div><!--slider-->

<div class="col-md-12 call-to-action p0"></div>

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

<div class="service hotsell">
    <div class="container">
        <div class="col-md-12 sect-headr">
            <h2>С<span>рочно</span></h2>
            <h4>Наше оборудование для срочной продажи</h4>
        </div><!--section header-->

        <div class="clearfix"></div>
        <div class="row">
            <?php foreach ( $stock as $machine ): ?>
                <div class="col-sm-4 col-md-3" style="margin-bottom: 10px!important;">
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
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                            <?php foreach ( $machine['images'] as $k => $image ): ?>
                                <li data-target="#carousel-machine-<?=$machine['id']?>" data-slide-to="<?=$k?>" class="<?= $k==0 ? "active" : "" ?>"></li>
                            <?php endforeach; ?>
                            </ol>

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
                                <div class="carousel-caption">
                                    <h3 style="text-shadow: #0f0f0f"><?=$machine['short_name_ru']?></h3>
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
</div>

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
                    <th>№</th><th>Наименование</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ( $weBuy as $d => $itemMachine ): ?>
                    <tr>
                        <td><?= $d++;?></td><td><?php echo $itemMachine['name_ru']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div><!--container-->
</div><!--projects-->

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
            <form id="send_mail_form" method="post" action="">
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="form-group col-md-12 connm">
                            <label>Ваше Имя <span id="nameValid">*</span></label>
                            <input type="text" class="form-control" size="40" value="" name="your-name" id="your-name">
                        </div>

                        <div class="form-group col-md-12 conem">
                            <label>Ваш Email <span id="emailValid">*</span></label>
                            <input type="email" class="form-control" size="40" value="" name="your-email" id="your-email">
                        </div>

                        <div class="form-group col-md-12 conem">
                            <label>Тема <span id="subjectValid">*</span></label>
                            <input type="text" class="form-control" size="40" value="" name="your-subject" id="your-subject">
                        </div>
                    </div><!--row-->
                </div><!--col-md-6-->
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="form-group col-md-12 conmm">
                            <label>Сообщение <span id="messageValid">*</span></label>
                            <textarea class="form-control" rows="10" cols="40" name="your-message" id="your-message"></textarea>
                        </div>
                    </div><!--row-->
                </div><!--col6-->
                <div class="clearfix"></div>
                <?php
                $sended = $_GET['sended'];

                if ( !isset( $sended ) ) {
                    ?>
                    <div class="col-md-12 text-center"><input type="button" class="subbtn" value="Отправить" onclick="validall(this);"></div>
                    <?php
                }
                if ( $sended == 1 ) {
                    ?>
                    <div class="col-md-12 text-center">
                        <div class="alert alert-info" role="alert">
                            <a href="#contact" type="button" class="close"><span class="glyphicon glyphicon-remove"></span></a>
                            <h4 class="alert-link">
                                Сообщение отправлено. В ближайшее время мы свяжемся с Вами!
                            </h4>
                        </div>
                    </div>
                    <?php
                }
                if ( $sended == -1 ) {
                    ?>
                    <div class="col-md-12 text-center">
                        <div class="alert alert-danger" role="alert">
                            <a href="#contact" type="button" class="close"><span class="glyphicon glyphicon-remove"></span></a>
                            <h4 class="alert-link">
                                При отправке сообщения произошла ошибка!
                            </h4>
                        </div>
                    </div>
                <?php } ?>
            </form>

        </div><!--row-->
    </div><!--container-->
</div><!--contact-->
