<?php

/**
 * This is the model class for table "jobtitle".
 *
 * The followings are the available columns in table 'jobtitle':
 * @property integer $jobtitleid
 * @property string $jobtitle_title
 * @property string $jobtitle_description
 * @property string $jobtitle_specification
 * @property integer $financialyearid
 * @property integer $companyid
 */
class Jobtitle extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jobtitle';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jobtitle_title', 'required'),
            array('financialyearid, companyid', 'numerical', 'integerOnly' => true),
            array('jobtitle_title', 'length', 'max' => 100),
            array('jobtitle_description', 'length', 'max' => 256),
            array('jobtitle_specification', 'length', 'max' => 45),
             array('jobtitle_title','unique','message'=>'{attribute}:{value} already exists!'),
            array('jobtitle_specification', 'file', 'allowEmpty' => true, 'types' => 'jpg,gif,png,docx, txt, doc,xls,xl', 'message' => 'The file extension was not allowed. Allowed extenstions are jpg,gif,png,docx, txt, doc,xls,xl.', 'on' => 'insert', 'on' => 'update'),
            array('jobtitle_specification', 'file', 'allowEmpty' => true, 'safe' => true, 'types' => 'jpg,gif,png,docx, txt, doc,xls,xl', 'maxSize' => (1024 * 1024 * 1), 'message' => 'The file was larger than 1mb. Please upload a smaller file.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('jobtitleid, jobtitle_title, jobtitle_description, jobtitle_specification, financialyearid, companyid', 'safe', 'on' => 'search'),
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
            'jobtitleid' => 'Jobtitleid',
            'jobtitle_title' => 'Title',
            'jobtitle_description' => 'Description',
            'jobtitle_specification' => 'Specification',
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
        $criteria->compare('jobtitleid', $this->jobtitleid);
        $criteria->compare('jobtitle_title', $this->jobtitle_title, true);
        $criteria->compare('jobtitle_description', $this->jobtitle_description, true);
        $criteria->compare('jobtitle_specification', $this->jobtitle_specification, true);
       $criteria->compare('financialyearid',$financialyear->financialyearid);
		$criteria->compare('companyid',Yii::app()->user->companyid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Jobtitle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
