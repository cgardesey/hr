<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Job Details</span></li>
        </ul>
    </div>
    <h3 class="page-title">Job Details</h3>
    <div class="row">
        <div class="col-md-12">
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?php
                    echo Yii::app()->user->getFlash('success');
                    Yii::app()->clientScript->registerScript(
                            'myHideEffect', '$(".alert alert-success").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                    );
                    ?>
                </div>
            <?php endif; ?>
            <?php
            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
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
            ));
            /**
             * _form is used to enter the company details
             */
            ?>
            <div class="col-md-12">
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">View Job Details</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <form action="#" role="form">
                                            <div class="form-group col-sm-6">
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
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input" class="req">Work Shift</label>
                                                <?php
                                                //! Dropdown list to select workshift

                                                $workshit = CHtml::listData(Workshift::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'workshiftid', 'workshift_name');

                                                echo $form->dropDownList($model, 'workshiftid', $workshit, array('prompt' => 'Please Select', 'class' => "form-control"));
                                                echo $form->error($model, 'workshiftid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input" class="req">Job Category</label>
                                                <?php
                                                //! Dropdown list to select job category

                                                $jobcate = CHtml::listData(Jobcategory::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'jobcategoryid', 'jobcategory_name');

                                                echo $form->dropDownList($model, 'jobcategoryid', $jobcate, array('prompt' => 'Please Select', 'class' => "form-control"));
                                                echo $form->error($model, 'jobcategoryid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input" class="req">Job Title</label>
                                                <?php
                                                //! Dropdown list to select job title
                                                $jobtitle = CHtml::listData(Jobtitle::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'jobtitleid', 'jobtitle_title');
                                                echo $form->dropDownList($model, 'jobtitleid', $jobtitle, array('prompt' => 'Please Select', 'class' => "form-control"));
                                                echo $form->error($model, 'jobtitleid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input">Sub Unit</label>
                                                <?php
                                                //! text field to enter sub unit
                                                echo $form->textField($model, 'jobdetails_subunit', array('class' => "form-control"));
                                                echo $form->error($model, 'jobdetails_subunit', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input">Location</label>
                                                <?php
                                                //! text field to enter location
                                                echo $form->textField($model, 'jobdetails_location', array('class' => "form-control"));
                                                echo $form->error($model, 'jobdetails_location', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input" class="req">Employment Status</label>
                                                <?php
                                                //! Dropdown list to select Employment Status
                                                $empstat = CHtml::listData(Employementstatus::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'employementstatusid', 'employementstatus_name');
                                                echo $form->dropDownList($model, 'employementstatusid', $empstat, array('prompt' => 'Please Select', 'class' => "form-control"));
                                                echo $form->error($model, 'employementstatusid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
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
                            <div class="form-group col-sm-6">
                                <label for="reg_input">Description</label>
                                <?php
                                //! text field to enter Description
                                echo $form->textArea($model, 'contract_description', array('class' => "form-control"));
                                echo $form->error($model, 'contract_description', array('class' => 'school_val_error'));
                                ?>
                            </div>
                                            <div class="form-group col-sm-6">
                                <label for="reg_input">Specification</label>
                                <?php
                                //! text field to enter Description
                                echo CHtml::link($model->job_specification, Yii::app()->request->baseUrl . '/banner/' . $model->job_specification);
                                echo $form->error($model, 'job_specification', array('class' => 'school_val_error'));
                                ?>
                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
    populateCountries("Company_company_country");
    populateCountries("Company_company_country", "Company_company_state");
</script>