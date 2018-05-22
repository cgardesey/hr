<?php

/**
 * This is the model class for table "bankdetails".
 *
 * The followings are the available columns in table 'bankdetails':
 * @property integer $bankdetailsid
 * @property string $bank_name
 * @property integer $employeeid
 * @property string $bank_address
 * @property string $bank_phone
 * @property string $bank_branch
 * @property string $bank_ifsc
 * @property string $bank_accountno
 * @property string $bank_ddpayableaddress
 * @property integer $financialyearid
 * @property integer $companyid
 */
class Bankdetails extends CActiveRecord {

    public $designationid;
    public $departmentid;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bankdetails';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bank_name, employeeid, bank_address, bank_phone, bank_branch, bank_ifsc, bank_accountno', 'required'),
            array('employeeid, financialyearid, companyid', 'numerical', 'integerOnly' => true),
            array('bank_name', 'length', 'max' => 100),
            array('bank_address, bank_phone, bank_branch, bank_ifsc, bank_accountno, bank_ddpayableaddress', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('bankdetailsid, bank_name, employeeid, bank_address, bank_phone, bank_branch, bank_ifsc, bank_accountno, bank_ddpayableaddress, financialyearid, companyid', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bankdetailsid' => 'Bankdetailsid',
            'bank_name' => 'Bank Name',
            'employeeid' => 'Employee Name',
            'bank_address' => 'Bank Address',
            'bank_phone' => 'Bank Phone',
            'bank_branch' => 'Bank Branch',
            'bank_ifsc' => 'Bank Ifsc',
            'bank_accountno' => 'Bank Accountno',
            'bank_ddpayableaddress' => 'Bank Ddpayableaddress',
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
        $criteria->compare('bankdetailsid', $this->bankdetailsid);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('employeeid', $this->employeeid);
        $criteria->compare('bank_address', $this->bank_address, true);
        $criteria->compare('bank_phone', $this->bank_phone, true);
        $criteria->compare('bank_branch', $this->bank_branch, true);
        $criteria->compare('bank_ifsc', $this->bank_ifsc, true);
        $criteria->compare('bank_accountno', $this->bank_accountno, true);
        $criteria->compare('bank_ddpayableaddress', $this->bank_ddpayableaddress, true);
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
     * @return Bankdetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
