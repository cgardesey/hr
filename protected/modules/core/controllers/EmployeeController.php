<?php

class EmployeeController extends Controller {

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
                'actions' => array('create', 'update', 'Fetchdivision', 'Profile', 'Updateprofile', 'Report',
                    'Fetchdesignation', 'Fetchjobcategory', 'Employeereport'),
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

    /*
     * A function named Employeereport
     * Used to view employee report
     */

    public function actionEmployeereport() {
        $reportfor = $_POST['reportfor'];
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details

        if ($reportfor === '1') { //! Department wise
            $employees = Employee::model()->findAllByAttributes(array('employee_status' => '1', 'departmentid' => $_POST['departmentid'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            $department = Department::model()->findByPk($_POST['departmentid']);
            $label = "Department Wise Employee List - " . $department->department_name;
             $jobdetails=array();
        }
        if ($reportfor === '2') { //! Designation wise
            $employees = Employee::model()->findAllByAttributes(array('employee_status' => '1', 'designationid' => $_POST['designationid'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            $designation = Designation::model()->findByPk($_POST['designationid']);
            $label = "Designation Wise Employee List - " . $designation->designation_name;
             $jobdetails=array();
        }
        if ($reportfor === '3') { //! Division Wise
            $employees = Employee::model()->findAllByAttributes(array('employee_status' => '1', 'divisionid' => $_POST['divisionid'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            $division = Division::model()->findByPk($_POST['divisionid']);
            $label = "Division Wise Employee List - " . $division->division_name;
             $jobdetails=array();
        }
        if ($reportfor === '4') { //! User type wise
            $employees = Employee::model()->findAllByAttributes(array('employee_status' => '1', 'usertypeid' => $_POST['usertypeid'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            $usertype = Usertype::model()->findByPk($_POST['usertypeid']);
            $label = "Usertype Wise Employee List - " . $usertype->usertype_name;
             $jobdetails=array();
        }
        if ($reportfor === '5') { //! job category wise
            $jobdetails = Jobdetails::model()->findAllByAttributes(array('jobcategoryid' => $_POST['jobcategoryid'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            $jobcategory = Jobcategory::model()->findByPk($_POST['jobcategoryid']);
            $label = "Jobcategory Wise Employee List - " . $jobcategory->jobcategory_name;
            $employees = array();
        }
        if ($reportfor === '6') { //! status wise
            $employees = Employee::model()->findAllByAttributes(array('employee_status' => $_POST['status'], 'companyid' => Yii::app()->user->companyid, 'financialyearid' => $financialyear->financialyearid));
            if ($_POST['status'] === '1') {
                $label = "Existing Employee List";
            }
            if ($_POST['status'] === '2') {
                $label = "Resigned Employee List";
            }
            if ($_POST['status'] === '3') {
                $label = "Terminated Employee List";
            }
            $jobdetails=array();
        }
        echo ' <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">' . $label . ' </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Employee Code </th>
                                    <th> Employee Name </th>
                                    <th> Email </th>
                                    <th> Mobile Number </th>
                                </tr>
                            </thead>
                            <tbody>';
        if (count($employees) != 0) {
            $sl1 = 1;
            foreach ($employees as $employee) {
                echo '<tr>
                                    <td> ' . $sl1 . ' </td>
                                    <td> ' . $employee->employee_code . ' </td>
                                    <td> ' . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname . ' </td>
                                    <td> ' . $employee->employee_email . ' </td>
                                    <td> ' . $employee->employee_mobile . ' </td>
                                </tr>';
                $sl1++;
            }
        } else {
            if (count($jobdetails) != 0) {
                $sl1 = 1;
                $dupemployeeid = array();
                foreach ($jobdetails as $jobdetail) {
                    if (in_array($jobdetail->employeeid, $dupemployeeid)) {
                        
                    } else {
                        array_push($dupemployeeid, $jobdetail->employeeid);
                        echo '<tr>
                                    <td> ' . $sl1 . ' </td>
                                    <td> ' . $jobdetail->employee->employee_code . ' </td>
                                    <td> ' . $jobdetail->employee->employee_firstname . " " . $jobdetail->employee->employee_middlename . " " . $jobdetail->employee->employee_lastname . ' </td>
                                    <td> ' . $jobdetail->employee->employee_email . ' </td>
                                    <td> ' . $jobdetail->employee->employee_mobile . ' </td>
                                </tr>';
                        $sl1++;
                    }
                }
            }
        }
        echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>';
    }

    //! A function named Fetchjobcategory
    /* !
     * used to get the details of Job category.
     */
    public function actionFetchjobcategory() {

        $data = Jobcategory::model()->findAllByAttributes(array('departmentid' => (int) $_POST['Employee']['departmentid'], 'divisionid' => (int) $_POST['Employee']['divisionid'], 'companyid' => Yii::app()->user->companyid));
        $data = CHtml::listData($data, 'jobcategoryid', 'jobcategory_name');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data as $value => $each) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($each), true); //passing values to form
        }
    }

    //! A function named Fetchdesignation
    /* !
     * used to get the details of designation.
     */
    public function actionFetchdesignation() {

        $data = Designation::model()->findAllByAttributes(array('jobcategoryid' => (int) $_POST['Employee']['jobcategoryid'], 'companyid' => Yii::app()->user->companyid));
        $data = CHtml::listData($data, 'designationid', 'designation_name');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data as $value => $each) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($each), true); //passing values to form
        }
    }

    /**
     * This function is used to View profile of logged in user
     */
    public function actionReport() {
        $model = new Employee;
        $this->render('reports', array(
            'model' => $model,
        ));
    }

    /**
     * This function is used to View profile of logged in user
     */
    public function actionProfile() {
        $model = Employee::model()->findByPk(Yii::app()->user->userid);
        $this->render('profile', array(
            'model' => $model,
        ));
    }

    public function actionUpdateprofile($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $oldFileName = $model->employee_photo;
        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;
            $uploadedFile = CUploadedFile::getInstance($model, 'employee_photo');
            if (isset($uploadedFile)) {
                $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                $date = new DateTime();
                $date->setTimezone($timezone);
                $date = $date->format('dmYhis');

                $ext = end((explode(".", $uploadedFile)));
                $fileName = "$date.$ext";
                $model->employee_photo = $fileName;
            } else {
                $model->employee_photo = $oldFileName;
            }
            if ($model->validate()) {

//                $username = Yii::app()->user->companyid . $model->employee_code;
//                $user = Users::model()->findByAttributes(array('username' => $username, 'companyid' => Yii::app()->user->companyid, 'userid' => $model->employeeid));
//                if (isset($user)) {
//                    $user->usertypeid = $_POST['Employee']['usertypeid'];
//                    $user->save(false);
//                }
                if ($model->save(false)) {
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                }
                Yii::app()->user->setFlash('success', 'Successfully updated.');
                $this->redirect(array('profile', 'id' => $model->employeeid));
//                $this->redirect(array('profile'));
            }
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * A function
     * Used to fetch the feessubcategories of selected category for fee allocation
     */
    public function actionFetchdivision() {
        $data = Division::model()->findAll('departmentid=:departmentid', array(':departmentid' => (int) $_POST['Employee']['departmentid'])); //Fetching all batches under the selected course
        $data = CHtml::listData($data, 'divisionid', 'division_name');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data as $value => $eachbatch) {//! For each batch
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($eachbatch), true);
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Employee;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            $model->divisionid = $_POST['Employee']['divisionid'];

            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;

            $model->employee_status = '1'; //! existing employee

            $timezone = new DateTimeZone(Yii::app()->params['timezone']);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $date = $date->format('dmYhis');
            $uploadedFile = CUploadedFile::getInstance($model, 'employee_photo');
            if (isset($uploadedFile)) {
                $ext = end((explode(".", $uploadedFile)));
                $fileName = "$date.$ext";
                $model->employee_photo = $fileName;
            }


            if ($model->validate()) {

                //*******************Account generation for employee*********************************//

                if ($model->save(false)) {

                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }

                    $usertype = $_POST['Employee']['usertypeid'];
                    $userid = $model->employeeid;
                    $companyid = Yii::app()->user->companyid;
                    $email = $model->employee_email;
                    $username = $companyid . $model->employee_code;
                    $rtn = User::model()->usersignup($username, $usertype, $userid, $companyid, $email); //format $username, $usertype, $userid
                    $this->redirect(array('admin'));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Validation Error');
            }
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
        $this->performAjaxValidation($model);

        $oldFileName = $model->employee_photo;
        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;
            $uploadedFile = CUploadedFile::getInstance($model, 'employee_photo');
            if (isset($uploadedFile)) {
                $timezone = new DateTimeZone(Yii::app()->params['timezone']);
                $date = new DateTime();
                $date->setTimezone($timezone);
                $date = $date->format('dmYhis');

                $ext = end((explode(".", $uploadedFile)));
                $fileName = "$date.$ext";
                $model->employee_photo = $fileName;
            } else {
                $model->employee_photo = $oldFileName;
            }
            if ($model->validate()) {

                $username = Yii::app()->user->companyid . $model->employee_code;
                $user = Users::model()->findByAttributes(array('username' => $username, 'companyid' => Yii::app()->user->companyid, 'userid' => $model->employeeid));
                if (isset($user)) {
                    $user->usertypeid = $_POST['Employee']['usertypeid'];
                    $user->save(false);
                }
                if ($model->save(false)) {
                    if (isset($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../banner/' . $fileName);
                    }
                }
                $this->redirect(array('admin'));
            }
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        try {
            $model = Employee::model()->findByPk($id);
            $username = Yii::app()->user->companyid . $model->employee_code;
            $model_useremployee = Users::model()->findByAttributes(array('userid' => $model->employeeid, 'username' => $username));

            $model_useremployee->delete();
            $model->delete();
            return $this->redirect('create');
        } catch (CDbException $e) {
            if (1451 == $e->errorInfo[1]) {
                $msg = 'Unable to delete this field.';
            } else {
                $msg = 'Deletion failed';
            }

            if (isset($_GET['ajax'])) {
                throw new CHttpException(400, $msg);
            } else {
                Yii::app()->user->setFlash('error', $msg);
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Employee');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Employee the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Employee $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
