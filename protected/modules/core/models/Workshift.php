<?php

/**
 * This is the model class for table "workshift".
 *
 * The followings are the available columns in table 'workshift':
 * @property integer $workshiftid
 * @property string $workshift_name
 * @property string $workshift_starttime
 * @property string $workshift_endtime
 * @property string $workshift_hoursperday
 * @property integer $financialyearid
 * @property integer $companyid
 */
class Workshift extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'workshift';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('workshift_name, workshift_starttime, workshift_endtime, workshift_hoursperday', 'required'),
            array('financialyearid, companyid', 'numerical', 'integerOnly' => true),
            array('workshift_name', 'length', 'max' => 60),
            array('workshift_hoursperday', 'length', 'max' => 45),
            array('workshift_starttime, workshift_endtime', 'safe'),
//            array('workshift_endtime', 'isStarttimeGreater'),
            array('workshift_name', 'unique', 'message' => '{attribute}:{value} already exists!'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('workshiftid, workshift_name, workshift_starttime, workshift_endtime, workshift_hoursperday, financialyearid, companyid', 'safe', 'on' => 'search'),
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
            'workshiftid' => 'Workshiftid',
            'workshift_name' => 'Workshift Name',
            'workshift_starttime' => 'Starttime',
            'workshift_endtime' => 'Endtime',
            'workshift_hoursperday' => 'Hours per day',
            'financialyearid' => 'Financialyearid',
            'companyid' => 'Companyid',
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
        $criteria->compare('workshiftid', $this->workshiftid);
        $criteria->compare('workshift_name', $this->workshift_name, true);
        $criteria->compare('workshift_starttime', $this->workshift_starttime, true);
        $criteria->compare('workshift_endtime', $this->workshift_endtime, true);
        $criteria->compare('workshift_hoursperday', $this->workshift_hoursperday, true);
        $criteria->compare('financialyearid', $financialyear->financialyearid);
        $criteria->compare('companyid', Yii::app()->user->companyid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function isStarttimeGreater($attribute, $params) {

        if ($this->workshift_starttime >= $this->workshift_endtime)
            $this->addError('workshift_endtime', 'Endtime must be greater than starttime.');
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Workshift the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
