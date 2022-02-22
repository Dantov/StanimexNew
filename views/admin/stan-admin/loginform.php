<?php
use dtw\HtmlHelper;
?>

<div class="main-wthree">
    <div class="container">
        <div class="sin-w3-agile">
            <h2>Sign In</h2>
            <form action="<?= HtmlHelper::URL('/almadmin/loginForm') ?>" method="post">
                <div class="username">
                        <span class="username">Username:</span>
                        <input type="text" name="users[login]" class="name" placeholder="" required="" value="<?=$this->session->getFlash('login')?>">
                        <div class="clearfix"></div>
                </div>
                <?php if ( $this->session->hasFlash('error-login') ): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong> <?=$this->session->getFlash('error-login');?> </strong>
                    </div>
                <?php endif; ?>
                <div class="password-agileits">
                        <span class="username">Password:</span>
                        <input type="password" name="users[password]" class="password" placeholder="" required="" value="<?=$this->session->getFlash('password')?>">
                        <div class="clearfix"></div>
                </div>
                <?php if ( $this->session->hasFlash('error-password') ): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong> <?=$this->session->getFlash('error-password');?> </strong>
                    </div>
                <?php endif; ?>
                <div class="login-w3">
                    <input type="submit" class="login" value="Sign In">
                </div>
                <div class="clearfix"></div>
            </form>
            <div class="back">
                <?php HtmlHelper::a('Back to home','/home') ?>
            </div>
        </div>
    </div>
</div>
