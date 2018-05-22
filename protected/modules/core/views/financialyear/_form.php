<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Settings</span><i class="fa fa-circle"></i></li>
            <li><span>Financial Year</span></li>
        </ul>
    </div>
    <h3 class="page-title">Financial Year Details</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'financialyear-form',
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnChange' => true,
                        'validateOnSubmit' => true,
                    ),
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => true,
                ));
                /**
                 * _form is used to enter the financial year details
                 */
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        $yearNow = date("Y"); //!< $yearNow stores the current year
                        $yearFrom = $yearNow - 15; //!< $yearFrom stores the 15 years back from current year
                        $yearTo = $yearNow + 10; //!< $yearTo stores the 10 years after current year
                        $arrYears = array(); //! Used to store all values from $yearFrom to $yearTo
                        foreach (range($yearFrom, $yearTo) as $number) {
                            $arrYears[$number] = $number;
                        }
                        $arrYears = array_reverse($arrYears, true);


                        if (Yii::app()->user->hasFlash('error')):
                            ?>
                            <div class="alert alert-danger">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                                <?php
                                Yii::app()->clientScript->registerScript(
                                        'myHideEffect', '$(".alert alert-danger").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::app()->user->hasFlash('success')): ?>
                            <div class="alert alert-success">
                                <?php
                                echo Yii::app()->user->getFlash('success');
                                Yii::app()->clientScript->registerScript(
                                        'myHideEffect', '$(".alert alert-success").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="req">Start Year</label>
                            <?php
                            //! Drop down menu to select the financial start year
                            echo $form->dropDownList($model, 'financialyear_startyear', $arrYears, array('prompt' => "Select Year", 'class' => "form-control"));
                            echo $form->error($model, 'financialyear_startyear', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="req">End Year</label>
                            <?php
                            //! Drop down menu to select the financial end year
                            echo $form->dropDownList($model, 'financialyear_endyear', $arrYears, array('prompt' => "Select Year", 'class' => "form-control"));
                            echo $form->error($model, 'financialyear_endyear', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="req">Active / Deactive</label>
                            <?php
                            //! Drop down menu to select the financial end year
                            echo $form->dropDownList($model, 'status', array('1' => 'Active', '2' => 'Deactive'), array('prompt' => "Please Select", 'class' => "form-control"));
                            echo $form->error($model, 'status', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form_sep">
                                    <?php
                                    //! Submit button
                                    echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => "btn green", 'name' => "std_reg_submit", 'id' => "std_reg_submit",
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> 
                <?php $this->endWidget(); ?>
            </div>
            <div class="col-md-6">
                <?php
                //! Used to display all created values of financial year details.
                $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider' => $model->search(),
                    'id' => 'item-grid',
                    'selectableRows' => 1,
                    'ajaxUpdate' => false,
                    'hideHeader' => false,
                    'template' => "{items}\n{pager}",
                    'enableHistory' => false,
                    'enableSorting' => false,
                    'cssFile' => Yii::app()->baseUrl . '/css/grid.css',
                    'htmlOptions' => array('class' => 'grid-view'),
                    'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/grid.css',
                        'maxButtonCount' => 4,
                        'nextPageLabel' => '>',
                        'prevPageLabel' => '<',
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Sl.No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'htmlOptions' => array('width' => '5%'),
                        ),
                        array(
                            'name' => 'Start Year',
                            'value' => '$data->financialyear_startyear',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                        array(
                            'name' => 'End Year',
                            'value' => '$data->financialyear_endyear',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                        array(
                            'name' => 'Active/Deactive',
                            'value' => 'Financialyear::model()->status($data->status)',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                        array('class' => 'CButtonColumn',
                            'header' => 'Manage',
                            'template' => '{update}',
                            'htmlOptions' => array('width' => '5%'),
                            'buttons' => array(
                                'update' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-pencil'),
                                ),
//                                        'delete' => array(
//                                            'id' => $model->academicid,
//                                            'label' => '',
//                                            'imageUrl' => '',
//                                            'options' => array('class' => 'icon-cross2'),
//                                            'confirm' => 'Are you sure you want to delete this item?',
//                                        ),
                            ),
                        ),
                    ),
                ));
                ?> 

            </div>
        </div>
    </div>
</div>