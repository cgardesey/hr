<?php

class BankdetailsController extends Controller {

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
                'actions' => array('create', 'update', 'Fetchemployee', 'Getbanklistall'),
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

//! A function named Fetchemployee
    /* !
     * used to get the details of emplopyees who belongs to the selected department.
     */
    public function actionFetchemployee() {

        $data = Employee::model()->findAll('designationid=:designationid', array(':designationid' => (int) $_POST['Bankdetails']['designationid'])); //retrieving the employee details using the designationid
        $data1 = Employeesalary::model()->listData($data, 'employeeid', array('employee_firstname', 'employee_middlename', 'employee_lastname', '')); //retrieving the employee details using the employee masterid
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("Select"), true);
        foreach ($data1 as $value => $each) {
            $employee = Employee::model()->findByPk($value);
            if ($employee->employee_status === '1') {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($each), true); //passing values to form
            }
        }
    }

    //! A function named Getbanklistall.
    /* !
     * used to get the bank details of employees in selected departments.
     */
    public function actionGetbanklistall() {

        $departmentid = $_POST['departmentid']; //Getting departmentid

        $employee = Employee::model()->findAllByAttributes(array('departmentid' => $departmentid, 'employee_status' => '1','companyid'=>Yii::app()->user->companyid));

        $sendtable = "";

        foreach ($employee as $value => $employee) {

            $bankdetails = Bankdetails::model()->findAllByAttributes(array('employeeid' => $employee->employeeid));

            foreach ($bankdetails as $bankdetail) {

                $sendtable = $sendtable . '<tr><td style="display:none" data-id="' . $bankdetail->employeeid . '">' . $bankdetail->employeeid . '</td><td>' . $bankdetail->employee->employee_code . '</td><td>' . $bankdetail->employee->employee_firstname . " " . $bankdetail->employee->employee_middlename . " " . $bankdetail->employee->employee_lastname . '</td><td>' . $bankdetail->bank_name . '</td><td>' . $bankdetail->bank_branch . '</td><td>' . $bankdetail->bank_accountno . '</td><td>' . $bankdetail->bank_ifsc . '</td></tr>';
            }
        }
        echo $sendtable; //passing result to form
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
        $model = new Bankdetails;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Bankdetails'])) {
            $model->attributes = $_POST['Bankdetails'];

            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;

            if ($model->validate()) {

                if ($model->save())
                    Yii::app()->user->setFlash('success', 'Bank details has been saved successfuly');
                $this->redirect(array('create'));
            }
            else {
                //error message
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
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

        if (isset($_POST['Bankdetails'])) {
            $model->attributes = $_POST['Bankdetails'];

            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
            $model->financialyearid = $financialyear->financialyearid;
            $model->companyid = Yii::app()->user->companyid;

            if ($model->validate()) {

                if ($model->save())
                    Yii::app()->user->setFlash('success', 'Bank details has been updated successfuly');
                $this->redirect(array('create'));
            }
            else {
                //error message
                $error = CActiveForm::validate($model);
                if ($error != '[]')
                    echo $error;
            }
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

        try {
            $this->loadModel($id)->delete();
            return $this->redirect(('create'));
        } catch (CDbException $e) {
            if (1451 == $e->errorInfo[1]) {
                // Your message goes here
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
        $dataProvider = new CActiveDataProvider('Bankdetails');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Bankdetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Bankdetails']))
            $model->attributes = $_GET['Bankdetails'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Bankdetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Bankdetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Bankdetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bankdetails-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
