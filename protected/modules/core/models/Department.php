<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $departmentid
 * @property string $department_name
 * @property string $department_code
 * @property integer $financialyearid
 * @property integer $companyid
 */
class Department extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('department_name, department_code', 'required'),
			array('financialyearid, companyid', 'numerical', 'integerOnly'=>true),
			array('department_name, department_code', 'length', 'max'=>45),
                     array('department_name', 'match',
                     'pattern' => '/^[a-zA-Z]{1}[a-zA-Z0-9 _.-]*$/',
                     'message' => 'Department name should contain only alphabets, numbers, space, dot, hyphen and underscore and first character must be alphabet.'),
                    array('department_name','unique','message'=>'{attribute}:{value} already exists!'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('departmentid, department_name, department_code, financialyearid, companyid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'departmentid' => 'Departmentid',
			'department_name' => 'Department Name',
			'department_code' => 'Department Code',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
$financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
		$criteria->compare('departmentid',$this->departmentid);
		$criteria->compare('department_name',$this->department_name,true);
		$criteria->compare('department_code',$this->department_code,true);
		$criteria->compare('financialyearid',$financialyear->financialyearid);
		$criteria->compare('companyid',Yii::app()->user->companyid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
