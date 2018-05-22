<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Profile</span></li>
        </ul>
    </div>
    <h3 class="page-title">Employee Details</h3>
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
                'action' => Yii::app()->createUrl('//core/employee/updateprofile/id/' . $model->employeeid),
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                ),
            ));
            /**
             * profile page is used for view and edit details of logged in employee.
             */
            ?>
            <div class="col-md-12">
                <div class="profile-sidebar">
                    <div class="portlet light profile-sidebar-portlet ">
                        <div class="profile-userpic">
                            <?php
                            $photo = $model->employee_photo;
                            if ($photo != "") {
                                ?>
                                <img alt="" class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/banner/<?php echo $photo; ?>">
                            <?php } else { ?>
                                <img alt="" class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/images/placeholder.jpg">
                            <?php  } ?>
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"><?php echo $model->employee_firstname." ".$model->employee_middlename." ".$model->employee_lastname;; ?> </div>
                            <!--<div class="profile-usertitle-name"> <?php // echo $model->employee_email; ?> </div>-->
                        </div>
                    </div>
                </div>
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Profile</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <form action="#" role="form">
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input_name" class="req">Employee Code</label>
                                                <?php
                                                /**
                                                 *  Text field for employeecode. 
                                                 * If it set to be auto generated at the time of registartion, then the code will be displayed in text field
                                                 */
                                                echo $form->textField($model, 'employee_code', array('size' => 84, 'maxlength' => 45, 'class' => "form-control",'readonly'=>true));
                                                echo $form->error($model, 'employee_code', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="reg_input_name" class="req">Joining Date</label>
                                                <div data-date-format="dd-mm-yyyy" class="input-group date ebro_datepicker">
                                                    <?php
                                                    //! Calendar to select the joining date of employee.
                                                   echo $form->textField($model, 'employee_joiningdate', array('placeholder' => 'Joining Date', 'class' => "form-control date-picker",'disabled'=>'disabled'));
                                                    echo $form->error($model, 'employee_joiningdate', array('class' => 'school_val_error'));
                                                    ?>
                                                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="reg_input" class="req">Department</label>
                                                <?php
                                                //! Dropdownlist to select department
                                                $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'departmentid', 'department_name'); //! < $department to store department details
                                                echo CHtml::activeDropDownList($model, 'departmentid', $department, array('empty' => 'Select Option', 'class' => "form-control",'disabled'=>'disabled',
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
                                                if(isset($model->departmentid)){
                                                 $division = CHtml::listData(Division::model()->findAll('departmentid=' . $model->departmentid), 'divisionid', 'division_name'); //! < $division to store division details  
                                                }else{
                                                  $division = CHtml::listData(Division::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'divisionid', 'division_name'); //! < $division to store division details  
                                                 }
                                                //! Dropdownlist to select division
                                                echo CHtml::activeDropDownList($model, 'divisionid',$division, array('empty' => 'Select Option', 'class' => "form-control",'disabled'=>'disabled'));
                                                echo $form->error($model, 'divisionid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="reg_input_name" class="req">Designation</label>
                                                <div id="batch_div">

                                                    <?php
                                                    //! Dropdownlist to select designation
                                                    $designation = CHtml::listData(Designation::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'designationid', 'designation_name'); //! < $designation to store designation details
                                                    echo CHtml::activeDropDownList($model, 'designationid', $designation, array('empty' => 'Select Option', 'class' => "form-control",'disabled'=>'disabled'));
                                                    echo $form->error($model, 'designationid', array('class' => 'school_val_error'));
                                                    ?>
                                                </div>
                                            </div>
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
                                                echo CHtml::activeDropDownList($model, 'usertypeid', $usertype, array('empty' => 'Select Option', 'class' => "form-control",'disabled'=>'disabled'));
                                                echo $form->error($model, 'usertypeid', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
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
                                            <div class="form-group col-sm-6">
                                                <label for="Country">Country</label>
                                                <?php
                                                //! Dropdown list to select the country of employee
                                                echo $form->textField($model, 'employee_country', array('class' => 'form-control'));
                                                echo $form->error($model, 'employee_country', array('class' => 'school_val_error'));
                                                ?>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="Country">State</label>
                                                <?php
                                                //! Dropdown list to select the state of employee
                                                echo $form->textField($model, 'employee_state', array('class' => 'form-control'));
                                                echo $form->error($model, 'employee_state', array('class' => 'school_val_error'));
                                                ?>                                        
                                            </div>
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
                                           <div class="form-group col-sm-12" align="left">
                                                <button class="btn green" type="submit">Save Changes</button>
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