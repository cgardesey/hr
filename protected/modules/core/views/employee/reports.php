<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Reports</span></li>
        </ul>
    </div>
    <h3 class="page-title">Reports</h3>
    <div class="row">
        <div class="col-md-12">
            <?php
            Yii::app()->clientScript->registerCoreScript('jquery');
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'recruitment-form',
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
                    <div class="form-group col-sm-4">
                        <label for="reg_input_name" class="req">Report </label>
                        <?php
                        //! Text field to select report
                        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                        echo CHtml::activeDropDownList($model, 'report', array('1' => 'Department wise', '2' => 'Designation wise', '3' => 'Division wise', '4' => 'Usertype wise', '5' => 'Job Category', '6' => 'Status'), array('empty' => 'Please Select', 'class' => "form-control"));
                        ?>              
                    </div>
                    <div class="form-group col-sm-4" id="department" style="display:none">
                        <label for="reg_input_name" class="req">Department Name </label>
                        <?php
                        //! Dropdown list to select name of the department
                        $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'departmentid', 'department_name'); //! < $department to store department details
                        echo CHtml::activeDropDownList($model, 'departmentid', $department, array('empty' => 'Please Select', 'class' => "form-control",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('employee/Fetchdivision'),
                                'update' => '#' . CHtml::activeId($model, 'divisionid'))));
                        echo $form->error($model, 'departmentid', array('class' => 'school_val_error'));
                        ?>              
                    </div>
                    <div class="form-group col-sm-4" id="division" style="display:none">
                        <label for="reg_input" class="req">Division Name</label>
                        <?php
                        //! Dropdown list to select division
                        if (isset($model->departmentid)) {
                            $division = CHtml::listData(Division::model()->findAll('departmentid=' . $model->departmentid), 'divisionid', 'division_name'); //! < $division to store division details  
                        } else {
                            $division = array();
                        }
                        echo $form->dropDownList($model, 'divisionid', $division, array('prompt' => 'Please Select', 'class' => "form-control",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('employee/Fetchjobcategory'),
                                'update' => '#' . CHtml::activeId($model, 'jobcategoryid'))));
                        echo $form->error($model, 'divisionid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4" id="jobcategory" style="display:none">
                        <label for="reg_input" class="req">Job Category</label>
                        <?php
                        //! Dropdown list to select division
                        if (isset($model->divisionid)) {
                            $jobcat = CHtml::listData(Jobcategory::model()->findAll('divisionid=' . $model->divisionid), 'jobcategoryid', 'jobcategory_name'); //! < $jobcat to store job category details  
                        } else {
                            $jobcat = array();
                        }
                        echo $form->dropDownList($model, 'jobcategoryid', $jobcat, array('prompt' => 'Please Select', 'class' => "form-control",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('employee/Fetchdesignation'),
                                'update' => '#' . CHtml::activeId($model, 'designationid'))));
                        echo $form->error($model, 'jobcategoryid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4" id="designation" style="display:none">
                        <label for="reg_input" class="req">Designation Name</label>
                        <?php
                        //! Dropdown list to select designation
                        if (isset($model->jobcategoryid)) {
                            $design = CHtml::listData(Designation::model()->findAll('jobcategoryid=' . $model->jobcategoryid), 'designationid', 'designation_name');
                        } else {
                            $design = array();
                        }
                        echo $form->dropDownList($model, 'designationid', $design, array('prompt' => 'Please Select', 'class' => "form-control"));
                        echo $form->error($model, 'designationid', array('class' => 'school_val_error'));
                        ?>
                    </div>
                    <div class="form-group col-sm-4" id="usertype" style="display:none">
                        <label for="reg_input_name" class="req">User Type </label>
                        <?php
                        //! Dropdown list to select name of the user type
                        $usertype = CHtml::listData(Usertype::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'usertypeid', 'usertype_name'); //! < $usertype to store usertype details
                        echo CHtml::activeDropDownList($model, 'usertypeid', $usertype, array('empty' => 'Please Select', 'class' => "form-control"));
                        echo $form->error($model, 'usertypeid', array('class' => 'school_val_error'));
                        ?>              
                    </div>
                    <div class="form-group col-sm-4" id="status" style="display:none">
                        <label for="reg_input_name" class="req">Status </label>
                        <?php
                        //! Text field to select status
                        echo CHtml::activeDropDownList($model, 'employee_status', array('1' => 'Existing', '2' => 'Resigned', '3' => 'Terminated'), array('empty' => 'Please Select', 'class' => "form-control"));
                        ?>              
                    </div>
                    <div class="form-group col-sm-6">
                        <!--<label> &nbsp; &nbsp;</label>-->
                        <p> &nbsp;&nbsp;<a href="javascript:getreport()" class="btn green">Get Report</a> 
                         &nbsp;&nbsp;&nbsp;&nbsp;
                         <input type="button" onclick="printDiv('print')" value="Print Report" class="btn red"/>
                         &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:exportreport()" name="cyril" id="cyril" class="btn blue">Export Report</a>
                         </p>
                    </div>
                </div>
            </div> 
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="row" id="print">
        <div class="col-md-12" id="employeesreport">

        </div>
    </div>
        <?php
if(isset($_POST))
{

$_SESSION['object']   =  Yii::app();
//header('Location: ../../../export.php');
}
?>

</div>
<script>
    $(document).ready(function () {
        $('#Employee_report').change(function () {
            if ($('#Employee_report option:selected').val() == "1") { //! Department wise
                $('#status').hide("slow");
                $('#designation').hide("slow");
                $('#usertype').hide("slow");
                $('#division').hide("slow");
                $('#jobcategory').hide("slow");
                $('#department').show("slow");
            }
            if ($('#Employee_report option:selected').val() == "2") { //! Designation
                $('#status').hide("slow");
                $('#usertype').hide("slow");
                $('#department').show("slow");
                $('#division').show("slow");
                $('#jobcategory').show("slow");
                $('#designation').show("slow");
            }
            if ($('#Employee_report option:selected').val() == "3") { //! Division wise
                $('#jobcategory').hide("slow");
                $('#designation').hide("slow");
                $('#status').hide("slow");
                $('#usertype').hide("slow");
                $('#department').show("slow");
                $('#division').show("slow");
            }
            if ($('#Employee_report option:selected').val() == "4") { //! Usertype wise
                $('#jobcategory').hide("slow");
                $('#designation').hide("slow");
                $('#status').hide("slow");
                $('#department').hide("slow");
                $('#division').hide("slow");
                $('#usertype').show("slow");
            }
            if ($('#Employee_report option:selected').val() == "5") { //! Job category wise
                $('#usertype').hide("slow");
                $('#designation').hide("slow");
                $('#status').hide("slow");
                $('#department').show("slow");
                $('#division').show("slow");
                $('#jobcategory').show("slow");
            }
            if ($('#Employee_report option:selected').val() == "6") { //! status wise
                $('#usertype').hide("slow");
                $('#designation').hide("slow");
                $('#department').hide("slow");
                $('#division').hide("slow");
                $('#jobcategory').hide("slow");
                $('#status').show("slow");
            }
        })
    });
    function getreport(){
         $('#employeesreport').empty();
        $.ajax({
                type: "POST",
                url: "employeereport",
                data: {reportfor: $('#Employee_report option:selected').val(),
                    departmentid: $('#Employee_departmentid option:selected').val(),
                    divisionid: $('#Employee_divisionid option:selected').val(),
                    jobcategoryid: $('#Employee_jobcategoryid option:selected').val(),
                    designationid: $('#Employee_designationid option:selected').val(),
                    usertypeid: $('#Employee_usertypeid option:selected').val(),
                    status: $('#Employee_employee_status option:selected').val()},
                dataType: "html",
                success: function (data) {
                    $('#employeesreport').append(data);
                }
            });
    }

    function exportreport(){
         $('#employeesreport').empty();
        $.ajax({
                type: "POST",
                url: "../../../export.php",
                data : {reportfor: $('#Employee_report option:selected').val(),
                    departmentid: $('#Employee_departmentid option:selected').val(),
                    divisionid: $('#Employee_divisionid option:selected').val(),
                    jobcategoryid: $('#Employee_jobcategoryid option:selected').val(),
                    designationid: $('#Employee_designationid option:selected').val(),
                    usertypeid: $('#Employee_usertypeid option:selected').val(),
                    status: $('#Employee_employee_status option:selected').val()},
              dataType : "html",
                success: function (data) {
                   alert(data);
                window.location.href = "../../../export.php";
                }
            });

    }

     function printDiv(divName) {
        var divToPrint = document.getElementById(divName);
        var popupWin = window.open('', '', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">');
        popupWin.document.write('<link href="<?php echo Yii::app()->request->baseUrl ?>/css/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">');
        popupWin.document.write('<link href="<?php echo Yii::app()->request->baseUrl ?>/css/assets/global/css/components.min.css" rel="stylesheet" type="text/css">');
        popupWin.document.write(divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }
</script>