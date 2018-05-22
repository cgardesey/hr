<?php

class LoginController extends Controller {

    public $defaultAction = 'login';
    public $layout = '//layouts/column3';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    if (Yii::app()->user->returnUrl == '/index.php')
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            // display the login form
            $this->render('/user/login', array('model' => $model));
        } else
            $this->redirect(Yii::app()->controller->module->returnUrl);
    }

    public function actionLogin1() {

        $model = new UserLogin;
        // collect user input data
        if (isset($_GET['id'])) {

            $ids = $_GET['id'];
            $ex = explode(',', $ids);
            $model->username = $ex[0];
            $model->password = $ex[1];
            // validate user input and redirect to previous page if valid
            if ($model->validate()) {
                $this->lastViset();
                if (Yii::app()->user->returnUrl == '/index.php')
                    $this->redirect(Yii::app()->controller->module->returnUrl);
                else
                {
                    if($model->username == 'admin')
                    {
                        $this->redirect(Yii::app()->request->baseUrl . "/index.php/site/superadmin");
                      //  echo Yii::app()->request->baseUrl;
                    }
                    else
                    {
                        $this->redirect(Yii::app()->request->baseUrl . "/index.php/site/admin");
                    }
}
                    
            }
        }
    }

    public function actionLoginguest() {

        $model = new UserLogin;
        // collect user input data

        $model->username = 'demo';
        $model->password = 'demo';
        // validate user input and redirect to previous page if valid
        if ($model->validate()) {
            $this->lastViset();
            if (Yii::app()->user->returnUrl == '/index.php')
                $this->redirect(Yii::app()->controller->module->returnUrl);
            else
                $this->redirect(Yii::app()->request->baseUrl . "/index.php");
        }
    }

    public function actionLoginrequest() {
        $model = new UserLogin;
        // collect user input data
        $model->username = 'demo1';
        $model->password = 'demo';
        // validate user input and redirect to previous page if valid
        if ($model->validate()) {
            $this->lastViset();

//! This function is used for save attendance details 
            $admissionno = $_GET['admissionno'];
            $date = $_GET['date'];

            if ($admissionno === "" && $date === "") {
                header('Content-type: application/json');
                $response["success"] = 0;
                $response["message"] = "error occured.";

                echo json_encode($response);
            } else {
                $student = Student::model()->findByAttributes(array('student_admissionno' => $admissionno));
                if (isset($student)) {
                    $date1 = date_create($date);
                    $date3 = date_format($date1, 'Y-m-d');

                    $exists = Studentabsent::model()->findByAttributes(array('studentid' => $student->studentid, 'date' => $date3));
                    if (isset($exists)) {
                        
                    } else {
                        $model_ab = new Studentabsent;
                        $model_ab->studentid = $student->studentid;
                        $model_ab->date = $date3;
                        $model_ab->subjectid = "";

                        $model_ab->save(false);
                    }
                    $model_details = new Attendancedetails;
                    $model_details->institutionid = Yii::app()->user->institutionid;
                    $model_details->studentid = $student->studentid;
                    $model_details->date = $date3;
                    $time = $_GET['time'];
                    $time = date("H:i:s", strtotime($time));
                    $model_details->time = $time;
                    $model_details->cardno = $_GET['cardno'];
                    $model_details->in_out = $_GET['status'];
                    $model_details->save(false);

                    header('Content-type: application/json');
                    $response["success"] = 1;
                    $response["message"] = "Success.";
                    echo json_encode($response);
                } else {
                    header('Content-type: application/json');
                    $response["success"] = 0;
                    $response["message"] = "error occured.";

                    echo json_encode($response);
                }
            }

//                if (Yii::app()->user->returnUrl == '/index.php')
//                    $this->redirect(Yii::app()->controller->module->returnUrl);
//                else
//                    $this->redirect(Yii::app()->request->baseUrl . "/index.php");
        }
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}
