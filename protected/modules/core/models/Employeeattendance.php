<?php

/*
  // Copyright (c) 2015 All Right Reserved, http://www.webschool.com
  //
  // This source is subject to the Gescis License.
  // All other rights reserved.
  //
  // THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
  // KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
  // IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
  // PARTICULAR PURPOSE.

  @(#)Project:        					Human Flow
  @(#)Version:        					v1.0
  @(#)Initial Development Completion:                     Date: 2016-06-26
  @(#)Developers:     					 Arya K Nair,Prathibha Mohan V
  @(#)Copyright:      					(C) Gescis Technologies, Technopark
  @(#)Product:        					Human Flow.
  @(#)Template:        					Multiple templates developed by Gescis.
 */

/**
 * This is the model class for table "employeeattendance".
 *
 * The followings are the available columns in table 'employeeattendance':
 * @property integer $employeeattendanceid
 * @property integer $employeeid
 * @property string $date
 * @property string $intime
 * @property string $outtime
 * @property string $remarks
 */
class Employeeattendance extends CActiveRecord {

    public $departmentid;
    public $departmentid1;
    public $date15;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'employeeattendance';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, intime, outtime, remarks', 'required'),
            array('employeeid', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('employeeattendanceid, employeeid, date, intime, outtime, remarks', 'safe', 'on' => 'search'),
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
            'employeeattendanceid' => 'Employeeattendanceid',
            'employeeid' => 'Employeemasterid',
            'date' => 'Date',
            'intime' => 'Intime',
            'outtime' => 'Outtime',
            'remarks' => 'Remarks',
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
        $criteria->compare('employeeattendanceid', $this->employeeattendanceid);
        $criteria->compare('employeeid', $this->employeeid);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('intime', $this->intime, true);
        $criteria->compare('outtime', $this->outtime, true);
        $criteria->compare('remarks', $this->remarks, true);
       $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        $criteria->compare('financialyearid', $financialyear->financialyearid);
        $criteria->compare('companyid', Yii::app()->user->companyid);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Employeeattendance the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
