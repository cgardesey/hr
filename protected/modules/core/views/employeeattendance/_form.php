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
            <li><span>Attendance</span><i class="fa fa-circle"></i></li>
            <li><span>Attendance</span></li>
        </ul>
    </div>
    <h3 class="page-title">Attendance Details</h3>
    <div class="row">
        <div class="col-md-12">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'employeeattendance-form',
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnChange' => false,
                    'validateOnSubmit' => true,
                ),
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => true,
            ));
            /**
             *  Entering and viewing employee attendance 
             */
            ?>
            <div class="col-sm-12">
                <div class="portlet-title tabbable-line">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="active"><a href="#tbb_a" data-toggle="tab">Daily Attendance</a></li>
                        <li class=""><a href="#tbb_b" data-toggle="tab">View Attendance</a></li>
                    </ul> 
                </div>
                <?php
                /**
                 *  Employee attendance containg two tabs.
                 * First tab is used to enter attendance details.
                 */
                ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="tbb_a">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group col-sm-3" id="course">
                                            <label for="reg_input">Department</label>
                                            <?php
                                            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                                            //! Drop down menu to select the department
                                            $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'departmentid', 'department_name'); //! < $department to store all department detailsd
                                            echo CHtml::activeDropDownList($model, 'departmentid', $department, array(
                                                'empty' => 'Select Department', 'class' => "form-control"));
                                            echo $form->error($model, 'departmentid', array('class' => 'school_val_error'));
                                            ?>
                                        </div>  
                                        <div class="form-group col-sm-3" id="date">
                                            <label for="reg_input_name">Date </label>
                                            <?php
                                            //! Calendar to select the date
                                            $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                                            $date = new DateTime();
                                            $date->setTimezone($timezone);
                                            $date = $date->format('d-m-Y');
                                            echo $form->textField($model, 'date', array('placeholder' => 'Date', 'class' => "form-control", 'value' => $date, 'readonly' => 'true'));
                                            echo $form->error($model, 'date', array('class' => 'school_val_error'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                        <div class="alert alert-warning warning">
                            <span class="icon-warning icon-2x" style="color:orange"></span> Put mark on employees who were present.
                        </div>
                        </p>
                        <div class="row">
                            <?php
                            //! Employee list in selected department along with a checkfield to mark attendance
                            ?>
                            <div class="col-sm-12" id="gridview">
                                <div class="panel panel-default"  id="attendance" style="display:none">
                                    <!--<div class="panel-heading">-->
                                        <br><h4 class="panel-title">Employee Attendance Marking</h4><hr>
                                    <!--</div>-->
                                    <div class="table-responsive">
                                        <table class="table responsive table table-bordered table table-striped" id="employeeattendence">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" style="display:none"></th>
                                                    <th data-hide="phone" class="footable-last-column" width="25%"><input type="checkbox" id="checkall"> &nbsp;&nbsp;&nbsp;Check all</th>
                                                    <th data-hide="phone,tablet" width="25%">Employee Code</th>
                                                    <th data-hide="phone,tablet" width="25%">Name</th>
                                                    <th data-hide="phone,tablet" width="25%">Remarks</th>  
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <p>&nbsp;&nbsp;<a href="javascript:saveattendance();" class="btn green" align="right">Save</a></p> 
                            </div>
                        </div>

                    </div>
                    <?php
                    /**
                     * Second tab is used to view attendance details.
                     */
                    ?>
                    <div class="tab-pane" id="tbb_b">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group col-sm-3" id="course">
                                            <label for="reg_input">Department</label>
                                            <?php
                                            //! Drop down menu to select the department
                                            $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid . ' AND companyid=' . Yii::app()->user->companyid), 'departmentid', 'department_name');
                                            echo CHtml::activeDropDownList($model, 'departmentid1', $department, array(
                                                'empty' => 'Select Department', 'class' => "form-control"));
                                            echo $form->error($model, 'departmentid1', array('class' => 'school_val_error'));
                                            ?>
                                        </div>  
                                        <div class="form-group col-sm-3" id="date">
                                            <label for="reg_input_name">Month</label>
                                            <?php
                                            //! Drop down menu to select the month
                                            echo $form->dropdownlist($model, 'date15', array(
                                                1 => 'January',
                                                2 => 'February',
                                                3 => 'March',
                                                4 => 'April',
                                                5 => 'May',
                                                6 => 'June',
                                                7 => 'July',
                                                8 => 'August',
                                                9 => 'September',
                                                10 => 'October',
                                                11 => 'November',
                                                12 => 'December',
                                                    ), array('maxlength' => 6, 'class' => "form-control", 'value' => CTimestamp::formatDate('m'),
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'url' => CController::createUrl('employeeattendance/showattendance'),
                                                    'update' => '#attendancebody')));

                                            echo $form->error($model, 'date15', array('class' => 'school_val_error'));
                                            ?>
                                        </div>
                                        <div class="form-group col-sm-3"></div>
                                        <div class="form-group col-sm-3">
                                            <label for="reg_input">&nbsp;</label><br>
                                            <input type="button" onclick="printDiv('print')" value="Print Report" class="btn red"/>
                                            <?php
//                                            $this->widget('ext.mPrint.mPrint', array(
//                                                'title' => 'Custom Certificate',
//                                                'tooltip' => '',
//                                                'text' => 'PRINT',
//                                                'element' => '#print',
//                                                'publishCss' => true,
//                                                'id' => 'PRINT_BUTTON_ID',
//                                                'htmlOptions' => array('class' => 'btn red pull-center'),
//                                            ));
                                            ?>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        //! Employee list in selected department along with their attendance of the selected month
                        ?>
                        <div class="row" id="print">
                            <div class="col-sm-12" id="gridview">
                                <div class="panel panel-default"  id="attendance">
                                    <!--<div class="panel-heading">-->
                                        <br><h4 class="panel-title" id="title">Attendance Report</h4><hr>
                                    <!--</div>-->
                                    <div class="table-responsive">
                                        <table class="table responsive table table-bordered table table-striped" id="employeeattendence1">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="2%"></th>
                                                    <th data-hide="phone,tablet" width="2%">1</th>
                                                    <th data-hide="phone,tablet" width="2%">2</th>
                                                    <th data-hide="phone,tablet" width="2%">3</th>
                                                    <th data-hide="phone,tablet" width="2%">4</th>
                                                    <th data-hide="phone,tablet" width="2%">5</th>
                                                    <th data-hide="phone,tablet" width="2%">6</th>  
                                                    <th data-hide="phone,tablet" width="2%">7</th>
                                                    <th data-hide="phone,tablet" width="2%">8</th>
                                                    <th data-hide="phone,tablet" width="2%">9</th>  
                                                    <th data-hide="phone,tablet" width="2%">10</th>
                                                    <th data-hide="phone,tablet" width="2%">11</th>
                                                    <th data-hide="phone,tablet" width="2%">12</th>  
                                                    <th data-hide="phone,tablet" width="2%">13</th>
                                                    <th data-hide="phone,tablet" width="2%">14</th>
                                                    <th data-hide="phone,tablet" width="2%">15</th>  
                                                    <th data-hide="phone,tablet" width="2%">16</th>
                                                    <th data-hide="phone,tablet" width="2%">17</th>
                                                    <th data-hide="phone,tablet" width="2%">18</th>  
                                                    <th data-hide="phone,tablet" width="2%">19</th>
                                                    <th data-hide="phone,tablet" width="2%">20</th>
                                                    <th data-hide="phone,tablet" width="2%">21</th>  
                                                    <th data-hide="phone,tablet" width="2%">22</th>
                                                    <th data-hide="phone,tablet" width="2%">23</th>
                                                    <th data-hide="phone,tablet" width="2%">24</th>  
                                                    <th data-hide="phone,tablet" width="2%">25</th>
                                                    <th data-hide="phone,tablet" width="2%">26</th>
                                                    <th data-hide="phone,tablet" width="2%">27</th>  
                                                    <th data-hide="phone,tablet" width="2%">28</th>
                                                    <th data-hide="phone,tablet" width="2%">29</th>
                                                    <th data-hide="phone,tablet" width="2%">30</th>  
                                                    <th data-hide="phone,tablet" width="2%">31</th>
                                                </tr>
                                            </thead>
                                            <tbody id='attendancebody'>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function printDiv(divName) {
        var divToPrint = document.getElementById(divName);
        var popupWin = window.open('', '', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

    $(document).ready(function () {
        var droplist = $('#Employeeattendance_departmentid');
        droplist.change(function () {
            $('#employeeattendence tbody').empty();
            $.ajax({
                type: "POST",
                url: "Attendencelist",
                data: {departmentid: $('#Employeeattendance_departmentid option:selected').val()},
                dataType: "html",
                success: function (data) {
                    $('#employeeattendence tbody').append(data);
                    $("#attendance").show("slow");
                }
            });
        })
    });
    $(document).ready(function () {
        $('#checkall').click(function (event) {  //on click 
            if (this.checked) { // check select status
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            } else {
                $('.checkbox').each(function () { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });
            }
        });

    });
    function saveattendance() {
        var employeeid = [];
        var absentemployeeid = [];
        $('#employeeattendence tbody tr').each(function (row, tr) {
            if ($(this).find(":checkbox").prop("checked")) {
                var employeemasterid = $(tr).find('td:eq(0)').data('id');
                var remark = $(tr).find('td:eq(4) input').val();


                employeeid.push(employeemasterid);
                employeeid.push(remark);
            } else {
                var employeemasterid1 = $(tr).find('td:eq(0)').data('id');
                var remark1 = $(tr).find('td:eq(4) input').val();


                absentemployeeid.push(employeemasterid1);
                absentemployeeid.push(remark1);
            }

        });
        var sendarray = JSON.stringify(employeeid);
        var sendarrayabsent = JSON.stringify(absentemployeeid);


        $.ajax({
            type: "POST",
            url: "Saveattendence",
            data: {sendarray: sendarray, date: $('#Employeeattendance_date').val(), sendarrayabsent: sendarrayabsent},
            dataType: "html",
            success: function (data) {
                alert("Successfully saved");
            }
        })
    }
</script>
<?php
$js_code = <<<EOD
$('#Employeeattendance_date15').on('change', function() {
 
           $('#title').html('Attendance Report of '+$('#Employeeattendance_departmentid1 option:selected').text()+' - '+$('#Employeeattendance_date15 option:selected').text());
      
        return true;
    });
        
EOD;

Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . 'employeeattendance-form', $js_code);
?>