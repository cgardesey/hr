<?php

/**
 * This is the model class for table "financialyear".
 *
 * The followings are the available columns in table 'financialyear':
 * @property integer $financialyearid
 * @property string $financialyear_startyear
 * @property string $financialyear_endyear
 */
class Financialyear extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'financialyear';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('financialyear_startyear, financialyear_endyear', 'required'),
            array('financialyear_startyear, financialyear_endyear', 'length', 'max' => 45),
            array(
                'financialyear_endyear',
                'compare',
                'compareAttribute' => 'financialyear_startyear',
                'operator' => '>',
                'allowEmpty' => false,
                'message' => '{attribute} must be greater than "{compareValue}".'
            ),
            array('financialyear_startyear', 'unique', 'message' => '{attribute}:{value} already exists!'),
            array('financialyear_endyear', 'unique', 'message' => '{attribute}:{value} already exists!'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('financialyearid, financialyear_startyear, financialyear_endyear', 'safe', 'on' => 'search'),
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
            'financialyearid' => 'Financialyearid',
            'financialyear_startyear' => 'Start Year',
            'financialyear_endyear' => 'End Year',
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

        $criteria->compare('financialyearid', $this->financialyearid);
        $criteria->compare('financialyear_startyear', $this->financialyear_startyear, true);
        $criteria->compare('financialyear_endyear', $this->financialyear_endyear, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function status($status) {
        if ($status === '1') {
            return "Active";
        }
        if ($status === '2') {
            return "Deactive";
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Financialyear the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
