<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Settings</span><i class="fa fa-circle"></i></li>
            <li><span>Add Job Title</span></li>
        </ul>
    </div>
    <h3 class="page-title">Job Title Details</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'jobtitle-form',
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
                      'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                        ),
                ));
                /**
                 * _form is used to enter the job title details
                 */
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if (Yii::app()->user->hasFlash('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                                <?php
                                Yii::app()->clientScript->registerScript(
                                        'myHideEffect', '$(".alert alert-danger").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="reg_input_name" class="req">Job Title</label>
                            <?php
                            //! Text field to enter job title
                            echo $form->textField($model, 'jobtitle_title', array('class' => "form-control"));
                            echo $form->error($model, 'jobtitle_title', array('class' => 'school_val_error'));
                            ?>                
                        </div>
                        <div class="form-group">
                            <label for="reg_input_name">Description</label>
                            <?php
                            //! Text area to enter name of the description
                            echo $form->textArea($model, 'jobtitle_description', array('class' => "form-control"));
                            echo $form->error($model, 'jobtitle_description', array('class' => 'school_val_error'));
                            ?>                
                        </div>
                         <div class="form-group">
                        <label for="reg_input_name">Specification</label>
                        <?php
                        //! Button to upload photo of the employee
                        echo CHtml::activeFileField($model, 'jobtitle_specification');
                        echo $form->error($model, 'jobtitle_specification', array('class' => 'school_val_error'));
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
                //! Used to display all created values of job title details.
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
                    'htmlOptions' => array('class' => 'grid-view table-responsive'),
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
                            'name' => 'Job Title',
                            'value' => '$data->jobtitle_title',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array(
                            'name' => 'Description',
                            'value' => '$data->jobtitle_description',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array(
                            'name' => 'Specification',
                            'value' => '$data->jobtitle_specification',
                            'htmlOptions' => array('width' => '30%'),
                        ),
                        array('class' => 'CButtonColumn',
                            'header' => 'Manage',
                            'template' => '{update} {delete}',
                            'htmlOptions' => array('width' => '5%'),
                            'buttons' => array(
                                'update' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-pencil'),
                                ),
                                'delete' => array(
                                    'label' => '',
                                    'imageUrl' => '',
                                    'options' => array('class' => 'glyphicon glyphicon-remove'),
                                    'confirm' => 'Are you sure you want to delete this item?',
                                ),
                            ),
                        ),
                    ),
                ));
                ?> 

            </div>
        </div>
    </div>
</div>