<?php

/**
 * This is the model class for table "todo".
 *
 * The followings are the available columns in table 'todo':
 * @property integer $todoid
 * @property string $todo_content
 * @property integer $companyid
 */
class Todo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'todo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('todo_content', 'required'),
            array('companyid', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('todoid, todo_content, companyid', 'safe', 'on' => 'search'),
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
            'todoid' => 'Todoid',
            'todo_content' => 'Todo Content',
            'companyid' => 'Institutionid',
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
        $criteria->order = 'todoid DESC';
        $criteria->compare('todoid', $this->todoid);
        $criteria->compare('todo_content', $this->todo_content, true);
           $criteria->compare('todo_date', $this->todo_date, true);
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $criteria->compare('financialyearid', $financialyear->financialyearid);
        $criteria->compare('companyid', Yii::app()->user->companyid);
        $criteria->compare('usertypeid', $this->usertypeid);
        $criteria->compare('userid', $this->userid);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
      protected function afterFind() {
//        $originalDate = $this->todo_date;
//        $newDate = date("d-M-y", strtotime($originalDate));
//        $this->todo_date = $newDate;

        parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Todo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
