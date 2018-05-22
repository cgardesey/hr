<?php

/**
 * This is the model class for table "designation".
 *
 * The followings are the available columns in table 'designation':
 * @property integer $designationid
 * @property string $designation_name
 * @property integer $financialyearid
 * @property integer $companyid
 * @property integer $departmentid
 * @property integer $divisionid
 * @property integer $jobcategoryid
 */
class Designation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'designation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('designation_name,departmentid, divisionid, jobcategoryid', 'required'),
            array('financialyearid, companyid, departmentid, divisionid, jobcategoryid', 'numerical', 'integerOnly' => true),
            array('designation_name', 'length', 'max' => 60),
            array('designation_name', 'unique', 'message' => '{attribute}:{value} already exists!'),
            array('designation_name', 'match',
                'pattern' => '/^[a-zA-Z]{1}[a-zA-Z0-9 _.-]*$/',
                'message' => 'Designation name should contain only alphabets, numbers, space, dot, hyphen and underscore and first character must be alphabet.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('designationid, designation_name, financialyearid, companyid, departmentid, divisionid, jobcategoryid', 'safe', 'on' => 'search'),
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
            'division' => array(self::BELONGS_TO, 'Division', 'divisionid'),
            'jobcategory' => array(self::BELONGS_TO, 'Jobcategory', 'jobcategoryid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'designationid' => 'Designationid',
            'designation_name' => 'Designation Name',
            'financialyearid' => 'Financialyearid',
            'companyid' => 'Companyid',
            'departmentid' => 'Department',
            'divisionid' => 'Division',
            'jobcategoryid' => 'Jobcategory',
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
        $criteria->compare('designationid', $this->designationid);
        $criteria->compare('designation_name', $this->designation_name, true);
       $criteria->compare('financialyearid',$financialyear->financialyearid);
		$criteria->compare('companyid',Yii::app()->user->companyid);
        $criteria->compare('departmentid', $this->departmentid);
        $criteria->compare('divisionid', $this->divisionid);
        $criteria->compare('jobcategoryid', $this->jobcategoryid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Designation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
