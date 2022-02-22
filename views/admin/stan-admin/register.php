<?php
use dtw\HtmlHelper;

$this->title = 'Регистрация';

?>
<br/>
<div class="row">
    <div class="col-xs-12 col-md-3">
        <br/>
    </div>
    <div class="col-xs-12 col-md-6">
        <h3>Регистрация</h3>
        <?php if ( $this->session->hasFlash('error-register') ): ?>
            <div class="alert alert-success" role="alert">
                <strong> <?=$this->session->getFlash('error-register');?> </strong>
            </div>
        <?php endif; ?>
        <?php $form = HtmlHelper::beginForm( HtmlHelper::URL('/admin/register')); ?>

        <?= $form->field($regForm, 'name') ->input('text',['class'=>'form-control','value'=>$this->session->getFlash('name')]) ?>
        <?php if ( $this->session->hasFlash('error-name') ): ?>
            <div class="alert alert-danger" role="alert">
                <strong> <?=$this->session->getFlash('error-name');?> </strong>
            </div>
        <?php endif; ?>

        <?= $form->field($regForm, 'login') ->input('text',['class'=>'form-control','value'=>$this->session->getFlash('login')]) ?>
        <?php if ( $this->session->hasFlash('error-login') ): ?>
            <div class="alert alert-danger" role="alert">
                <strong> <?=$this->session->getFlash('error-login');?> </strong>
            </div>
        <?php endif; ?>

        <?= $form->field($regForm, 'password')->input('password',['class'=>'form-control','minlength'=>6,'value'=>$this->session->getFlash('password')]) ?>
        <?php if ( $this->session->hasFlash('error-password') ): ?>
            <div class="alert alert-danger" role="alert">
                <strong> <?= $this->session->getFlash('error-password');?> </strong>
            </div>
        <?php endif; ?>

        <?= $form->field($regForm, 'email')->input('email',['class'=>'form-control','value'=>$this->session->getFlash('email')]) ?>
        <?php if ( $this->session->hasFlash('error-email') ): ?>
            <div class="alert alert-danger" role="alert">
                <strong> <?=$this->session->getFlash('error-email');?> </strong>
            </div>
        <?php endif; ?>

        <br/>
        <?= $form->field($regForm, 'submit')->submitButton(['class'=>'btn btn-info','value'=>'Зарегистрироваться']) ?>
        <?= $form->field($regForm, 'reset')->button(['class'=>'btn btn-danger pull-right','value'=>'Сбросить','type'=>'reset']) ?>
        <?php HtmlHelper::endForm(); ?>

        <br>
        <?php HtmlHelper::a('Взад','/base',['class'=>'btn btn-default']) ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <br/>
    </div>
</div>
<br/>

