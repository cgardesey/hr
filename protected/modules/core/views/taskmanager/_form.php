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
            <li><span>Task Manager</span><i class="fa fa-circle"></i></li>
            <li><span>Assign Task</span></li>
        </ul>
    </div>
    <h3 class="page-title">Assign Task</h3>
    <div class="row">
        <div class="col-md-12">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'taskmanager-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnChange' => true,
                    'validateOnSubmit' => true,
                ),
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => true,
            ));
            //! Assign Task
            ?>
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-sm-12">

                                <div class="panel-body">
                                    <?php if (Yii::app()->user->hasFlash('error')): ?>
                                        <div class="alert alert-danger">
                                            <?php echo Yii::app()->user->getFlash('error'); ?>
                                            <?php
                                            Yii::app()->clientScript->registerScript(
                                                    'myHideEffect', '$(".alert alert-danger").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                            );
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->hasFlash('success')): ?>
                                        <div class="alert alert-success">
                                            <?php echo Yii::app()->user->getFlash('success'); ?>
                                            <?php
                                            Yii::app()->clientScript->registerScript(
                                                    'myHideEffect', '$(".alert alert-success").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                            );
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">Task</label>
                                        <?php
                                        //! Textfield to enter task heading
                                        echo $form->textField($model, 'task_heading', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
                                        echo $form->error($model, 'task_heading', array('class' => 'school_val_error'));
                                        ?>                
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">Description</label>
                                        <?php
                                        //! Text field to enter task description
                                        echo $form->textArea($model, 'task_description', array('class' => "form-control"));
                                        echo $form->error($model, 'task_description', array('class' => 'school_val_error'));
                                        ?>                
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">Priority</label>
                                        <?php
                                        //! Text field to enter task priority
                                        echo CHtml::activeDropDownList($model, 'task_priority', array('1' => 'Highest Priority', '2' => 'High Priority',
                                            '3' => 'Normal Priority', '4' => 'Low Priority'), array('prompt' => 'Select Priority', 'class' => "form-control"));
                                        echo $form->error($model, 'task_priority', array('class' => 'school_val_error'));
                                        ?>                
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">Task Date</label>
                                        <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                                            <?php
                                            //! Calendar to select the date of birth
                                            echo $form->textField($model, 'task_date', array('placeholder' => 'Task Date', 'class' => "form-control date-picker"));
                                            echo $form->error($model, 'task_date', array('class' => 'school_val_error'));
                                            ?>
                                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">User Type</label>
                                        <?php
                                        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                                        //! Text field to select usertype
                                        $usertype = CHtml::listData(Usertype::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'usertypeid', 'usertype_name');
                                        echo CHtml::activeDropDownList($model, 'usertypeid', $usertype, array('prompt' => 'Select User Type', 'class' => "form-control",
                                            'ajax' => array(
                                                'type' => 'POST',
                                                'url' => CController::createUrl('taskmanager/Fetchemployee'),
                                                'update' => '#' . CHtml::activeId($model, 'userid'))));
                                        echo $form->error($model, 'usertypeid', array('class' => 'school_val_error'));
                                        ?>                
                                    </div>
                                    <div class="form-group" id="employee">
                                        <label for="reg_input" class="req">Employee (Press Ctrl to select more than one employee)</label>
                                        <?php
                                        //! Dropdown list to select employee name
                                        echo CHtml::activeDropDownList($model, 'userid', array(), array('class' => "form-control",
                                            'multiple' => 'multiple', 'size' => '10'));
                                        echo $form->error($model, 'userid', array('class' => 'school_val_error'));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name" class="req">Status</label>
                                        <?php
                                        //! Text field to enter task status
                                        echo CHtml::activeDropDownList($model, 'task_status', array('1' => 'Open', '2' => 'On hold',
                                            '3' => 'Resolved', '4' => 'Closed'), array('prompt' => 'Select Status', 'class' => "form-control"));
                                        echo $form->error($model, 'task_status', array('class' => 'school_val_error'));
                                        ?>                
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form_sep">
                                        <?php
                                        echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => "btn green"));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

