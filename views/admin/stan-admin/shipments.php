<?php
    use dtw\HtmlHelper;
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/almadmin">Admin</a><i class="fa fa-angle-right"></i>Our Shipments</li>
</ol>

<div class="validation-form">
    <p id="topName" class="text-warning" align="center">Редактировать: <strong>Our Shipments</strong></p>
    <?php if ( $this->session->hasFlash('no_upd') ): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$this->session->getFlash('no_upd');?> </strong>
        </div>
    <?php endif; ?>
    <?php if ( $this->session->hasFlash('success_upd') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$this->session->getFlash('success_upd');?> </strong>
        </div>
    <?php endif; ?>
    <?php if ( $this->session->hasFlash('success_add') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong> <?=$this->session->getFlash('success_add');?> </strong>
        </div>
    <?php endif; ?>
<div class="agile3-grids">
    <div class="gallery-grids">
        <?php $form = HtmlHelper::beginForm( HtmlHelper::URL('/almadmin/shipments/edit/1'), ['method'=>'POST','id'=>'griid','enctype'=>'multipart/form-data'] ); ?>
        <?php for ($i = 0; $i < count($shipments); $i++): ?>
        <div class="col-md-3 gallery-grids-left">
            <div class="gallery-grid shippments_grid">
                <img src="<?=HtmlHelper::URL('views/images/shipments/'.$shipments[$i]->img)?>" alt="">
                <a class="btn btn-danger btn-rem" role="button" title="Убрать" onclick="removePosfromServ(this,<?=$shipments[$i]->id?>)">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
                <?= $form->field($formShipments, 'descr')->input('text',['name'=>'shipments[descr][]','class'=>'control-label shipmentsInpt','placeholder'=>'Description','value'=>$shipments[$i]->descr]) ?>
                <?= $form->field($formShipments, 'id')->input('text',['name'=>'shipments[id][]','type'=>'hidden','value'=>$shipments[$i]->id]) ?>
            </div>
        </div>
        <?php endfor; ?>
        <div class="col-md-3 gallery-grids-left" id="insBef">
            <a class="btn" role="button" title="Add Image" id="add_img" style="margin-top:20px;">
                <img src="<?=HtmlHelper::URL('/views/images/uploadImg.png')?>" width="50px">
            </a>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-12 gallery-grids-left">
            <?= $form->field($formShipments)->submitButton(['value'=>'Save','class'=>'btn btn-primary']) ?>
        </div>
        <?php HtmlHelper::endForm(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>

<div class="col-md-3 gallery-grids-left protorow hidden">
    <input type="file" class="hidden" name="" accept="image/jpeg,image/png">
    <div class="gallery-grid shippments_grid">
        <img src="" alt="">
        <a class="btn btn-danger btn-rem" role="button" title="Убрать" onclick="removePos(this)">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
        <input type="text" name="" class="control-label shipmentsInpt" placeholder="Description" value="">
    </div>
</div>

<script src="<?=_rootDIR_HTTP_?>/modules/almadmin/views/js/shipments.js?ver=<?=time()?>"></script>