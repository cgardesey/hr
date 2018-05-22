<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $employeeid
 * @property string $employee_code
 * @property string $employee_firstname
 * @property string $employee_middlename
 * @property string $employee_lastname
 * @property string $employee_joiningdate
 * @property string $employee_qualification
 * @property string $employee_totalexperiance
 * @property integer $financialyearid
 * @property integer $companyid
 * @property integer $departmentid
 * @property integer $designationid
 * @property integer $usertypeid
 * @property string $employee_dob
 * @property string $employee_gender
 * @property string $employee_address1
 * @property string $employee_address2
 * @property string $employee_country
 * @property string $employee_state
 * @property string $employee_city
 * @property string $employee_pincode
 * @property string $employee_phone
 * @property string $employee_mobile
 * @property string $employee_email
 * @property string $employee_photo
 * @property string $employee_status
 * @property string $termination_date
 * @property string $termination_reason
 */
class Employee extends CActiveRecord {
    public  $jobcategoryid;
    public $report;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'employee';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_code, employee_firstname, employee_joiningdate, employee_qualification, employee_totalexperiance,departmentid, designationid, usertypeid,divisionid, employee_dob, employee_gender,employee_address2,employee_mobile, employee_email', 'required'),
            array('financialyearid, companyid, departmentid, designationid, usertypeid', 'numerical', 'integerOnly' => true),
            array('employee_code, employee_firstname, employee_middlename, employee_lastname, employee_qualification, employee_totalexperiance, employee_country, employee_state, employee_city, employee_pincode, employee_email, employee_photo, employee_status', 'length', 'max' => 45),
            array('employee_gender', 'length', 'max' => 10),
            array('employee_address1, employee_address2, termination_reason', 'length', 'max' => 256),
            array('employee_phone, employee_mobile', 'length', 'max' => 15),
            array('employee_joiningdate, employee_dob, termination_date', 'safe'),
            array('employee_qualification', 'match',
                'pattern' => '/^[a-zA-Z0-9 +-.,]+$/',
                'message' => 'Qualification should contain only alphanumeric characters, space, plus, dot, comma and hyphon.'),
            array('employee_pincode', 'match',
                'pattern' => '/^[a-zA-Z0-9 -]+$/',
                'message' => 'Pin code should contain only alphanumeric characters, space and hyphon.'),
            array('employee_mobile,employee_phone', 'match',
                'pattern' => '/^[0-9 +]+$/',
                'message' => '{attribute} should contain only numbers plus and space.'),
            array('employee_email', 'email', 'message' => 'Please Enter Valid Email'),
            array('employee_email', 'unique', 'message' => 'Email already exists!', 'on' => 'insert'),
            array('employee_photo', 'file', 'types' => 'jpg,gif,png', 'allowEmpty' => true, 'on' => 'insert', 'on' => 'update'),
            array('employee_photo', 'file', 'safe' => true, 'allowEmpty' => true, 'types' => 'jpg, jpeg, png', 'maxSize' => (1024 * 24), 'message' => 'The file was larger than 24kb. Please upload a smaller file.'),
            array('employee_photo', 'validateImage'),
             array('employee_firstname, employee_middlename, employee_lastname', 'match',
                'pattern' => '/^[a-zA-Z\s]+$/',
                'message' => 'Name can only contain word characters'),
            array('employee_dob', 'safe'),
            array('employee_dob', 'isDateGreater'),
            array('employee_joiningdate', 'isjoinDateGreater'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('employeeid, employee_code, employee_firstname, employee_middlename, employee_lastname, employee_joiningdate, employee_qualification, employee_totalexperiance, financialyearid, companyid, departmentid, designationid, usertypeid, employee_dob, employee_gender, employee_address1, employee_address2, employee_country, employee_state, employee_city, employee_pincode, employee_phone, employee_mobile, employee_email, employee_photo, employee_status, termination_date, termination_reason', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'department' => array(self::BELONGS_TO, 'Department', 'departmentid'),
            'designation' => array(self::BELONGS_TO, 'Designation', 'designationid'),
            'usertype' => array(self::BELONGS_TO, 'Usertype', 'usertypeid'),
            'division' => array(self::BELONGS_TO, 'Division', 'divisionid'),
             'company' => array(self::BELONGS_TO, 'Company', 'companyid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'employeeid' => 'Employeeid',
            'employee_code' => 'Employee Code',
            'employee_firstname' => 'Employee Firstname',
            'employee_middlename' => 'Employee Middlename',
            'employee_lastname' => 'Employee Lastname',
            'employee_joiningdate' => 'Joiningdate',
            'employee_qualification' => 'Qualification',
            'employee_totalexperiance' => 'Total Experiance',
            'financialyearid' => 'Financialyear',
            'companyid' => 'Company',
            'departmentid' => 'Department',
            'designationid' => 'Designation',
            'usertypeid' => 'User Type',
            'employee_dob' => 'Employee Dob',
            'employee_gender' => 'Gender',
            'employee_address1' => 'Address1',
            'employee_address2' => 'Address2',
            'employee_country' => 'Country',
            'employee_state' => 'State',
            'employee_city' => 'City',
            'employee_pincode' => 'Pincode',
            'employee_phone' => 'Phone',
            'employee_mobile' => 'Mobile',
            'employee_email' => 'Email',
            'employee_photo' => 'Photo',
            'employee_status' => 'Status',
            'termination_date' => 'Termination Date',
            'termination_reason' => 'Termination Reason',
             'divisionid' => 'Division',
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

        $criteria = new CDbCriteria;

        $criteria->order = 'employeeid DESC';

      $searchterm = empty($searchterm) ? trim(Yii::app()->request->getParam('search')) : $searchterm;
        $criteria->with = array('department','designation','division','usertype');
        $searchterm = htmlspecialchars($searchterm, ENT_QUOTES);
        if (!empty($searchterm)) {
            $criteria->addCondition('t.employee_code like "' . $searchterm . '%" OR
                        t.employee_firstname like "' . $searchterm . '%" AND
                                t.employee_status = "1" AND t.companyid ='.Yii::app()->user->companyid);
        } else {
            $criteria->condition = 't.employee_status = "1" AND t.companyid ='.Yii::app()->user->companyid;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pagesize' => 25,
            )
        ));
    }
//    public function search() {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('employeeid', $this->employeeid);
//        $criteria->compare('employee_code', $this->employee_code, true);
//        $criteria->compare('employee_firstname', $this->employee_firstname, true);
//        $criteria->compare('employee_middlename', $this->employee_middlename, true);
//        $criteria->compare('employee_lastname', $this->employee_lastname, true);
//        $criteria->compare('employee_joiningdate', $this->employee_joiningdate, true);
//        $criteria->compare('employee_qualification', $this->employee_qualification, true);
//        $criteria->compare('employee_totalexperiance', $this->employee_totalexperiance, true);
//        $criteria->compare('financialyearid', $this->financialyearid);
//        $criteria->compare('companyid', $this->companyid);
//        $criteria->compare('departmentid', $this->departmentid);
//        $criteria->compare('designationid', $this->designationid);
//        $criteria->compare('usertypeid', $this->usertypeid);
//        $criteria->compare('employee_dob', $this->employee_dob, true);
//        $criteria->compare('employee_gender', $this->employee_gender, true);
//        $criteria->compare('employee_address1', $this->employee_address1, true);
//        $criteria->compare('employee_address2', $this->employee_address2, true);
//        $criteria->compare('employee_country', $this->employee_country, true);
//        $criteria->compare('employee_state', $this->employee_state, true);
//        $criteria->compare('employee_city', $this->employee_city, true);
//        $criteria->compare('employee_pincode', $this->employee_pincode, true);
//        $criteria->compare('employee_phone', $this->employee_phone, true);
//        $criteria->compare('employee_mobile', $this->employee_mobile, true);
//        $criteria->compare('employee_email', $this->employee_email, true);
//        $criteria->compare('employee_photo', $this->employee_photo, true);
//        $criteria->compare('employee_status', $this->employee_status, true);
//        $criteria->compare('termination_date', $this->termination_date, true);
//        $criteria->compare('termination_reason', $this->termination_reason, true);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }

    public function validateImage($attribute) {
        $file = CUploadedFile::getInstance($this, $attribute);
        if (!$file) {
            return;
        }
        // http://php.net/manual/en/function.imagecreatefromstring.php
        // These types will be automatically detected if your build of PHP supports them: JPEG, PNG, GIF, WBMP, and GD2
        $gd = @imagecreatefromstring(file_get_contents($file->getTempName()));
        if ($gd === false) {
            $this->addError($attribute, 'Image is corrupted');
        }
    }
     public function isDateGreater($attribute, $params) {
        $timezone = new DateTimeZone(Yii::app()->params['timezone']);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $date = $date->format('Y-m-d');

        if (strtotime($date) <= strtotime($this->employee_dob))
            $this->addError('employee_dob', 'Date of birth should be less than today' . "'" . 's date.');
    }

    public function isjoinDateGreater($attribute, $params) {
        $timezone = new DateTimeZone(Yii::app()->params['timezone']);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $date = $date->format('Y-m-d');

        if (strtotime($date) < strtotime($this->employee_joiningdate))
            $this->addError('employee_joiningdate', 'Joining date should be less than or equal to today' . "'" . 's date.');
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Employee the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
