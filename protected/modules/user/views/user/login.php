<?php
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
$this->breadcrumbs = array(
    UserModule::t("Login"),
);
?>
<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>
<?php endif; ?>
<?php echo CHtml::beginForm(); ?>
<h3 class="form-title">Login to your account</h3>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span> Enter any username and password. </span>
</div>
<div class="form-group">
    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
    <label class="control-label visible-ie8 visible-ie9">Username</label>
    <div class="input-icon">
        <i class="fa fa-user"></i>
        <!--<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" />--> 
        <?php echo CHtml::activeTextField($model, 'username', array("class" => "form-control placeholder-no-fix", 'placeholder' => "Username")) ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label visible-ie8 visible-ie9">Password</label>
    <div class="input-icon">
        <i class="fa fa-lock"></i>
        <!--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />--> 
        <?php echo CHtml::activePasswordField($model, 'password', array("class" => "form-control placeholder-no-fix", 'placeholder' => "Password")) ?>
    </div>
</div><br>
<div class="form-group">
    <!--<button type="submit" class="btn green pull-right"> Login </button>-->
    <?php echo CHtml::submitButton(UserModule::t("Login "), array('class' => 'btn green pull-right')); ?>
</div>
<div class="text-danger"><?php echo CHtml::errorSummary($model); ?></div>
<?php echo CHtml::endForm(); ?><br><br><br>
<?php
$form = new CForm(array(
    'elements' => array(
        'username' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',
        )
    ),
    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
    ),
        ), $model);
?>
<script>
//   document.onkeypress = keyPress;
//
//function keyPress(e){
//  var x = e || window.event;
//  var key = (x.keyCode || x.which);
//    if(key == 13 || key == 3){
//     //  myFunc1();
//     document.Login.submit();
//    }
//    }
</script>