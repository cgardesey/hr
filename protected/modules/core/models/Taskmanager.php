<?php

/**
 * This is the model class for table "taskmanager".
 *
 * The followings are the available columns in table 'taskmanager':
 * @property integer $taskmanagerid
 * @property string $task_heading
 * @property string $task_description
 * @property integer $task_priority
 * @property string $task_date
 * @property integer $task_status
 * @property integer $usertypeid
 * @property integer $userid
 */
class Taskmanager extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'taskmanager';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('task_heading, task_description, task_priority, task_date, task_status, usertypeid', 'required'),
            array('task_priority, task_status, usertypeid, userid', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('taskmanagerid, task_heading, task_description, task_priority, task_date, task_status, usertypeid, userid', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'taskmanagerid' => 'Taskmanagerid',
            'task_heading' => 'Task',
            'task_description' => 'Task Description',
            'task_priority' => 'Task Priority',
            'task_date' => 'Task Date',
            'task_status' => 'Task Status',
            'usertypeid' => 'User Type',
            'userid' => 'Userid',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $usertype = Yii::app()->user->usertypeid;
        if ($usertype === '0') { //! User is super admin
            $usertypeid = $this->usertypeid;
            $userid = $this->userid;
        } else {
            //! Other users
            $employee = Employee::model()->findByPk(Yii::app()->user->userid);
            $usertypeid = $employee->usertypeid;
            $userid = Yii::app()->user->userid;
        }

        $criteria = new CDbCriteria;
        $criteria->order = 'taskmanagerid DESC';
        $criteria->compare('taskmanagerid', $this->taskmanagerid);
        $criteria->compare('task_heading', $this->task_heading, true);
        $criteria->compare('task_description', $this->task_description, true);
        $criteria->compare('task_priority', $this->task_priority);
        $criteria->compare('task_date', $this->task_date, true);
        $criteria->compare('task_status', $this->task_status);
        $criteria->compare('usertypeid', $usertypeid);
        $criteria->compare('userid', $userid);
       $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $criteria->compare('financialyearid', $financialyear->financialyearid);
        $criteria->compare('companyid', Yii::app()->user->companyid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterFind() {
        $originalDate = $this->task_date;
        $newDate = date("Y-M-d", strtotime($originalDate));
        $this->task_date = $newDate;

        parent::afterFind();
    }

    /*
     * A function
     * Used to get priority
     */

    public function getpriority($priority) {
        if ($priority === '1') {
            return "Highest";
        }
        if ($priority === '2') {
            return "High";
        }
        if ($priority === '3') {
            return "Normal";
        }
        if ($priority === '4') {
            return "Low";
        }
    }

    /*
     * A function
     * Used to get status
     */

    public function getstatus($status) {
        if ($status === '1') {
            return "Open";
        }
        if ($status === '2') {
            return "On hold";
        }
        if ($status === '3') {
            return "Resolved";
        }
        if ($status === '4') {
            return "Closed";
        }
    }

    /*
     * A function
     * Used to get user
     */

    public function getuser($usertypeid, $userid) {
            $employee = Employee::model()->findByAttributes(array('employeeid'=>$userid,'usertypeid'=>$usertypeid,'employee_status'=>'1'));
            return $employee->employee_code . " - " . $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname;
      
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Taskmanager the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
