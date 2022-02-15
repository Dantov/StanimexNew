<?php

$session = yii::$app->session;
?>
<div class="machineTopBg"></div>
<div class="clearfix"></div>

<div class="contact">
    <div class="container">
        <br />
        <br />
        <br />
        <br />
        <form id="login_form" method="post" action="/stan-admin/login">
            <div class="row">

                <div class="col-sm-2"></div>

                <div class="col-sm-8">
                    <div class="form-group col-md-12 connm">
                        <label>Login: </label>
                        <?php if ( $session->hasFlash('loginError') ): ?>
                            <strong style="color: red;"><?= $session->getFlash('loginError') ?></strong>
                        <?php endif;?>
                        <input type="text" class="form-control" size="40" value="" name="login">
                    </div>

                    <div class="form-group col-md-12 conem">
                        <label>Pass:</label>
                        <?php if ( $session->hasFlash('passwordError') ): ?>
                            <strong style="color: red;"><?= $session->getFlash('passwordError') ?></strong>
                        <?php endif;?>
                        <input type="password" class="form-control" size="40" value="" name="password">
                    </div>
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                </div>

                <div class="col-sm-2"></div>

                <div class="clearfix"></div>

                <div class="col-md-12 text-center">
                    <input type="submit" class="subbtn" value="Вход">
                </div>
            </div>
        </form>
    </div>
</div>