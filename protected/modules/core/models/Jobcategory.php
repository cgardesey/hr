<?php

/**
 * This is the model class for table "jobcategory".
 *
 * The followings are the available columns in table 'jobcategory':
 * @property integer $jobcategoryid
 * @property string $jobcategory_name
 * @property integer $financialyearid
 * @property integer $companyid
 * @property integer $divisionid
 * @property integer $departmentid
 */
class Jobcategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jobcategory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('divisionid, departmentid,jobcategory_name', 'required'),
            array('financialyearid, companyid, divisionid, departmentid', 'numerical', 'integerOnly' => true),
            array('jobcategory_name', 'length', 'max' => 60),
             array('jobcategory_name','unique','message'=>'{attribute}:{value} already exists!'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('jobcategoryid, jobcategory_name, financialyearid, companyid, divisionid, departmentid', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'jobcategoryid' => 'Jobcategoryid',
            'jobcategory_name' => 'Jobcategory Name',
            'financialyearid' => 'Financialyearid',
            'companyid' => 'Companyid',
            'divisionid' => 'Division',
            'departmentid' => 'Department',
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
        $criteria->compare('jobcategoryid', $this->jobcategoryid);
        $criteria->compare('jobcategory_name', $this->jobcategory_name, true);
        $criteria->compare('financialyearid',$financialyear->financialyearid);
		$criteria->compare('companyid',Yii::app()->user->companyid);
        $criteria->compare('divisionid', $this->divisionid);
        $criteria->compare('departmentid', $this->departmentid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Jobcategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
