<div class="page-content" style="min-height:1683px">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/country.js"></script>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Add Employee</span></li>
        </ul>
    </div>
    <h3 class="page-title">Employee Details</h3>
    <div class="row">
        <div class="col-md-12">
            <?php
            Yii::app()->clientScript->registerCoreScript('jquery');
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'employee-form',
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
             * _form is used to enter the financial year details
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
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="reg_input_name" class="req">Employee Code</label>
                        <?php
                        /**
                         *  Text field for employeecode. 
                         * If it set to be auto generated at the time of registartion, then the code will be displayed in text field
                         */
                        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                        $companyid = Yii::app()->user->companyid; //* <$companyid for storing institution id of the logged in user
                        $company = Company::model()->findByPk($companyid);
//                        if ($company->isautogeneration === '1') {//! < Checking whther the code is autogeneration or not. If employee code is autogeneration, then,
                        $employee = Employee::model()->findAllByAttributes(array('companyid' => $companyid)); //! <$employee to store employee details
                        $employeecount = count($employee) + 1; //! <$employeecount to get the serial number
                        $constantval = '100';
                        $number = $constantval + $employeecount;
                        $model->employee_code = 'e' . $company->company_code . $number;

                        echo $form->textField($model, 'employee_code', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
//                        }
//                        if ($company->isautogeneration === '0') {//! Other wise displayed a blank textfield
//                            echo $form->textField($model, 'employee_code', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
//                        }
                        echo $form->error($model, 'employee_code', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="reg_input_name" class="req">Joining Date</label>
                        <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                            <?php
                            $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                            $date = new DateTime();
                            $date->setTimezone($timezone);
                            $date = $date->format('Y-m-d');
                            //! Calendar to select the joining date of employee.
                            echo $form->textField($model, 'employee_joiningdate', array('placeholder' => 'Joining Date', 'class' => "form-control date-picker", 'value' => $date));
                            echo $form->error($model, 'employee_joiningdate', array('class' => 'school_val_error'));
                            ?>
                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="reg_input" class="req">Department</label>
                        <?php
                        //! Dropdownlist to select department
                       $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'departmentid', 'department_name'); //! < $department to store department details
                        echo CHtml::activeDropDownList($model, 'departmentid', $department, array('empty' => 'Select Option', 'class' => "form-control",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('employee/Fetchdivision'),
                                'update' => '#' . CHtml::activeId($model, 'divisionid'))));
                        echo $form->error($model, 'departmentid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="reg_input" class="req">Division</label>
                        <?php
                        //! Dropdownlist to select division
                        echo CHtml::activeDropDownList($model, 'divisionid', array(), array('empty' => 'Select Option', 'class' => "form-control"));
                        echo $form->error($model, 'divisionid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" class="req">Designation</label>
                        <div id="batch_div">

                            <?php
                            //! Dropdownlist to select designation
                            $designation = CHtml::listData(Designation::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'designationid', 'designation_name'); //! < $designation to store designation details
                            echo CHtml::activeDropDownList($model, 'designationid', $designation, array('empty' => 'Select Option', 'class' => "form-control"));
                            echo $form->error($model, 'designationid', array('class' => 'school_val_error'));
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" class="req">Qualification</label>
                        <?php
                        //! Textfield to enter the qualification details
                        echo $form->textField($model, 'employee_qualification', array('class' => "form-control"));
                        echo $form->error($model, 'employee_qualification', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" class="req">Total Experience</label>
                        <?php
                        //! Textfield to enter the experience details
                        echo $form->textField($model, 'employee_totalexperiance', array('class' => "form-control"));
                        echo $form->error($model, 'employee_totalexperiance', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="usertype" class="req">User Type</label>
                        <?php
                        //! Dropdown list to slect the usertype
                        $usertype = CHtml::listData(Usertype::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'usertypeid', 'usertype_name');
                        echo CHtml::activeDropDownList($model, 'usertypeid', $usertype, array('empty' => 'Select Option', 'class' => "form-control", 'data-required' => "true"));
                        echo $form->error($model, 'usertypeid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" class="req">First Name </label>
                        <?php
                        //! Text field to enter first name
                        echo $form->textField($model, 'employee_firstname', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
                        echo $form->error($model, 'employee_firstname', array('class' => 'school_val_error'));
                        ?>                
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" >Middle Name </label>
                        <?php
                        //! Text field to enter middle name
                        echo $form->textField($model, 'employee_middlename', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
                        echo $form->error($model, 'employee_middlename', array('class' => 'school_val_error'));
                        ?>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="reg_input_name">Last Name</label>
                        <?php
                        //! Text field to enter last name
                        echo $form->textField($model, 'employee_lastname', array('size' => 84, 'maxlength' => 45, 'class' => "form-control"));
                        echo $form->error($model, 'employee_lastname', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="reg_input_name" class="req">Date of Birth</label>
                        <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                            <?php
                            //! Calendar to select the date of birth
                            echo $form->textField($model, 'employee_dob', array('placeholder' => 'Date of Birth', 'class' => "form-control date-picker"));
                            echo $form->error($model, 'employee_dob', array('class' => 'school_val_error'));
                            ?>
                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="Gender" class="req">Gender</label>
                        <?php
                        //! Dropdown list to select the gender of the employee
                        echo CHtml::activeDropDownList($model, 'employee_gender', array('' => 'Please select', '1' => 'Male', '2' => 'Female'), array('class' => "form-control", 'data-required' => "true"));
                        echo $form->error($model, 'employee_gender', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form_group col-sm-6">
                        <label for="reg_input_name">Present Address</label>
                        <?php
                        //! Text area to enter present address of employee
                        echo $form->textArea($model, 'employee_address1', array('class' => "form-control"));
                        echo $form->error($model, 'employee_address1', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="reg_input_name" class="req">Permanent Address</label>
                        <?php
                        //! Text area to enter permanent address of employee
                        echo $form->textArea($model, 'employee_address2', array('class' => "form-control"));
                        echo $form->error($model, 'employee_address2', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="reg_input_currency">City</label>
                        <?php
                        //! Text field to enter the city of employee
                        echo $form->textField($model, 'employee_city', array('class' => "form-control"));
                        echo $form->error($model, 'employee_city', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="reg_input_currency">Pin</label>
                        <?php
                        //! Text field to enter the pincode of employee
                        echo $form->textField($model, 'employee_pincode', array('class' => "form-control"));
                        echo $form->error($model, 'employee_pincode', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="Country">Country</label>
                        <?php
                        //! Dropdown list to select the country of employee
                        echo $form->dropDownList($model, 'employee_country', array('empty' => 'Please select'), array('class' => 'form-control'));
                        echo $form->error($model, 'employee_country', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="Country">State</label>
                        <?php
                        //! Dropdown list to select the state of employee
                        echo $form->dropDownList($model, 'employee_state', array('' => 'Please select'), array('class' => 'form-control'));
                        echo $form->error($model, 'employee_state', array('class' => 'school_val_error'));
                        ?>                                        
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="reg_input_currency">Phone</label>
                        <?php
                        //! Text field to enter the phone number of employee
                        echo $form->textField($model, 'employee_phone', array('class' => "form-control"));
                        echo $form->error($model, 'employee_phone', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="reg_input_currency" class="req">Mobile</label>
                        <?php
                        //! Text field to enter the mobile number of employee
                        echo $form->textField($model, 'employee_mobile', array('class' => "form-control"));
                        echo $form->error($model, 'employee_mobile', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="reg_input_currency" class="req">Email</label>
                        <?php
                        //! Text field to enter the email of employee
                        echo $form->textField($model, 'employee_email', array('class' => "form-control"));
                        echo $form->error($model, 'employee_email', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="reg_input_logo" >Upload Photo</label>
                        <?php
                        //! Button to upload photo of the employee
                        echo CHtml::activeFileField($model, 'employee_photo');
                        echo $form->error($model, 'employee_photo', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
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
    </div>
    <script>
        populateCountries("Employee_employee_country", "Employee_employee_state");
    </script>
</div>
