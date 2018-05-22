<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Settings</span><i class="fa fa-circle"></i></li>
            <li><span>Add Work Shift</span></li>
        </ul>
    </div>
    <h3 class="page-title">Work Shift Details</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'workshift-form',
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
                 * _form is used to enter the work shift details
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
                            <?php
                            //! Textfield to enter name of workshift
                            echo $form->label($model, 'workshift_name', array('class' => 'req'));
                            echo $form->textField($model, 'workshift_name', array('class' => "form-control"));
                            echo $form->error($model, 'workshift_name', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group input-icon">
                            <label class="req">Start Time</label>
                            <i class="fa fa-clock-o"></i>
                            <?php
                            //! Textfield to enter workshift start time
                            echo $form->textField($model, 'workshift_starttime', array('class' => "form-control timepicker timepicker-default"));
                            echo $form->error($model, 'workshift_starttime', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group input-icon">
                            <label class="req">End Time</label>
                            <i class="fa fa-clock-o"></i>
                            <?php
                            //! Textfield to enter workshift end time
                            echo $form->textField($model, 'workshift_endtime', array('class' => "form-control timepicker timepicker-default"));
                            echo $form->error($model, 'workshift_endtime', array('class' => 'school_val_error'));
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            //! Textfield to enter name of workshift
                            echo $form->label($model, 'workshift_hoursperday', array('class' => 'req'));
                            echo $form->textField($model, 'workshift_hoursperday', array('class' => "form-control",'readonly'=>true));
                            echo $form->error($model, 'workshift_hoursperday', array('class' => 'school_val_error'));
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
                            'name' => 'Work Shift Name',
                            'value' => '$data->workshift_name',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                         array(
                            'name' => 'Start Time',
                            'value' => '$data->workshift_starttime',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                         array(
                            'name' => 'End Time',
                            'value' => '$data->workshift_endtime',
                            'htmlOptions' => array('width' => '15%'),
                        ),
                         array(
                            'name' => 'Hours Per Day',
                            'value' => '$data->workshift_hoursperday',
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
<script>
$('#Workshift_workshift_starttime').change(function () {
         var Time1 = $("#Workshift_workshift_starttime").val();
        var Time2 = $("#Workshift_workshift_endtime").val();
         $("#Workshift_workshift_hoursperday").empty(); 
         $.ajax({
            type: "POST",
            url: "gethoursperday",
            data: {starttime: Time1, endtime: Time2},
            dataType: "html",
            success: function (data) {
               $("#Workshift_workshift_hoursperday").val(data); 
            }
        });
    });
    $('#Workshift_workshift_endtime').change(function () {
//        var Time1 = $("#Workshift_workshift_starttime").val().split(' ');
//        var Time2 = $("#Workshift_workshift_endtime").val().split(' ');
         var Time1 = $("#Workshift_workshift_starttime").val();
        var Time2 = $("#Workshift_workshift_endtime").val();
         $("#Workshift_workshift_hoursperday").empty(); 
         $.ajax({
            type: "POST",
            url: "gethoursperday",
            data: {starttime: Time1, endtime: Time2},
            dataType: "html",
            success: function (data) {
               $("#Workshift_workshift_hoursperday").val(data); 
            }

        });
//        var time1 = Time1[0].split(':'), time2 = Time2[0].split(':');
//         var hours1 = parseInt(time1[0], 10), 
//             hours2 = parseInt(time2[0], 10),
//             mins1 = parseInt(time1[1], 10),
//             mins2 = parseInt(time2[1], 10);
//         var hours = hours2 - hours1, mins = 0;
//         if(hours <= 0) hours = 24 + hours;
//         if(mins2 >= mins1) {
//             mins = mins2 - mins1;
//         }
//         else {
//             mins = (mins2 + 60) - mins1;
//             hours--;
//         }
//         mins = mins / 60; // take percentage in 60
//         hours += mins;
//         hours = hours.toFixed(2);
//       $("#Workshift_workshift_hoursperday").val(hours);
    });


</script>