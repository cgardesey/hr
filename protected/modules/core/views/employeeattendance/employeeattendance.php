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
            <li><span>My Attendance</span></li>
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
             *  Viewing logged in employee attendance 
             */
            ?>
            <div class="col-sm-12">
                
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                      <?php 
                                      $employee = Employee::model()->findByPk(Yii::app()->user->userid); //! < $employee stores the details of logged in employee
                                      $departmentid = $employee->departmentid; //! < $departmentid stores the department id
                                     $employeeid = Yii::app()->user->userid;
                                      ?>
                                        <div class="form-group col-sm-3" id="date">
                                            <label for="reg_input_name">Month</label>
                                            <?php
                                            //! Drop down menu to select the month
                                            echo $form->dropdownlist($model, 'date15', array(
                                                0 => 'Please Select',
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
                                                ));
                                            echo $form->error($model, 'date15', array('class' => 'school_val_error'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <?php
                            //! Employee attendance of the selected month
                            ?>
                        <div class="row" id="print">
                            <div class="col-sm-12" id="gridview" style="display:none">
                                <div class="panel panel-default"  id="attendance">
                                    <!--<div class="panel-heading">-->
                                        <br><h4 class="panel-title" id="title">Attendance Report</h4><hr>
                                    <!--</div>-->
                                    <div class="table-responsive">
                                        <table class="table responsive table table-bordered table table-striped" id="employeeattendence1">
                                        <thead>
                                            <tr>
                                                <!--<th data-hide="phone,tablet" width="2%"></th>-->
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
                    <?php $this->endWidget(); ?>
            </div>
        </div>
<script>
    $(document).ready(function () {
        var droplist = $('#Employeeattendance_date15');
        droplist.change(function () {
            $('#employeeattendence1 tbody').empty();
            $.ajax({
                type: "POST",
                url: "Showemployeeattendance",
                data: {departmentid: <?php echo $departmentid ?>,month: $('#Employeeattendance_date15 option:selected').val(),employeeid: <?php echo $employeeid ?>},
                dataType: "html",
                success: function (data) {
                    $('#employeeattendence1 tbody').append(data);
                    $("#gridview").show("slow");
                }
            });
        })
    });

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