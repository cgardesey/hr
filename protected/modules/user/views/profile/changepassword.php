<!--
// Copyright (c) 2015 All Right Reserved, https://web-school.in
//
// This source is subject to the Gescis License.
// All other rights reserved.
//
// THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
// KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
// IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
// PARTICULAR PURPOSE.

@(#)Project:        					Human Flow
@(#)Version:        					v1.0
@(#)Initial Development Completion:                     Date: 2016-06-26
@(#)Developers:     					 Arya K Nair,Prathibha Mohan V
@(#)Copyright:      					(C) Gescis Technologies, Technopark
@(#)Product:        					Human Flow.
@(#)Template:        					Multiple templates developed by Gescis.
-->
<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Change Password</span></li>
        </ul>
    </div>
    <h3 class="page-title">Change Password</h3>
    <div class="row">
        <div class="col-md-12">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'changepassword-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel-body">
                        <?php if (Yii::app()->user->hasFlash('profileMessage')): ?>
                            <div class="alert alert-success">
                                <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
                                <?php
                                Yii::app()->clientScript->registerScript(
                                        'myHideEffect', '$(".alert alert-success").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                );
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <?php echo $form->label($model, 'oldPassword', array('class' => 'req')); ?>
                            <?php echo $form->passwordField($model, 'oldPassword', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'oldPassword', array('class' => 'school_val_error')); ?>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($model, 'password', array('class' => 'req')); ?>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'password', array('class' => 'school_val_error')); ?>
<!--                                    <p class="hint">
                            <?php // echo UserModule::t("Minimal password length 4 symbols."); ?>
                            </p>-->
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($model, 'verifyPassword', array('class' => 'req')); ?>
                            <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'verifyPassword', array('class' => 'school_val_error')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form_sep">
                                <?php // echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'btn btn-info')); 
                                echo CHtml::submitButton('Change', array('class' => "btn green"));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<?php $this->endWidget(); ?>
    </div>
</div>