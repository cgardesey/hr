<?php

/**
 * This is the model class for table "jobdetails".
 *
 * The followings are the available columns in table 'jobdetails':
 * @property integer $jobdetailsid
 * @property string $jobdetails_subunit
 * @property string $jobdetails_location
 * @property integer $employeeid
 * @property integer $financialyearid
 * @property integer $companyid
 * @property integer $workshiftid
 * @property integer $jobcategoryid
 * @property integer $jobtitleid
 * @property string $job_specification
 * @property integer $employementstatusid
 */
class Jobdetails extends CActiveRecord {

    public $departmentid;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jobdetails';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employeeid,workshiftid, jobcategoryid, jobtitleid,employementstatusid', 'required'),
            array('employeeid, financialyearid, companyid, workshiftid, jobcategoryid, jobtitleid, employementstatusid', 'numerical', 'integerOnly' => true),
            array('jobdetails_subunit', 'length', 'max' => 45),
//            array('jobdetails_location, job_specification', 'length', 'max' => 60),
             array('jobdetails_location', 'file', 'allowEmpty' => true, 'types' => 'jpg,gif,png,docx, txt, doc,xls,xl', 'message' => 'The file extension was not allowed. Allowed extenstions are jpg,gif,png,docx, txt, doc,xls,xl.', 'on' => 'insert', 'on' => 'update'),
            array('jobdetails_location', 'file', 'allowEmpty' => true, 'safe' => true, 'types' => 'jpg,gif,png,docx, txt, doc,xls,xl', 'maxSize' => (1024 * 1024 * 1), 'message' => 'The file was larger than 1mb. Please upload a smaller file.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('jobdetailsid, jobdetails_subunit, jobdetails_location, employeeid, financialyearid, companyid, workshiftid, jobcategoryid, jobtitleid, job_specification, employementstatusid', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
            'jobcategory' => array(self::BELONGS_TO, 'Jobcategory', 'jobcategoryid'),
            'jobtitle' => array(self::BELONGS_TO, 'Jobtitle', 'jobtitleid'),
            'workshift' => array(self::BELONGS_TO, 'Workshift', 'workshiftid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'jobdetailsid' => 'Jobdetailsid',
            'jobdetails_subunit' => 'Subunit',
            'jobdetails_location' => 'Location',
            'employeeid' => 'Employee Name',
            'financialyearid' => 'Financialyearid',
            'companyid' => 'Companyid',
            'workshiftid' => 'Workshift',
            'jobcategoryid' => 'Jobcategory',
            'jobtitleid' => 'Job Title',
            'job_specification' => 'Job Specification',
            'employementstatusid' => 'Employment Status',
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
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details

        $criteria->compare('jobdetailsid', $this->jobdetailsid);
        $criteria->compare('jobdetails_subunit', $this->jobdetails_subunit, true);
        $criteria->compare('jobdetails_location', $this->jobdetails_location, true);
        $criteria->compare('employeeid', $this->employeeid);
        $criteria->compare('financialyearid', $financialyear->financialyearid);
        $criteria->compare('companyid', Yii::app()->user->companyid);
        $criteria->compare('workshiftid', $this->workshiftid);
        $criteria->compare('jobcategoryid', $this->jobcategoryid);
        $criteria->compare('jobtitleid', $this->jobtitleid);
        $criteria->compare('job_specification', $this->job_specification, true);
        $criteria->compare('employementstatusid', $this->employementstatusid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Jobdetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
