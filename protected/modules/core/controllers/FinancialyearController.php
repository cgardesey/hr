<?php

class FinancialyearController extends Controller {

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
                'actions' => array('create', 'update'),
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
        $model = new Financialyear;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Financialyear'])) {
            if ($_POST['Financialyear']['status'] === '1') {
                $financialyear = Financialyear::model()->findAllByAttributes(array('status' => 1));
                $count = count($financialyear);
            } else {
                $count = 0;
            }
            if ($count >= 1) {
                Yii::app()->user->setFlash('error', 'Only one financial year can be active.');
            } else {
                $model->attributes = $_POST['Financialyear'];

                if ($model->validate()) {
                    if ($model->save()) {
                        $this->redirect(array('create'));
                    }
                } else {
                    //error message
//                $error = CActiveForm::validate($model);
//                if ($error != '[]')
//                    echo $error;
                }
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

        if (isset($_POST['Financialyear'])) {

            if ($_POST['Financialyear']['status'] === '1') {
                $financialyear = Financialyear::model()->findAllByAttributes(array('status' => 1));
                $count = count($financialyear);
            } else {
                $count = 0;
            }
            if ($count >= 1) {
                $activeyear = Financialyear::model()->findByAttributes(array('status' => 1));
                if ($id === $activeyear->financialyearid) { //! checks if edited Financial year details is equal to the active Financial year details
                    $model->attributes = $_POST['Financialyear'];

                    if ($model->save()) {
                        $this->redirect(array('create'));
                    }
                } else {
                    Yii::app()->user->setFlash('error', 'Activated financial year is already exists!');
                    $this->redirect(array('create'));
                }
            } else {
                $model->attributes = $_POST['Financialyear'];
                if ($model->save()) {
                    $this->redirect(array('create'));
                }
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Financialyear the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Financialyear::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Financialyear $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'financialyear-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
