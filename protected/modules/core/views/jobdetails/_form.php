<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Employee Transfer</span></li>
        </ul>
    </div>
    <h3 class="page-title">Employee Transfer</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                Yii::app()->clientScript->registerCoreScript('jquery');
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'jobdetails-form',
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnChange' => true,
                        'validateOnSubmit' => true,
                    ),
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => true,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    ),
                ));
                /**
                 * _form is used to enter the job details
                 */
                ?>
                <div class="panel panel-default">
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
                        <div class="form-group">
                            <label for="reg_input_name" class="req">Department Name </label>
                            <?php
                            //! Dropdown list to select name of the department
                            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                            $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'departmentid', 'department_name'); //! < $department to store department details
                            echo CHtml::activeDropDownList($model, 'departmentid', $department, array('empty' => 'Please Select', 'class' => "form-control",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('jobdetails/Fetchemployee'),
                                    'update' => '#' . CHtml::activeId($model, 'employeeid'))));
                            echo $form->error($model, 'departmentid', array('class' => 'school_val_error'));
                            ?>              
                        </div>
                        <div class="form-group">
                            <label for="reg_input" class="req">Employee Name</label>
                            <?php
                            //! Dropdown list to select employee
                            if (isset($model->departmentid)) {
                                $employee = CHtml::listData(Employee::model()->findAll('departmentid=' . $model->departmentid), 'employeeid', 'employee_firstname'); //! < $employee to store employee details  
                            } else {
                                $employee = CHtml::listData(Employee::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'employeeid', 'employee_firstname'); //! < $employee to store employee details
                            }
                            echo $form->dropDownList($model, 'employeeid', $employee, array('prompt' => 'Please Select', 'class' => "form-control"));
                            echo $form->error($model, 'employeeid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input" class="req">Work Shift</label>
                            <?php
                            //! Dropdown list to select workshift

                            $workshit = CHtml::listData(Workshift::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'workshiftid', 'workshift_name');

                            echo $form->dropDownList($model, 'workshiftid', $workshit, array('prompt' => 'Please Select', 'class' => "form-control"));
                            echo $form->error($model, 'workshiftid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input" class="req">Promotion/Demotion Rank</label>
                            <?php
                            //! Dropdown list to select job category

                            $jobcate = CHtml::listData(Jobcategory::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'jobcategoryid', 'jobcategory_name');

                            echo $form->dropDownList($model, 'jobcategoryid', $jobcate, array('prompt' => 'Please Select', 'class' => "form-control"));
                            echo $form->error($model, 'jobcategoryid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input" class="req">Position Title</label>
                            <?php
                            //! Dropdown list to select job title
                            $jobtitle = CHtml::listData(Jobtitle::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'jobtitleid', 'jobtitle_title');
                            echo $form->dropDownList($model, 'jobtitleid', $jobtitle, array('prompt' => 'Please Select', 'class' => "form-control"));
                            echo $form->error($model, 'jobtitleid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input">Message to Employee</label>
                            <?php
                            //! text field to enter sub unit
                            echo $form->textField($model, 'jobdetails_subunit', array('class' => "form-control"));
                            echo $form->error($model, 'jobdetails_subunit', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input">Location</label>
                            <?php
                            //! text field to enter location
                            echo $form->textField($model, 'jobdetails_location', array('class' => "form-control"));
                            echo $form->error($model, 'jobdetails_location', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="reg_input" class="req">Employment Status</label>
                            <?php
                            //! Dropdown list to select Employment Status
                            $empstat = CHtml::listData(Employementstatus::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'employementstatusid', 'employementstatus_name');
                            echo $form->dropDownList($model, 'employementstatusid', $empstat, array('prompt' => 'Please Select', 'class' => "form-control"));
                            echo $form->error($model, 'employementstatusid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div id="contract" style="display:none">
                            <div class="form-group col-sm-6">
                                <label for="reg_input_name" class="req">Contract Start Date</label>
                                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                                    <?php
                                    //! Calendar to select the contract_startdate
                                    echo $form->textField($model, 'contract_startdate', array('placeholder' => 'Start Date', 'class' => "form-control date-picker"));
                                    echo $form->error($model, 'contract_startdate', array('class' => 'school_val_error'));
                                    ?>
                                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="reg_input_name" class="req">Contract End Date</label>
                                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                                    <?php
                                    //! Calendar to select the contract_enddate
                                    echo $form->textField($model, 'contract_enddate', array('placeholder' => 'End Date', 'class' => "form-control date-picker"));
                                    echo $form->error($model, 'contract_enddate', array('class' => 'school_val_error'));
                                    ?>
                                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="reg_input">Description</label>
                                <?php
                                //! text field to enter Description
                                echo $form->textArea($model, 'contract_description', array('class' => "form-control"));
                                echo $form->error($model, 'contract_description', array('class' => 'school_val_error'));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="reg_input_name">Specification</label>
                        <?php
                        //! Button to upload files
                        echo CHtml::activeFileField($model, 'jobtitle_specification');
                        echo $form->error($model, 'jobtitle_specification', array('class' => 'school_val_error'));
                        ?>
                    </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form_sep">
                                    <?php
                                    //! Submit button
                                    echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => "btn green", 'name' => "std_reg_submit", 'id' => "std_reg_submit",
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
                <?php $this->endWidget(); ?>
            </div>
            <div class="col-md-6">
                <?php
                //! Used to display all created values of designation details.
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $model->search(),
                    'id' => 'item-grid',
                    'selectableRows' => 1,
                    'ajaxUpdate' => false,
                    'hideHeader' => false,
                    'template' => "{items}\n{pager}",
                    'enableHistory' => false,
                    'enableSorting' => false,
                    'cssFile' => Yii::app()->baseUrl . '/css/grid.css',
                    'htmlOptions' => array('class' => 'grid-view table-responsive'),
                    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/grid.css',
                        'maxButtonCount' => 4,
                        'nextPageLabel' => '>',
                        'prevPageLabel' => '<',
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Sl.No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'htmlOptions' => array('width' => '5%'),
                        ),
                        array(
                            'name' => 'Employee',
                            'value' => '$data->employee->employee_code." -".$data->employee->employee_firstname." ".$data->employee->employee_middlename." ".$data->employee->employee_lastname',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array(
                            'name' => 'Job Category',
                            'value' => '$data->jobcategory->jobcategory_name',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array(
                            'name' => 'Work Shift',
                            'value' => '$data->workshift->workshift_name',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array('class' => 'CButtonColumn',
                            'header' => 'Manage',
                            'template' => '{view} {update} {delete}',
                            'htmlOptions' => array('width' => '5%'),
                            'buttons' => array(
                                 'view' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-eye-open'),
                                ),
                                'update' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-pencil'),
                                ),
                                'delete' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-remove'),
                                    'confirm' => 'Are you sure you want to delete this item?',
                                ),
                            ),
                        ),
                    ),
                ));
                ?> 

            </div>
        </div>
    </div>
</div>
<script>
    $('#Jobdetails_employementstatusid').change(function () {
        if ($('#Jobdetails_employementstatusid option:selected').val() === '1') {
            $('#contract').show("slow");
        } else if ($('#Jobdetails_employementstatusid option:selected').val() === '2') {
            $('#contract').show("slow");
        } else {
            $('#contract').hide("slow");
        }
    });
</script>