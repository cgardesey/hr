<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $companyid
 * @property string $company_name
 * @property string $company_address
 * @property string $company_email
 * @property string $company_phone
 * @property string $company_mobile
 * @property string $company_fax
 * @property string $company_contactperson
 * @property string $company_country
 * @property string $company_state
 * @property string $company_currency
 * @property string $company_language
 * @property string $company_code
 * @property string $company_timezone
 * @property string $company_logo
 */
class Company extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_name,company_address,company_phone, company_mobile, company_email, company_fax, company_contactperson, company_country, company_state, company_language, company_code,company_currency, company_timezone', 'required'),
            array('company_name, company_email, company_fax, company_contactperson, company_country, company_state, company_language, company_code', 'length', 'max' => 45),
            array('company_address', 'length', 'max' => 256),
            array('company_phone, company_mobile', 'length', 'max' => 15),
            array('company_currency, company_timezone, company_logo', 'length', 'max' => 60),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('companyid, company_name, company_address, company_email, company_phone, company_mobile, company_fax, company_contactperson, company_country, company_state, company_currency, company_language, company_code, company_timezone, company_logo', 'safe', 'on' => 'search'),
            array('company_logo', 'file', 'types' => 'jpg, gif, png,gif', 'allowEmpty' => true, 'on' => 'insert', 'on' => 'update'),
            array('company_logo', 'file', 'safe' => true, 'allowEmpty' => true, 'types' => 'jpg, jpeg, png,gif', 'maxSize' => (1024 * 200), 'message' => 'The file was larger than 24kb. Please upload a smaller file.'),
            array('company_logo', 'validateImage'),
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
            'companyid' => 'Companyid',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_email' => 'Company Email',
            'company_phone' => 'Company Phone',
            'company_mobile' => 'Company Mobile',
            'company_fax' => 'Company Fax',
            'company_contactperson' => 'Company Contactperson',
            'company_country' => 'Company Country',
            'company_state' => 'Company State',
            'company_currency' => 'Company Currency',
            'company_language' => 'Company Language',
            'company_code' => 'Company Code',
            'company_timezone' => 'Company Timezone',
            'company_logo' => 'Company Logo',
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

        $criteria->compare('companyid', $this->companyid);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('company_email', $this->company_email, true);
        $criteria->compare('company_phone', $this->company_phone, true);
        $criteria->compare('company_mobile', $this->company_mobile, true);
        $criteria->compare('company_fax', $this->company_fax, true);
        $criteria->compare('company_contactperson', $this->company_contactperson, true);
        $criteria->compare('company_country', $this->company_country, true);
        $criteria->compare('company_state', $this->company_state, true);
        $criteria->compare('company_currency', $this->company_currency, true);
        $criteria->compare('company_language', $this->company_language, true);
        $criteria->compare('company_code', $this->company_code, true);
        $criteria->compare('company_timezone', $this->company_timezone, true);
        $criteria->compare('company_logo', $this->company_logo, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Company the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
