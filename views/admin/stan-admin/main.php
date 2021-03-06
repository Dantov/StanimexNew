<?php
use yii\helpers\Url;
/* @var $uniqueUsers integer */
/* @var $totalViews integer  */
/* @var $topMachine integer  */
/* @var $ordersCount integer  */

?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
</ol>
<!--agileinfo-grap-->
<div class="agileinfo-grap">
    <div class="agileits-box">
        <header class="agileits-box-header clearfix">
            <h3>Статистика за сутки</h3>
            <div class="toolbar"></div>
        </header>
        <div class="agileits-box-body clearfix">
        </div>
    </div>
</div>

<!--four-grids here-->
<div class="four-grids">
    <div class="col-md-3 four-grid">
        <div class="four-agileits">
            <div class="icon">
                <i class="glyphicon glyphicon-user" aria-hidden="true"></i>
            </div>
            <div class="four-text">
                <h3>Уникальных Поситителей</h3>
                <h4><?= $uniqueUsers ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 four-grid">
        <div class="four-agileinfo">
            <div class="icon">
                <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
            </div>
            <div class="four-text">
                <h3>Всего Просмотров</h3>
                <h4><?= $totalViews ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 four-grid">
        <div class="four-w3ls">
            <div class="icon">
                <i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
            </div>
            <div class="four-text">
                <h3>Топ Позиция</h3>
                <h4>
                    <a href="<?=Url::to('/machine/'. $topMachine['id'])?>" title="Просмотр"><?=$topMachine['short_name_ru']??$topMachine['short_name_en']??"" ?></a>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 four-grid">
        <div class="four-agileinfo">
            <div class="icon">
                <i class="glyphicon glyphicon-duplicate" aria-hidden="true"></i>
            </div>
            <div class="four-text">
                <h3>Заказов</h3>
                <h4><?= $ordersCount ?></h4>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!--//four-grids here-->
<h1></h1>