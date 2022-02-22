<?php
    use dtw\HtmlHelper;
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Gallery</li>
</ol>

<div class="agile3-grids">
    <div class="gallery-grids">
        <div class="col-md-12 gallery-grids-left">
            <h2>Stock</h2>
        </div>
        <?php for ($i = 0; $i < count($stockFiles); $i++): ?>
        <div class="col-md-3 gallery-grids-left">
            <div class="gallery-grid shippments_grid">
                <img src="<?= HtmlHelper::URL('/views/images/stock/'.$stockFiles[$i]['name']) ?>" alt="">
                <a class="btn btn-danger btn-rem" role="button" title="Удалить изображение" onclick="removeImg(this,'<?=$stockFiles[$i]['name']?>','stock')">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
            <br>
        </div>
        <?php endfor; ?>
        <div class="col-md-12 gallery-grids-left">
            <h2>Shipments</h2>
        </div>
        <?php for ($i = 0; $i < count($shippFiles); $i++): ?>
        <div class="col-md-3 gallery-grids-left">
            <div class="gallery-grid shippments_grid">
                <img src="<?= HtmlHelper::URL('/views/images/shipments/'.$shippFiles[$i]['name']) ?>" alt="">
                <a class="btn btn-danger btn-rem" role="button" title="Удалить изображение" onclick="removeImg(this,'<?=$shippFiles[$i]['name']?>','shipment')">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
            <br>
        </div>
        <?php endfor; ?>
        <div class="clearfix"> </div>
    </div>
</div>

<script src="<?=_rootDIR_HTTP_?>/modules/almadmin/views/js/gallery.js?ver=<?=time()?>"></script>
