<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'Fetchbatch'),
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

    public function actionFetchbatch() {
        $data = Batch::model()->findAll('parent_id=:parent_id', array(':parent_id' => (int) $_POST['courseid']));

        $data = CHtml::listData($data, 'batchid', 'batch_name');
        foreach ($data as $value => $subcategory) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($subcategory), true);
        }
    }

    public function init() {
        $model = new UserLogin;
        // filter out garbage requests
        $uri = Yii::app()->request->requestUri;
        if (strpos($uri, 'favicon') || strpos($uri, 'robots'))
            $this->render(Yii::app()->request->requestUrl.'/user/user/login', array('model' => $model));
    }

}
