<?php

/*
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
 */

class EmployeeattendanceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'Attendencelist', 'Saveattendence', 'showattendance',
                    'Employeeattendance', 'Showemployeeattendance'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * A function
     * Used to load the employeeattendance page
     */
    public function actionEmployeeattendance() {
        $model = new Employeeattendance;
        $this->render('employeeattendance', array(
            'model' => $model,
        ));
    }

    /**
     * A function
     * Used to list the employees in selected department
     */
    public function actionAttendencelist() {

        $departmentid = $_POST['departmentid']; //! $departmentid stores the departmentid

        $employees = Employee::model()->findAllByAttributes(array('departmentid' => $departmentid, 'employee_status' => '1')); //! $employees stores the employee details


        $sendtable = "";

        foreach ($employees as $value => $employee) {//! For each employee employee name is send to form
            $sendtable = $sendtable . '<tr><td style="display:none" data-id="' . $employee->employeeid . '">' . $employee->employeeid . '</td><td>' . '<input type="checkbox" name="attendence" class="checkbox"></td><td>' . $employee->employee_code . '</td><td>' . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname . '</td><td>' . '<input type="text" name="remark" class="form-control"></td></tr>';
        }
        echo $sendtable;
    }

    /**
     * A function
     * Used to saves the attendance details
     */
    public function actionSaveattendence() {
        $date = $_POST['date']; //! $date stores the date details
        $date1 = date_create($date);
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        if (isset($_POST['sendarray'])) {//! Check whether there is any values in sendarray. If yes,(ie, employee is present)
            $sendarray = json_decode($_POST['sendarray']); //! <Values are decoded and stored in $sendarray

            for ($i = 0; $i <= count($sendarray) - 1; $i = $i + 2) {//! <For each values in sendarray
                $leaveapplication = Leaveapplication::model()->findByAttributes(array('employeeid' => $sendarray[$i], 'fromdate' => date_format($date1, 'Y-m-d H:i:s'), 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid)); //! <<$leaveapplication stores the details leave applications
                if (isset($leaveapplication)) {//! Check whether there is any leave applied for tht day , and employee is present, then deletes that leave applied by the employee
                    $leave = Leaveapplication::model()->findByAttributes(array('employeeid' => $sendarray[$i], 'fromdate' => date_format($date1, 'Y-m-d H:i:s'), 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
                    $leave->delete();
                }
                $model = new Employeeattendance;
                $model->employeeid = $sendarray[$i];
                $model->date = date_format($date1, 'Y-m-d H:i:s');
                $model->remarks = $sendarray[$i + 1];
                $model->financialyearid = $financialyear->financialyearid;
                $model->companyid = Yii::app()->user->companyid;

                $model->save(false);
            }
        }
        if (isset($_POST['sendarrayabsent'])) {//! Check whether there is any values in sendarrayabsent. If yes,(ie, employee is absent)
            $sendarrayabsent = json_decode($_POST['sendarrayabsent']); //! <$sendarrayabsent stores the employee details who were absent

            for ($i = 0; $i <= count($sendarrayabsent) - 1; $i = $i + 2) {   //! < For each employee absent with out leave is stored in to db
                $leavedates = Leaveapplication::model()->findAllByAttributes(array('employeeid' => $sendarrayabsent[$i], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
                foreach ($leavedates as $leavedate) {

                    $leavestartdate = $leavedate->fromdate;
                    $startdate1 = explode(' ', $leavestartdate);
                    $startdate = $startdate1[0];
                    $startdate1 = date_create($startdate);
                    $startdate2 = date_format($startdate1, 'Y-m-d');

                    $leaveenddate = $leavedate->todate;
                    $enddate3 = explode(' ', $leaveenddate);
                    $enddate = $enddate3[0];
                    $enddate1 = date_create($enddate);
                    $enddate2 = date_format($enddate1, 'Y-m-d');

                    $startday = explode('-', $startdate2);
                    $endday = explode('-', $enddate2);
                    $startday1 = $startday[2];
                    $endday1 = $endday[2];

                    $dates = array();
                    for ($j = $startday1; $j <= $endday1; $j++) {
                        $date3 = date_create($startday[1] . '/' . $j . '/' . $startday[0]);
                        $date4 = date_format($date3, 'Y-m-d');
                        array_push($dates, $date4);
                    }
                }
                $lvdate = date_format($date1, 'Y-m-d');
                if (in_array($lvdate, $dates)) {
                    
                } else {
                    $model_leave = new Leaveapplication;
                    $model_leave->employeeid = $sendarrayabsent[$i];
                    $model_leave->fromdate = date_format($date1, 'Y-m-d H:i:s');
                    $model_leave->todate = date_format($date1, 'Y-m-d H:i:s');
                    $model_leave->status = 4;
                    $model_leave->leavedetailsid = 1;
                    $model_leave->reason = $sendarrayabsent[$i + 1];
                    $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                    $model->financialyearid = $financialyear->financialyearid;
                    $model->companyid = Yii::app()->user->companyid;

                    $model_leave->save(false);
                }
            }
        }
    }

    /**
     * A function
     * Used to shows individual attendance details for employee login
     */
    public function actionShowemployeeattendance() {
        $month = $_POST['month']; //! $month is used to store the month details
        $month = (int) $month;
        $departmentid = $_POST['departmentid']; //! $departmentid is used to store the departmentid
        $employeeid = $_POST['employeeid']; //! $employeeid is used to store the employeeid
       $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
       $employeearray = array();

        $employees = Employee::model()->findAllByattributes(array('departmentid' => $departmentid, 'employee_status' => '1')); //! $employees stores the employee details in the selected department
        echo '<tr>';
        foreach ($employees as $emp) {//! For each employee check whether the employee is absent or not and details are sent to form
            echo '<tr>';
            $attendance = Employeeattendance::model()->findAllByAttributes(array('employeeid' => $emp->employeeid,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! < $attendance stores the attendance details of the selected employee
            foreach ($attendance as $perday) {//! < For each attendance details
                $readmonth = $perday->date;
                $date = new DateTime($readmonth);
                $readmonth = $date->format('m');
                $readmonth = (int) $readmonth; //! << $readmonth stores the month of attendance in integer format
                if ($readmonth === $month) {//! << Check whether the selected month equal to the month get from attendance details, If yes,
                    $empname = Employee::model()->findByPk($perday->employeeid); //! << $empname stores the employee details.
                    if (in_array($empname->employee_code, $employeearray)) {//! <<Checks if employee_code exists in $employeearray.
                    } else {//! <<If no,
                        if ($employeeid === $empname->employeeid) {

                            array_push($employeearray, $empname->employee_code); //! <<< employee code is pushed into the array
                            for ($i = 1; $i <= 31; $i++) {//! <<< For i =1 to 31
                                $date1 = date_create($month . '/' . $i . '/' . date('Y'));
                                $date2 = date_format($date1, 'Y-m-d H:i:s');
                                $checkattendance = Employeeattendance::model()->findByAttributes(array('employeeid' => $emp->employeeid, 'date' => $date2,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                                $date3 = date_format($date1, 'Y-m-d');
                                $event = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '3', 'departmentid' => $departmentid,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! <<<< $event stores whether the selected date is holiday for selected department or not
                                $event2 = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '1','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! <<<< $event2 stores whether the selected date is holiday for all department or not

                                if (isset($checkattendance)) {//! <<<< If employeee is present on that date then data is passed to form
                                    echo '<td  style="color:green"><b>X</b></td>';
                                } else if (!isset($checkattendance)) { //! <<<< Other wise, 
                                    $Datetime_acdate = strtotime($date2);
                                    $DayofWeek = date('D', $Datetime_acdate);
                                    if ($DayofWeek == 'Sun') {//! <<<< Check whether the day is sunday. If yes 'S' is passed to form
                                        echo '<td style="color:red">S</td>';
                                    } else if (isset($event)) {//! <<<< If it is not sunday, then check is there any values is $event. If yes,
                                        $events = Event::model()->findAllByAttributes(array('isholiday' => '1', 'departmentid' => $departmentid, 'event_for' => '3','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                                        foreach ($events as $eachevent) {//! <<<<< For each event check whether the selected day contain any event. If yes 'H' is passed to form. Other wise 'A' is passed to form.
                                            $eventstartdate = $eachevent->event_startdate;
                                            $startdate1 = explode(' ', $eventstartdate);
                                            $startdate = $startdate1[0];
                                            $startdate1 = date_create($startdate);
                                            $startdate2 = date_format($startdate1, 'Y-m-d');

                                            $eventenddate = $eachevent->event_enddate;
                                            $enddate3 = explode(' ', $eventenddate);
                                            $enddate = $enddate3[0];
                                            $enddate1 = date_create($enddate);
                                            $enddate2 = date_format($enddate1, 'Y-m-d');

                                            $startday = explode('-', $startdate2);
                                            $endday = explode('-', $enddate2);
                                            $startday1 = $startday[2];
                                            $endday1 = $endday[2];

                                            $holidays = array();
                                            for ($j = $startday1; $j <= $endday1; $j++) {
                                                $date1 = date_create($startday[1] . '/' . $j . '/' . $startday[0]);
                                                $date4 = date_format($date1, 'Y-m-d');
                                                array_push($holidays, $date4);
                                            }
                                        }

                                        if (in_array($date3, $holidays)) {
                                            echo '<td style="color:red">H</td>';
                                        } else {
                                            echo '<td style="color:#cccccc">A</td>';
                                        }
                                    } else if (isset($event2)) {//! <<<< If there is n't any values in $ event, then check is there any values is $event2. If yes,
                                        $events1 = Event::model()->findAllByAttributes(array('isholiday' => '1', 'event_for' => '1','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                                        foreach ($events1 as $eachevent1) {//! <<<<< For each event check whether the selected day contain any event. If yes 'H' is passed to form. Other wise 'A' is passed to form.
                                            $eventstartdate = $eachevent1->event_startdate;
                                            $startdate11 = explode(' ', $eventstartdate);
                                            $startdate1 = $startdate11[0];
                                            $startdate11 = date_create($startdate1);
                                            $startdate21 = date_format($startdate11, 'Y-m-d');

                                            $eventenddate = $eachevent1->event_enddate;
                                            $enddate31 = explode(' ', $eventenddate);
                                            $enddate1 = $enddate31[0];
                                            $enddate11 = date_create($enddate1);
                                            $enddate21 = date_format($enddate11, 'Y-m-d');

                                            $startday1 = explode('-', $startdate21);
                                            $endday1 = explode('-', $enddate21);
                                            $startday11 = $startday1[2];
                                            $endday11 = $endday1[2];

                                            $holidays1 = array();
                                            for ($j = $startday11; $j <= $endday11; $j++) {
                                                $date11 = date_create($startday1[1] . '/' . $j . '/' . $startday1[0]);
                                                $date41 = date_format($date11, 'Y-m-d');
                                                array_push($holidays1, $date41);
                                            }
                                        }
                                        if (in_array($date3, $holidays1)) {
                                            echo '<td style="color:red">H</td>';
                                        } else {
                                            echo '<td style="color:#cccccc">A</td>';
                                        }
                                    } else {//! <<<< If there isn't any value in $event1 and $event2 then 'A' is passed to form'
                                        echo '<td style="color:#cccccc">A</td>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            echo '</tr>';
        }
    }

    /**
     * A function
     * Used to shows attendance details
     */
    public function actionShowattendance() {
        $month = $_POST['Employeeattendance']['date15']; //! $month stores the month details.
        $month = (int) $month;
        $departmentid = $_POST['Employeeattendance']['departmentid1']; //! $departmentid stores the department details.
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $employeearray = array();

        $employees = Employee::model()->findAllByattributes(array('departmentid' => $departmentid, 'employee_status' => '1')); //! $employees stores the employee details of the selected department
        echo '<tr>';
        foreach ($employees as $emp) {//! For each employee check whether the employee is absent or not and details are sent to form
            echo '<tr>';
            $attendance = Employeeattendance::model()->findAllByAttributes(array('employeeid' => $emp->employeeid,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! < $attendance stores the attendance details of the selected employee
            foreach ($attendance as $perday) {//! < For each attendance details
                $readmonth = $perday->date;
                $date = new DateTime($readmonth);
                $readmonth = $date->format('m');
                $readmonth = (int) $readmonth; //! << $readmonth stores the month of attendance in integer format
                if ($readmonth === $month) {//! << Check whether the selected month equal to the month get from attendance details, If yes,
                    $empname = Employee::model()->findByPk($perday->employeeid); //! << $empname stores the employee details.
                    if (in_array($empname->employee_code, $employeearray)) {//! <<Checks if employee_code exists in $employeearray. 
                    } else {//! <<If no,
                        array_push($employeearray, $empname->employee_code); //! <<< employee code is pushed into the array

                        echo '<td>';

                        echo $empname->employee_firstname . ' ' . $empname->employee_middlename . ' ' . $empname->employee_lastname; //! <<< Employee name is passed in to the form.
                        echo '</td>';
                        for ($i = 1; $i <= 31; $i++) {//! <<< For i =1 to 31
                            $date1 = date_create($month . '/' . $i . '/' . date('Y'));
                            $date2 = date_format($date1, 'Y-m-d H:i:s');
                            $checkattendance = Employeeattendance::model()->findByAttributes(array('employeeid' => $emp->employeeid, 'date' => $date2,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! <<<< $checkattendance stores the attendace details of the selected employee for the selected month
                            $date3 = date_format($date1, 'Y-m-d');
                            $event = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '3', 'departmentid' => $departmentid,'companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! <<<< $event stores whether the selected date is holiday for selected department or not
                            $event2 = Event::model()->findByAttributes(array('isholiday' => '1', 'event_for' => '1','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid)); //! <<<< $event2 stores whether the selected date is holiday for all department or not

                            if (isset($checkattendance)) {//! <<<< If employeee is present on that date then data is passed to form
                                echo '<td  style="color:green"><b>X</b></td>';
                            } else if (!isset($checkattendance)) { //! <<<< Other wise, 
                                $Datetime_acdate = strtotime($date2);
                                $DayofWeek = date('D', $Datetime_acdate);
                                if ($DayofWeek == 'Sun') {//! <<<< Check whether the day is sunday. If yes 'S' is passed to form
                                    echo '<td style="color:red">S</td>';
                                } else if (isset($event)) {//! <<<< If it is not sunday, then check is there any values is $event. If yes,
                                    $events = Event::model()->findAllByAttributes(array('isholiday' => '1', 'departmentid' => $departmentid, 'event_for' => '3','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                                    foreach ($events as $eachevent) {//! <<<<< For each event check whether the selected day contain any event. If yes 'H' is passed to form. Other wise 'A' is passed to form.
                                        $eventstartdate = $eachevent->event_startdate;
                                        $startdate1 = explode(' ', $eventstartdate);
                                        $startdate = $startdate1[0];
                                        $startdate1 = date_create($startdate);
                                        $startdate2 = date_format($startdate1, 'Y-m-d');

                                        $eventenddate = $eachevent->event_enddate;
                                        $enddate3 = explode(' ', $eventenddate);
                                        $enddate = $enddate3[0];
                                        $enddate1 = date_create($enddate);
                                        $enddate2 = date_format($enddate1, 'Y-m-d');

                                        $startday = explode('-', $startdate2);
                                        $endday = explode('-', $enddate2);
                                        $startday1 = $startday[2];
                                        $endday1 = $endday[2];

                                        $holidays = array();
                                        for ($j = $startday1; $j <= $endday1; $j++) {
                                            $date1 = date_create($startday[1] . '/' . $j . '/' . $startday[0]);
                                            $date4 = date_format($date1, 'Y-m-d');
                                            array_push($holidays, $date4);
                                        }
                                    }

                                    if (in_array($date3, $holidays)) {
                                        echo '<td style="color:red">H</td>';
                                    } else {
                                        echo '<td style="color:#cccccc">A</td>';
                                    }
                                } else if (isset($event2)) {//! <<<< If there is n't any values in $ event, then check is there any values is $event2. If yes,
                                    $events1 = Event::model()->findAllByAttributes(array('isholiday' => '1', 'event_for' => '1','companyid'=>Yii::app()->user->companyid,'financialyearid'=>$financialyear->financialyearid));
                                    foreach ($events1 as $eachevent1) {//! <<<<< For each event check whether the selected day contain any event. If yes 'H' is passed to form. Other wise 'A' is passed to form.
                                        $eventstartdate = $eachevent1->event_startdate;
                                        $startdate11 = explode(' ', $eventstartdate);
                                        $startdate1 = $startdate11[0];
                                        $startdate11 = date_create($startdate1);
                                        $startdate21 = date_format($startdate11, 'Y-m-d');

                                        $eventenddate = $eachevent1->event_enddate;
                                        $enddate31 = explode(' ', $eventenddate);
                                        $enddate1 = $enddate31[0];
                                        $enddate11 = date_create($enddate1);
                                        $enddate21 = date_format($enddate11, 'Y-m-d');

                                        $startday1 = explode('-', $startdate21);
                                        $endday1 = explode('-', $enddate21);
                                        $startday11 = $startday1[2];
                                        $endday11 = $endday1[2];

                                        $holidays1 = array();
                                        for ($j = $startday11; $j <= $endday11; $j++) {
                                            $date11 = date_create($startday1[1] . '/' . $j . '/' . $startday1[0]);
                                            $date41 = date_format($date11, 'Y-m-d');
                                            array_push($holidays1, $date41);
                                        }
                                    }
                                    if (in_array($date3, $holidays1)) {
                                        echo '<td style="color:red">H</td>';
                                    } else {
                                        echo '<td style="color:#cccccc">A</td>';
                                    }
                                } else {//! <<<< If there isn't any value in $event1 and $event2 then 'A' is passed to form'
                                    echo '<td style="color:#cccccc">A</td>';
                                }
                            }
                        }
                    }
                }
            }
            echo '</tr>';
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Employeeattendance;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Employeeattendance'])) {
            $model->attributes = $_POST['Employeeattendance'];
             $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->employeeattendanceid));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed

        if (isset($_POST['Employeeattendance'])) {
            $model->attributes = $_POST['Employeeattendance'];
             $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->employeeattendanceid));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Employeeattendance the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Employeeattendance::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Employeeattendance $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employeeattendance-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
