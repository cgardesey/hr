<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Bank Details</span></li>
        </ul>
    </div>
    <h3 class="page-title">Employee Bank Details</h3>
    <div class="row">
        <div class="col-md-12">
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
             <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?php
                    echo Yii::app()->user->getFlash('error');
                    Yii::app()->clientScript->registerScript(
                            'myHideEffect', '$(".alert alert-danger").animate({opacity: 1.0}, 1000).fadeOut("slow");', CClientScript::POS_READY
                    );
                    ?>
                </div>
            <?php endif; ?>
            <div class="portlet-title tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab_1_1" aria-expanded="true">Add Bank Details</a></li>
                    <li class=""><a data-toggle="tab" href="#tab_1_2" aria-expanded="false">View Bank Details</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="tab_1_1" class="tab-pane active">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'bankdetails-form',
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
                     * _form is used to enter the bank details
                     */
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group col-sm-6">
                                <label for="reg_input">Designation</label>
                                <?php
                                $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
 //! Designation of employee
                                $desig = CHtml::listData(Designation::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'designationid', 'designation_name');
                                echo CHtml::activeDropDownList($model, 'designationid', $desig, array(
                                    'empty' => 'Please Select', 'class' => "form-control",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => CController::createUrl('Bankdetails/Fetchemployee'),
                                        'update' => '#' . CHtml::activeId($model, 'employeeid'))
                                ));
                                echo $form->error($model, 'designationid', array('class' => 'school_val_error'));
                                ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="reg_input">Employee Name</label>
                                <?php
                                 //! Namne of employee
                                echo $form->dropDownList($model, 'employeeid', array(), array('prompt' => 'Select Employee', 'class' => "form-control"));
                                echo $form->error($model, 'employeeid', array('class' => 'school_val_error'));
                                ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="reg_input_name" class="req">Bank Name</label>
                                <?php echo $form->textField($model, 'bank_name', array('class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_name', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php echo $form->label($model, 'bank_branch', array('class' => 'req')); ?>
                                <?php echo $form->textField($model, 'bank_branch', array('class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_branch', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php
//! Address of bank
                                echo $form->label($model, 'bank_address', array('class' => 'req'));
                                ?>
                                <?php echo $form->textArea($model, 'bank_address', array('class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_address', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php
//! Phone number of bank
                                echo $form->label($model, 'bank_phone', array('class' => 'req'));
                                ?>
                                <?php echo $form->textField($model, 'bank_phone', array('size' => 15, 'maxlength' => 15, 'class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_phone', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php
//! IFSC code of bank
                                echo $form->label($model, 'bank_ifsc', array('class' => 'req'));
                                ?>
                                <?php echo $form->textField($model, 'bank_ifsc', array('size' => 60, 'maxlength' => 60, 'class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_ifsc', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php
//! account number of employee
                                echo $form->label($model, 'bank_accountno', array('class' => 'req'));
                                ?>
                                <?php echo $form->textField($model, 'bank_accountno', array('size' => 60, 'maxlength' => 60, 'class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_accountno', array('class' => 'school_val_error')); ?>
                            </div>

                            <div class="form-group col-sm-6">
                                <?php
//! DD address
                                echo $form->labelEx($model, 'bank_ddpayableaddress');
                                ?>
                                <?php echo $form->textArea($model, 'bank_ddpayableaddress', array('class' => "form-control")); ?>
                                <?php echo $form->error($model, 'bank_ddpayableaddress', array('class' => 'school_val_error')); ?>
                            </div>
                            <div class="col-sm-5">
                                <label>&nbsp;</label>
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
                    <?php $this->endWidget(); ?>
                </div>
                <div id="tab_1_2" class="tab-pane">
                     <?php
                /* !
                  Displaying the departmnet wise Bank details of  employees
                 */
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'bankdetails2-form',
                    'enableClientValidation' => true,
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
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">List</h4>
                            </div>
                            <div class="panel-body">

                                <div class="form-group col-sm-4">
                                    <label for="reg_input">Department</label>
                                    <?php
                                    $department = CHtml::listData(Department::model()->findAll('financialyearid=' . $financialyear->financialyearid.' AND companyid='.Yii::app()->user->companyid), 'departmentid', 'department_name');
                                    echo CHtml::activeDropDownList($model, 'departmentid', $department, array(
                                        'empty' => 'Please Select', 'class' => "form-control",));
                                    echo $form->error($model, 'departmentid', array('class' => 'school_val_error'));
                                    ?>
                                </div>
                                <div valign="top" align="center">
                                    <br/><br/>
                                    <input type="button" onclick="printDiv('print')" value="Print Report" class="btn btn-danger"/>
                                    <?php
//                                            $this->widget('ext.mPrint.mPrint', array(
//                                                'title' => 'Custom Certificate',
//                                                'tooltip' => '',
//                                                'text' => 'PRINT',
//                                                'element' => '#print',
//                                                'publishCss' => true,
//                                                'id' => 'PRINT_BUTTON_ID',
//                                                'htmlOptions' => array('class' => 'btn btn-danger pull-center'),
//                                            ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                <br />

                <div class="row" id="print">
                    <div class="col-sm-12">
                        <div class="panel panel-default"  id="listall" style="display:none">
                            <div class="panel-heading">
                                <h4 class="panel-title">Bank Details</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table responsive table table-bordered table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="display:none"></th>
                                            <th width="16.6%">Employee Code</th>
                                            <th width="16.7%">Employee Name</th>
                                            <th width="16.8%">Bank</th> 
                                            <th width="16.7%">Branch</th> 
                                            <th width="16.6%">Account No.</th> 
                                            <th width="16.6%">IFSC Code</th> 
                                        </tr>
                                    </thead>
                                    <tbody id="banklistalldetails">


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var droplist = $('#Bankdetails_departmentid');
        droplist.change(function () {

            if ($("#Bankdetails_departmentid").val() === "") {
                alert("Please select an Department");
                return;
            }
            $.ajax({
                type: "POST",
                url: "getbanklistall",
                data: {departmentid: $('#Bankdetails_departmentid option:selected').val()},
                dataType: "html",
                success: function (data) {
                    $('#banklistalldetails').empty();
                    $('#banklistalldetails').append(data);
                    $("#listall").show("slow");
                }
            });
        })
    });


    function printDiv(divName) {
//        var printContents = document.getElementById(divName).innerHTML;
//        var originalContents = document.body.innerHTML;
//
//        document.body.innerHTML = printContents;
//
//        window.print();
//
//        document.body.innerHTML = originalContents;
        var divToPrint = document.getElementById(divName);
        var popupWin = window.open('', '', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }


</script>