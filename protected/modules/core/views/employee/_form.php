<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Settings</span><i class="fa fa-circle"></i></li>
            <li><span>Company Details</span></li>
        </ul>
    </div>
    <h3 class="page-title">Company Details</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab_1_1" aria-expanded="true">Add Company Details</a></li>
                    <li class=""><a data-toggle="tab" href="#tab_1_2" aria-expanded="false">View Company Details</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="tab_1_1" class="tab-pane active">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'company-form',
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
                     * _form is used to enter the company details
                     */
                    ?>
                    <div class="pane pane-default">
                        <div class="panel-body">
                            <div class="form-group col-sm-6">
                                <label class="req">Company Name</label>
                                <?php
                                //! Text field is used to enter company name
                                echo $form->textField($model, 'company_name', array('class' => "form-control"));
                                echo $form->error($model, 'company_name', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="req">Company Address</label>
                                <?php
                                //! Text area to enter company address
                                echo $form->textArea($model, 'company_address', array('class' => "form-control"));
                                echo $form->error($model, 'company_address', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Company Email</label>
                                <?php
                                //! Text field to enter company email
                                echo $form->textField($model, 'company_email', array('class' => "form-control"));
                                echo $form->error($model, 'company_email', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Company Phone</label>
                                <?php
                                //! text field is to enter company phone
                                echo $form->textField($model, 'company_phone', array('class' => "form-control"));
                                echo $form->error($model, 'company_phone', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Company Mobile</label>
                                <?php
                                //! text field is to enter company mobile
                                echo $form->textField($model, 'company_mobile', array('class' => "form-control"));
                                echo $form->error($model, 'company_mobile', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Company Fax</label>
                                <?php
                                //! text field to neter company fax
                                echo $form->textField($model, 'company_fax', array('class' => "form-control"));
                                echo $form->error($model, 'company_fax', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Contact Person</label>
                                <?php
                                //! text field is to enter name of contact person
                                echo $form->textField($model, 'company_contactperson', array('class' => "form-control"));
                                echo $form->error($model, 'company_contactperson', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Country</label>
                                <?php
                                //! Drop down menu to select the country
                                echo $form->textField($model, 'company_country', array('class' => "form-control"));
                                echo $form->error($model, 'company_country', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">State</label>
                                <?php
                                //! Drop down menu to select the state
                                echo $form->textField($model, 'company_state', array('class' => "form-control"));
                                echo $form->error($model, 'company_state', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-4">
                                <?php //! Dropdownlist to select currency type  ?>
                                <label for="reg_input_currency" class="req">Currency Type</label>
                                <select  id="company_currency" name="company_currency" class="form-control" data-required="true">
                                    <option>Please Select</option>
                                    <option value="AFN" <?php if ($model->company_currency === "AFN") { ?>selected='selected' <?php } ?>>AFN</option>
                                    <option value="ALL" <?php if ($model->company_currency === "ALL") { ?>selected='selected' <?php } ?>>ALL</option>
                                    <option value="DZD" <?php if ($model->company_currency === "DZD") { ?>selected='selected' <?php } ?>>DZD</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="AOA" <?php if ($model->company_currency === "AOA") { ?>selected='selected' <?php } ?>>AOA</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="ARP" <?php if ($model->company_currency === "ARP") { ?>selected='selected' <?php } ?>>ARP</option>
                                    <option value="AMD" <?php if ($model->company_currency === "AMD") { ?>selected='selected' <?php } ?>>AMD</option>
                                    <option value="AWG" <?php if ($model->company_currency === "AWG") { ?>selected='selected' <?php } ?>>AWG</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="AZN" <?php if ($model->company_currency === "AZN") { ?>selected='selected' <?php } ?>>AZN</option>
                                    <option value="BSD" <?php if ($model->company_currency === "BSD") { ?>selected='selected' <?php } ?>>BSD</option>
                                    <option value="BHD" <?php if ($model->company_currency === "BHD") { ?>selected='selected' <?php } ?>>BHD</option>
                                    <option value="BDT" <?php if ($model->company_currency === "BDT") { ?>selected='selected' <?php } ?>>BDT</option>
                                    <option value="BBD" <?php if ($model->company_currency === "BBD") { ?>selected='selected' <?php } ?>>BBD</option>
                                    <option value="BYR" <?php if ($model->company_currency === "BYR") { ?>selected='selected' <?php } ?>>BYR</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="BZD" <?php if ($model->company_currency === "BZD") { ?>selected='selected' <?php } ?>>BZD</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="BMD" <?php if ($model->company_currency === "BMD") { ?>selected='selected' <?php } ?>>BMD</option>
                                    <option value="BTN" <?php if ($model->company_currency === "BTN") { ?>selected='selected' <?php } ?>>BTN</option>
                                    <option value="BOV" <?php if ($model->company_currency === "BOV") { ?>selected='selected' <?php } ?>>BOV</option>
                                    <option value="BAM" <?php if ($model->company_currency === "BAM") { ?>selected='selected' <?php } ?>>BAM</option>
                                    <option value="BWP" <?php if ($model->company_currency === "BWP") { ?>selected='selected' <?php } ?>>BWP</option>
                                    <option value="NOK" <?php if ($model->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                    <option value="BRL" <?php if ($model->company_currency === "BRL") { ?>selected='selected' <?php } ?>>BRL</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="BND" <?php if ($model->company_currency === "BND") { ?>selected='selected' <?php } ?>>BND</option>
                                    <option value="BGL" <?php if ($model->company_currency === "BGL") { ?>selected='selected' <?php } ?>>BGL</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="BIF" <?php if ($model->company_currency === "BIF") { ?>selected='selected' <?php } ?>>BIF</option>
                                    <option value="KHR" <?php if ($model->company_currency === "KHR") { ?>selected='selected' <?php } ?>>KHR</option>
                                    <option value="XAF" <?php if ($model->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                    <option value="CAD" <?php if ($model->company_currency === "CAD") { ?>selected='selected' <?php } ?>>CAD</option>
                                    <option value="CVE" <?php if ($model->company_currency === "CVE") { ?>selected='selected' <?php } ?>>CVE</option>
                                    <option value="KYD" <?php if ($model->company_currency === "KYD") { ?>selected='selected' <?php } ?>>KYD</option>
                                    <option value="XAF" <?php if ($model->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                    <option value="XAF" <?php if ($model->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                    <option value="CLF" <?php if ($model->company_currency === "CLF") { ?>selected='selected' <?php } ?>>CLF</option>
                                    <option value="CNY" <?php if ($model->company_currency === "CNY") { ?>selected='selected' <?php } ?>>CNY</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="COU" <?php if ($model->company_currency === "COU") { ?>selected='selected' <?php } ?>>COU</option>
                                    <option value="KMF" <?php if ($model->company_currency === "KMF") { ?>selected='selected' <?php } ?>>KMF</option>
                                    <option value="XAF" <?php if ($model->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                    <option value="CDF" <?php if ($model->company_currency === "CDF") { ?>selected='selected' <?php } ?>>CDF</option>
                                    <option value="NZD" <?php if ($model->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                    <option value="CRC" <?php if ($model->company_currency === "CRC") { ?>selected='selected' <?php } ?>>CRC</option>
                                    <option value="HRK" <?php if ($model->company_currency === "HRK") { ?>selected='selected' <?php } ?>>HRK</option>
                                    <option value="CUP" <?php if ($model->company_currency === "CUP") { ?>selected='selected' <?php } ?>>CUP</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="CZK" <?php if ($model->company_currency === "CZK") { ?>selected='selected' <?php } ?>>CZK</option>
                                    <option value="CSJ" <?php if ($model->company_currency === "CSJ") { ?>selected='selected' <?php } ?>>CSJ</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="DKK" <?php if ($model->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                    <option value="DJF" <?php if ($model->company_currency === "DJF") { ?>selected='selected' <?php } ?>>DJF</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="DOP" <?php if ($model->company_currency === "DOP") { ?>selected='selected' <?php } ?>>DOP</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="EGP" <?php if ($model->company_currency === "EGP") { ?>selected='selected' <?php } ?>>EGP</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="EQE" <?php if ($model->company_currency === "EQE") { ?>selected='selected' <?php } ?>>EQE</option>
                                    <option value="ERN" <?php if ($model->company_currency === "ERN") { ?>selected='selected' <?php } ?>>ERN</option>
                                    <option value="EEK" <?php if ($model->company_currency === "EEK") { ?>selected='selected' <?php } ?>>EEK</option>
                                    <option value="ETB" <?php if ($model->company_currency === "ETB") { ?>selected='selected' <?php } ?>>ETB</option>
                                    <option value="FKP" <?php if ($model->company_currency === "FKP") { ?>selected='selected' <?php } ?>>FKP</option>
                                    <option value="DKK" <?php if ($model->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                    <option value="FJD" <?php if ($model->company_currency === "FJD") { ?>selected='selected' <?php } ?>>FJD</option>
                                    <option value="FIM" <?php if ($model->company_currency === "FIM") { ?>selected='selected' <?php } ?>>FIM</option>
                                    <option value="XFO" <?php if ($model->company_currency === "XFO") { ?>selected='selected' <?php } ?>>XFO</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="XPF" <?php if ($model->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="XAF" <?php if ($model->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                    <option value="GMD" <?php if ($model->company_currency === "GMD") { ?>selected='selected' <?php } ?>>GMD</option>
                                    <option value="GEL" <?php if ($model->company_currency === "GEL") { ?>selected='selected' <?php } ?>>GEL</option>
                                    <option value="DDM" <?php if ($model->company_currency === "DDM") { ?>selected='selected' <?php } ?>>DDM</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="GHC" <?php if ($model->company_currency === "GHC") { ?>selected='selected' <?php } ?>>GHC</option>
                                    <option value="GIP" <?php if ($model->company_currency === "GIP") { ?>selected='selected' <?php } ?>>GIP</option>
                                    <option value="GRD" <?php if ($model->company_currency === "GRD") { ?>selected='selected' <?php } ?>>GRD</option>
                                    <option value="DKK" <?php if ($model->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="GTQ" <?php if ($model->company_currency === "GTQ") { ?>selected='selected' <?php } ?>>GTQ</option>
                                    <option value="GNE" <?php if ($model->company_currency === "GNE") { ?>selected='selected' <?php } ?>>GNE</option>
                                    <option value="GWP" <?php if ($model->company_currency === "GWP") { ?>selected='selected' <?php } ?>>GWP</option>
                                    <option value="GYD" <?php if ($model->company_currency === "GYD") { ?>selected='selected' <?php } ?>>GYD</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="HNL" <?php if ($model->company_currency === "HNL") { ?>selected='selected' <?php } ?>>HNL</option>
                                    <option value="HKD" <?php if ($model->company_currency === "HKD") { ?>selected='selected' <?php } ?>>HKD</option>
                                    <option value="HUF" <?php if ($model->company_currency === "HUF") { ?>selected='selected' <?php } ?>>HUF</option>
                                    <option value="ISJ" <?php if ($model->company_currency === "ISJ") { ?>selected='selected' <?php } ?>>ISJ</option>
                                    <option value="INR" <?php if ($model->company_currency === "INR") { ?>selected='selected' <?php } ?>>INR</option>
                                    <option value="IDR" <?php if ($model->company_currency === "IDR") { ?>selected='selected' <?php } ?>>IDR</option>
                                    <option value="IRR" <?php if ($model->company_currency === "IRR") { ?>selected='selected' <?php } ?>>IRR</option>
                                    <option value="IQD" <?php if ($model->company_currency === "IQD") { ?>selected='selected' <?php } ?>>IQD</option>
                                    <option value="IEP" <?php if ($model->company_currency === "IEP") { ?>selected='selected' <?php } ?>>IEP</option>
                                    <option value="ILS" <?php if ($model->company_currency === "ILS") { ?>selected='selected' <?php } ?>>ILS</option>
                                    <option value="ITL" <?php if ($model->company_currency === "ITL") { ?>selected='selected' <?php } ?>>ITL</option>
                                    <option value="JMD" <?php if ($model->company_currency === "JMD") { ?>selected='selected' <?php } ?>>JMD</option>
                                    <option value="JPY" <?php if ($model->company_currency === "JPY") { ?>selected='selected' <?php } ?>>JPY</option>
                                    <option value="JOD" <?php if ($model->company_currency === "JOD") { ?>selected='selected' <?php } ?>>JOD</option>
                                    <option value="KZT" <?php if ($model->company_currency === "KZT") { ?>selected='selected' <?php } ?>>KZT</option>
                                    <option value="KES" <?php if ($model->company_currency === "KES") { ?>selected='selected' <?php } ?>>KES</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="KPW" <?php if ($model->company_currency === "KPW") { ?>selected='selected' <?php } ?>>KPW</option>
                                    <option value="KRW" <?php if ($model->company_currency === "KRW") { ?>selected='selected' <?php } ?>>KRW</option>
                                    <option value="KWD" <?php if ($model->company_currency === "KWD") { ?>selected='selected' <?php } ?>>KWD</option>
                                    <option value="KGS" <?php if ($model->company_currency === "KGS") { ?>selected='selected' <?php } ?>>KGS</option>
                                    <option value="LAJ" <?php if ($model->company_currency === "LAJ") { ?>selected='selected' <?php } ?>>LAJ</option>
                                    <option value="LVL" <?php if ($model->company_currency === "LVL") { ?>selected='selected' <?php } ?>>LVL</option>
                                    <option value="LBP" <?php if ($model->company_currency === "LBP") { ?>selected='selected' <?php } ?>>LBP</option>
                                    <option value="ZAR" <?php if ($model->company_currency === "ZAR") { ?>selected='selected' <?php } ?>>ZAR</option>
                                    <option value="LRD" <?php if ($model->company_currency === "LRD") { ?>selected='selected' <?php } ?>>LRD</option>
                                    <option value="LYD" <?php if ($model->company_currency === "LYD") { ?>selected='selected' <?php } ?>>LYD</option>
                                    <option value="CHF" <?php if ($model->company_currency === "CHF") { ?>selected='selected' <?php } ?>>CHF</option>
                                    <option value="LTL" <?php if ($model->company_currency === "LTL") { ?>selected='selected' <?php } ?>>LTL</option>
                                    <option value="LUF" <?php if ($model->company_currency === "LUF") { ?>selected='selected' <?php } ?>>LUF</option>
                                    <option value="MOP" <?php if ($model->company_currency === "MOP") { ?>selected='selected' <?php } ?>>MOP</option>
                                    <option value="MKN" <?php if ($model->company_currency === "MKN") { ?>selected='selected' <?php } ?>>MKN</option>
                                    <option value="MGF" <?php if ($model->company_currency === "MGF") { ?>selected='selected' <?php } ?>>MGF</option>
                                    <option value="MWK" <?php if ($model->company_currency === "MWK") { ?>selected='selected' <?php } ?>>MWK</option>
                                    <option value="MYR" <?php if ($model->company_currency === "MYR") { ?>selected='selected' <?php } ?>>MYR</option>
                                    <option value="MVR" <?php if ($model->company_currency === "MVR") { ?>selected='selected' <?php } ?>>MVR</option>
                                    <option value="MAF" <?php if ($model->company_currency === "MAF") { ?>selected='selected' <?php } ?>>MAF</option>
                                    <option value="MTL" <?php if ($model->company_currency === "MTL") { ?>selected='selected' <?php } ?>>MTL</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="MRO" <?php if ($model->company_currency === "MRO") { ?>selected='selected' <?php } ?>>MRO</option>
                                    <option value="MUR" <?php if ($model->company_currency === "MUR") { ?>selected='selected' <?php } ?>>MUR</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="MXV" <?php if ($model->company_currency === "MXV") { ?>selected='selected' <?php } ?>>MXV</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="MDL" <?php if ($model->company_currency === "MDL") { ?>selected='selected' <?php } ?>>MDL</option>
                                    <option value="MCF" <?php if ($model->company_currency === "MCF") { ?>selected='selected' <?php } ?>>MCF</option>
                                    <option value="MNT" <?php if ($model->company_currency === "MNT") { ?>selected='selected' <?php } ?>>MNT</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="MAD" <?php if ($model->company_currency === "MAD") { ?>selected='selected' <?php } ?>>MAD</option>
                                    <option value="MZM" <?php if ($model->company_currency === "MZM") { ?>selected='selected' <?php } ?>>MZM</option>
                                    <option value="MMK" <?php if ($model->company_currency === "MMK") { ?>selected='selected' <?php } ?>>MMK</option>
                                    <option value="ZAR" <?php if ($model->company_currency === "ZAR") { ?>selected='selected' <?php } ?>>ZAR</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="NPR" <?php if ($model->company_currency === "NPR") { ?>selected='selected' <?php } ?>>NPR</option>
                                    <option value="NLG" <?php if ($model->company_currency === "NLG") { ?>selected='selected' <?php } ?>>NLG</option>
                                    <option value="ANG" <?php if ($model->company_currency === "ANG") { ?>selected='selected' <?php } ?>>ANG</option>
                                    <option value="XPF" <?php if ($model->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                    <option value="NZD" <?php if ($model->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                    <option value="NIO" <?php if ($model->company_currency === "NIO") { ?>selected='selected' <?php } ?>>NIO</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="NGN" <?php if ($model->company_currency === "NGN") { ?>selected='selected' <?php } ?>>NGN</option>
                                    <option value="NZD" <?php if ($model->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="NOK" <?php if ($model->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                    <option value="OMR" <?php if ($model->company_currency === "OMR") { ?>selected='selected' <?php } ?>>OMR</option>
                                    <option value="PKR" <?php if ($model->company_currency === "PKR") { ?>selected='selected' <?php } ?>>PKR</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="PGK" <?php if ($model->company_currency === "PGK") { ?>selected='selected' <?php } ?>>PGK</option>
                                    <option value="PYG" <?php if ($model->company_currency === "PYG") { ?>selected='selected' <?php } ?>>PYG</option>
                                    <option value="YDD" <?php if ($model->company_currency === "YDD") { ?>selected='selected' <?php } ?>>YDD</option>
                                    <option value="PEH" <?php if ($model->company_currency === "PEH") { ?>selected='selected' <?php } ?>>PEH</option>
                                    <option value="PHP" <?php if ($model->company_currency === "PHP") { ?>selected='selected' <?php } ?>>PHP</option>
                                    <option value="NZD" <?php if ($model->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                    <option value="PLN" <?php if ($model->company_currency === "PLN") { ?>selected='selected' <?php } ?>>PLN</option>
                                    <option value="TPE" <?php if ($model->company_currency === "TPE") { ?>selected='selected' <?php } ?>>TPE</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="QAR" <?php if ($model->company_currency === "QAR") { ?>selected='selected' <?php } ?>>QAR</option>
                                    <option value="ROK" <?php if ($model->company_currency === "ROK") { ?>selected='selected' <?php } ?>>ROK</option>
                                    <option value="RUB" <?php if ($model->company_currency === "RUB") { ?>selected='selected' <?php } ?>>RUB</option>
                                    <option value="RWF" <?php if ($model->company_currency === "RWF") { ?>selected='selected' <?php } ?>>RWF</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="SHP" <?php if ($model->company_currency === "SHP") { ?>selected='selected' <?php } ?>>SHP</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="XCD" <?php if ($model->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                    <option value="WST" <?php if ($model->company_currency === "WST") { ?>selected='selected' <?php } ?>>WST</option>
                                    <option value="EUR" <?php if ($model->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                    <option value="STD" <?php if ($model->company_currency === "STD") { ?>selected='selected' <?php } ?>>STD</option>
                                    <option value="SAR" <?php if ($model->company_currency === "SAR") { ?>selected='selected' <?php } ?>>SAR</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="CSD" <?php if ($model->company_currency === "CSD") { ?>selected='selected' <?php } ?>>CSD</option>
                                    <option value="SCR" <?php if ($model->company_currency === "SCR") { ?>selected='selected' <?php } ?>>SCR</option>
                                    <option value="SLL" <?php if ($model->company_currency === "SLL") { ?>selected='selected' <?php } ?>>SLL</option>
                                    <option value="SGD" <?php if ($model->company_currency === "SGD") { ?>selected='selected' <?php } ?>>SGD</option>
                                    <option value="SKK" <?php if ($model->company_currency === "SKK") { ?>selected='selected' <?php } ?>>SKK</option>
                                    <option value="SIT" <?php if ($model->company_currency === "SIT") { ?>selected='selected' <?php } ?>>SIT</option>
                                    <option value="SBD" <?php if ($model->company_currency === "SBD") { ?>selected='selected' <?php } ?>>SBD</option>
                                    <option value="SOS" <?php if ($model->company_currency === "SOS") { ?>selected='selected' <?php } ?>>SOS</option>
                                    <option value="ZAL" <?php if ($model->company_currency === "ZAL") { ?>selected='selected' <?php } ?>>ZAL</option>
                                    <option value="ESB" <?php if ($model->company_currency === "ESB") { ?>selected='selected' <?php } ?>>ESB</option>
                                    <option value="LKR" <?php if ($model->company_currency === "LKR") { ?>selected='selected' <?php } ?>>LKR</option>
                                    <option value="SDG" <?php if ($model->company_currency === "SDG") { ?>selected='selected' <?php } ?>>SDG</option>
                                    <option value="SRG" <?php if ($model->company_currency === "SRG") { ?>selected='selected' <?php } ?>>SRG</option>
                                    <option value="NOK" <?php if ($model->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                    <option value="SZL" <?php if ($model->company_currency === "SZL") { ?>selected='selected' <?php } ?>>SZL</option>
                                    <option value="SEK" <?php if ($model->company_currency === "SEK") { ?>selected='selected' <?php } ?>>SEK</option>
                                    <option value="CHW" <?php if ($model->company_currency === "CHW") { ?>selected='selected' <?php } ?>>CHW</option>
                                    <option value="SYP" <?php if ($model->company_currency === "SYP") { ?>selected='selected' <?php } ?>>SYP</option>
                                    <option value="TWD" <?php if ($model->company_currency === "TWD") { ?>selected='selected' <?php } ?>>TWD</option>
                                    <option value="TJR" <?php if ($model->company_currency === "TJR") { ?>selected='selected' <?php } ?>>TJR</option>
                                    <option value="TZS" <?php if ($model->company_currency === "TZS") { ?>selected='selected' <?php } ?>>TZS</option>
                                    <option value="THB" <?php if ($model->company_currency === "THB") { ?>selected='selected' <?php } ?>>THB</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="XOF" <?php if ($model->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                    <option value="NZD" <?php if ($model->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                    <option value="TOP" <?php if ($model->company_currency === "TOP") { ?>selected='selected' <?php } ?>>TOP</option>
                                    <option value="TTD" <?php if ($model->company_currency === "TTD") { ?>selected='selected' <?php } ?>>TTD</option>
                                    <option value="TND" <?php if ($model->company_currency === "TND") { ?>selected='selected' <?php } ?>>TND</option>
                                    <option value="TRL" <?php if ($model->company_currency === "TRL") { ?>selected='selected' <?php } ?>>TRL</option>
                                    <option value="TMM" <?php if ($model->company_currency === "TMM") { ?>selected='selected' <?php } ?>>TMM</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="AUD" <?php if ($model->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                    <option value="SUR" <?php if ($model->company_currency === "SUR") { ?>selected='selected' <?php } ?>>SUR</option>
                                    <option value="UGS" <?php if ($model->company_currency === "UGS") { ?>selected='selected' <?php } ?>>UGS</option>
                                    <option value="UAK" <?php if ($model->company_currency === "UAK") { ?>selected='selected' <?php } ?>>UAK</option>
                                    <option value="AED" <?php if ($model->company_currency === "AED") { ?>selected='selected' <?php } ?>>AED</option>
                                    <option value="GBP" <?php if ($model->company_currency === "GBP") { ?>selected='selected' <?php } ?>>GBP</option>
                                    <option value="USS" <?php if ($model->company_currency === "USS") { ?>selected='selected' <?php } ?>>USS</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="UYI" <?php if ($model->company_currency === "UYI") { ?>selected='selected' <?php } ?>>UYI</option>
                                    <option value="UZS" <?php if ($model->company_currency === "UZS") { ?>selected='selected' <?php } ?>>UZS</option>
                                    <option value="VUV" <?php if ($model->company_currency === "VUV") { ?>selected='selected' <?php } ?>>VUV</option>
                                    <option value="VEB" <?php if ($model->company_currency === "VEB") { ?>selected='selected' <?php } ?>>VEB</option>
                                    <option value="VNC" <?php if ($model->company_currency === "VNC") { ?>selected='selected' <?php } ?>>VNC</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="USD" <?php if ($model->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                    <option value="XPF" <?php if ($model->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                    <option value="MAD" <?php if ($model->company_currency === "MAD") { ?>selected='selected' <?php } ?>>MAD</option>
                                    <option value="YER" <?php if ($model->company_currency === "YER") { ?>selected='selected' <?php } ?>>YER</option>
                                    <option value="YUM" <?php if ($model->company_currency === "YUM") { ?>selected='selected' <?php } ?>>YUM</option>
                                    <option value="ZRZ" <?php if ($model->company_currency === "ZRZ") { ?>selected='selected' <?php } ?>>ZRZ</option>
                                    <option value="ZMK" <?php if ($model->company_currency === "ZMK") { ?>selected='selected' <?php } ?>>ZMK</option>
                                    <option value="ZWC" <?php if ($model->company_currency === "ZWC") { ?>selected='selected' <?php } ?>>ZWC</option>
                                </select> 
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="req">Language</label>
                                <?php
                                //! text field is to enter language
                                echo $form->textField($model, 'company_language', array('class' => "form-control"));
                                echo $form->error($model, 'company_language', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="req">Company Code</label>
                                <?php
                                //! text field us to neter company code
                                echo $form->textField($model, 'company_code', array('class' => "form-control"));
                                echo $form->error($model, 'company_code', array('class' => 'school_val_error'));
                                ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Timezone" class="req">Timezone</label>
                                <?php
                                //! dropdown list to select timezone
                                echo $form->dropDownList($model, 'company_timezone', array(
                                    'European Central Time(ECT) - GMT+01:00' => 'European Central Time(ECT) - GMT+01:00',
                                    'Indiana Eastern Standard Time(IET) - GMT-05:00' => 'Indiana Eastern Standard Time(IET) - GMT-05:00',
                                    'Indian Standard Time(IST) - GMT+05:30' => 'Indian Standard Time(IST) - GMT+05:30',
                                    'European Central Time(ECT) - GMT+01:00' => 'European Central Time(ECT) - GMT+01:00',
                                    'Eastern European Time(EET) - GMT+02:00' => 'Eastern European Time(EET) - GMT+02:00',
                                    'Arabic Standard Time(ART) - GMT+02:00' => 'Arabic Standard Time(ART) - GMT+02:00',
                                    'Eastern African Time(EAT) - GMT+03:00' => 'Eastern African Time(EAT) - GMT+03:00',
                                    'Middle East Time(MET) - GMT+03:30' => 'Middle East Time(MET) - GMT+03:30',
                                    'Near East Time(NET) - GMT+04:00' => 'Near East Time(NET) - GMT+04:00',
                                    'Pakistan Lahore Time(PLT) - GMT+05:00' => 'Pakistan Lahore Time(PLT) - GMT+05:00',
                                    'Bangladesh Standard Time(BST) - GMT+06:00' => 'Bangladesh Standard Time(BST) - GMT+06:00',
                                    'Vietnam Standard Time(VST) - GMT+07:00' => 'Vietnam Standard Time(VST) - GMT+07:00',
                                    'China Taiwan Time(CTT) - GMT+08:00' => 'China Taiwan Time(CTT) - GMT+08:00',
                                    'Japan Standard Time(JST) - GMT+09:00' => 'Japan Standard Time(JST) - GMT+09:00',
                                    'Australia Central Time(ACT) - GMT+09:30' => 'Australia Central Time(ACT) - GMT+09:30',
                                    'Australia Eastern Time(AET) - GMT+10:00' => 'Australia Eastern Time(AET) - GMT+10:00',
                                    'Solomon Standard Time(SST) - GMT+11:00' => 'Solomon Standard Time(SST) - GMT+11:00',
                                    'New Zealand Standard Time(NST) - GMT+12:00' => 'New Zealand Standard Time(NST) - GMT+12:00',
                                    'Midway Islands Time(MIT) - GMT-11:00' => 'Midway Islands Time(MIT) - GMT-11:00',
                                    'Hawaii Standard Time(HST) - GMT-10:00' => 'Hawaii Standard Time(HST) - GMT-10:00',
                                    'Alaska Standard Time(AST) - GMT-09:00' => 'Alaska Standard Time(AST) - GMT-09:00',
                                    'Pacific Standard Time(PST) - GMT-08:00' => 'Pacific Standard Time(PST) - GMT-08:00',
                                    'Phoenix Standard Time(PNT) - GMT-07:00' => 'Phoenix Standard Time(PNT) - GMT-07:00',
                                    'Mountain Standard Time(MST) - GMT-07:00' => 'Mountain Standard Time(MST) - GMT-07:00',
                                    'Central Standard Time(CST) - GMT-06:00' => 'Central Standard Time(CST) - GMT-06:00',
                                    'Eastern Standard Time(EST) - GMT-05:00' => 'Eastern Standard Time(EST) - GMT-05:00',
                                    'Puerto Rico and US Virgin Islands Time(PRT) - GMT-04:00' => 'Puerto Rico and US Virgin Islands Time(PRT) - GMT-04:00',
                                    'Canada Newfoundland Time(CNT) - GMT-03:30' => 'Canada Newfoundland Time(CNT) - GMT-03:30',
                                    'Argentina Standard Time(AGT) - GMT-03:00' => 'Argentina Standard Time(AGT) - GMT-03:00',
                                    'Brazil Eastern Time(BET) - GMT-03:00' => 'Brazil Eastern Time(BET) - GMT-03:00',
                                    'Central African Time(CAT) - GMT-01:00' => 'Central African Time(CAT) - GMT-01:00',
                                        ), array('prompt' => 'Select ', 'class' => "form-control"));
                                ?>
                                <?php echo $form->error($model, 'company_timezone', array('class' => 'school_val_error')); ?>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label">Logo</label>
                                <div data-provides="fileinput" class="fileinput fileinput-new">
                                    <div class="input-group input-large">
                                        <div data-trigger="fileinput" class="form-control uneditable-input input-fixed input-medium">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <?php
                                            //! file field for upload company logo
                                            echo $form->fileField($model, 'company_logo');
                                            echo $form->error($model, 'company_logo', array('class' => 'school_val_error'));
                                            ?> </span>
                                        <a data-dismiss="fileinput" class="input-group-addon btn red fileinput-exists" href="javascript:;"> Remove </a>
                                    </div>
                                </div>
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
                    $company = Company::model()->findByPk(Yii::app()->user->companyid);
                    if (isset($company)) {
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'company-form',
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
                            'action' => Yii::app()->createUrl('//core/company/update/id/' . Yii::app()->user->companyid),
                            'htmlOptions' => array(
                                'enctype' => 'multipart/form-data',
                            ),
                        ));
                        /**
                         * _form is used to enter the company details
                         */
                        ?>
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <?php
                                        $logo = $company->company_logo;
                                        if (isset($logo)) {
                                            ?>
                                            <img alt="" class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/banner/<?php echo $logo; ?>">
                                        <?php } else { ?>
                                            <img alt="" class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/images/user_avatar_lg.png">
                                        <?php } ?>
                                    </div>
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"><?php echo $company->company_name; ?> </div>
                                        <div class="profile-usertitle-name"> <?php echo $company->company_email; ?> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <form action="#" role="form">
                                                        <div class="form-group">
                                                            <label class="control-label">Company Name</label>
                                                            <?php
                                                            //! Text field is used to enter company name
                                                            echo $form->textField($company, 'company_name', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_name', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Address</label>
                                                            <?php
                                                            //! Text area to enter company address
                                                            echo $form->textArea($company, 'company_address', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_address', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Email</label>
                                                            <?php
                                                            //! Text field to enter company email
                                                            echo $form->textField($company, 'company_email', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_email', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Phone</label>
                                                            <?php
                                                            //! text field is to enter company phone
                                                            echo $form->textField($company, 'company_phone', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_phone', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Mobile</label>
                                                            <?php
                                                            //! text field is to enter company mobile
                                                            echo $form->textField($company, 'company_mobile', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_mobile', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Fax</label>
                                                            <?php
                                                            //! text field to neter company fax
                                                            echo $form->textField($company, 'company_fax', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_fax', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Contact Person</label>
                                                            <?php
                                                            //! text field is to enter name of contact person
                                                            echo $form->textField($company, 'company_contactperson', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_contactperson', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <?php
                                                            //! Drop down menu to select the country
                                                            echo $form->textField($company, 'company_country', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_country', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>State</label>
                                                            <?php
                                                            //! Drop down menu to select the state
                                                            echo $form->textField($company, 'company_state', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_state', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php //! Dropdownlist to select currency type  ?>
                                                            <label for="reg_input_currency">Currency Type</label>
                                                            <select  id="sh_currency" name="sh_currency" class="form-control" data-required="true">
                                                                <option>Please Select</option>
                                                                <option value="AFN" <?php if ($company->company_currency === "AFN") { ?>selected='selected' <?php } ?>>AFN</option>
                                                                <option value="ALL" <?php if ($company->company_currency === "ALL") { ?>selected='selected' <?php } ?>>ALL</option>
                                                                <option value="DZD" <?php if ($company->company_currency === "DZD") { ?>selected='selected' <?php } ?>>DZD</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="AOA" <?php if ($company->company_currency === "AOA") { ?>selected='selected' <?php } ?>>AOA</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="ARP" <?php if ($company->company_currency === "ARP") { ?>selected='selected' <?php } ?>>ARP</option>
                                                                <option value="AMD" <?php if ($company->company_currency === "AMD") { ?>selected='selected' <?php } ?>>AMD</option>
                                                                <option value="AWG" <?php if ($company->company_currency === "AWG") { ?>selected='selected' <?php } ?>>AWG</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="AZN" <?php if ($company->company_currency === "AZN") { ?>selected='selected' <?php } ?>>AZN</option>
                                                                <option value="BSD" <?php if ($company->company_currency === "BSD") { ?>selected='selected' <?php } ?>>BSD</option>
                                                                <option value="BHD" <?php if ($company->company_currency === "BHD") { ?>selected='selected' <?php } ?>>BHD</option>
                                                                <option value="BDT" <?php if ($company->company_currency === "BDT") { ?>selected='selected' <?php } ?>>BDT</option>
                                                                <option value="BBD" <?php if ($company->company_currency === "BBD") { ?>selected='selected' <?php } ?>>BBD</option>
                                                                <option value="BYR" <?php if ($company->company_currency === "BYR") { ?>selected='selected' <?php } ?>>BYR</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="BZD" <?php if ($company->company_currency === "BZD") { ?>selected='selected' <?php } ?>>BZD</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="BMD" <?php if ($company->company_currency === "BMD") { ?>selected='selected' <?php } ?>>BMD</option>
                                                                <option value="BTN" <?php if ($company->company_currency === "BTN") { ?>selected='selected' <?php } ?>>BTN</option>
                                                                <option value="BOV" <?php if ($company->company_currency === "BOV") { ?>selected='selected' <?php } ?>>BOV</option>
                                                                <option value="BAM" <?php if ($company->company_currency === "BAM") { ?>selected='selected' <?php } ?>>BAM</option>
                                                                <option value="BWP" <?php if ($company->company_currency === "BWP") { ?>selected='selected' <?php } ?>>BWP</option>
                                                                <option value="NOK" <?php if ($company->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                                                <option value="BRL" <?php if ($company->company_currency === "BRL") { ?>selected='selected' <?php } ?>>BRL</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="BND" <?php if ($company->company_currency === "BND") { ?>selected='selected' <?php } ?>>BND</option>
                                                                <option value="BGL" <?php if ($company->company_currency === "BGL") { ?>selected='selected' <?php } ?>>BGL</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="BIF" <?php if ($company->company_currency === "BIF") { ?>selected='selected' <?php } ?>>BIF</option>
                                                                <option value="KHR" <?php if ($company->company_currency === "KHR") { ?>selected='selected' <?php } ?>>KHR</option>
                                                                <option value="XAF" <?php if ($company->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                                                <option value="CAD" <?php if ($company->company_currency === "CAD") { ?>selected='selected' <?php } ?>>CAD</option>
                                                                <option value="CVE" <?php if ($company->company_currency === "CVE") { ?>selected='selected' <?php } ?>>CVE</option>
                                                                <option value="KYD" <?php if ($company->company_currency === "KYD") { ?>selected='selected' <?php } ?>>KYD</option>
                                                                <option value="XAF" <?php if ($company->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                                                <option value="XAF" <?php if ($company->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                                                <option value="CLF" <?php if ($company->company_currency === "CLF") { ?>selected='selected' <?php } ?>>CLF</option>
                                                                <option value="CNY" <?php if ($company->company_currency === "CNY") { ?>selected='selected' <?php } ?>>CNY</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="COU" <?php if ($company->company_currency === "COU") { ?>selected='selected' <?php } ?>>COU</option>
                                                                <option value="KMF" <?php if ($company->company_currency === "KMF") { ?>selected='selected' <?php } ?>>KMF</option>
                                                                <option value="XAF" <?php if ($company->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                                                <option value="CDF" <?php if ($company->company_currency === "CDF") { ?>selected='selected' <?php } ?>>CDF</option>
                                                                <option value="NZD" <?php if ($company->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                                                <option value="CRC" <?php if ($company->company_currency === "CRC") { ?>selected='selected' <?php } ?>>CRC</option>
                                                                <option value="HRK" <?php if ($company->company_currency === "HRK") { ?>selected='selected' <?php } ?>>HRK</option>
                                                                <option value="CUP" <?php if ($company->company_currency === "CUP") { ?>selected='selected' <?php } ?>>CUP</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="CZK" <?php if ($company->company_currency === "CZK") { ?>selected='selected' <?php } ?>>CZK</option>
                                                                <option value="CSJ" <?php if ($company->company_currency === "CSJ") { ?>selected='selected' <?php } ?>>CSJ</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="DKK" <?php if ($company->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                                                <option value="DJF" <?php if ($company->company_currency === "DJF") { ?>selected='selected' <?php } ?>>DJF</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="DOP" <?php if ($company->company_currency === "DOP") { ?>selected='selected' <?php } ?>>DOP</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="EGP" <?php if ($company->company_currency === "EGP") { ?>selected='selected' <?php } ?>>EGP</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="EQE" <?php if ($company->company_currency === "EQE") { ?>selected='selected' <?php } ?>>EQE</option>
                                                                <option value="ERN" <?php if ($company->company_currency === "ERN") { ?>selected='selected' <?php } ?>>ERN</option>
                                                                <option value="EEK" <?php if ($company->company_currency === "EEK") { ?>selected='selected' <?php } ?>>EEK</option>
                                                                <option value="ETB" <?php if ($company->company_currency === "ETB") { ?>selected='selected' <?php } ?>>ETB</option>
                                                                <option value="FKP" <?php if ($company->company_currency === "FKP") { ?>selected='selected' <?php } ?>>FKP</option>
                                                                <option value="DKK" <?php if ($company->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                                                <option value="FJD" <?php if ($company->company_currency === "FJD") { ?>selected='selected' <?php } ?>>FJD</option>
                                                                <option value="FIM" <?php if ($company->company_currency === "FIM") { ?>selected='selected' <?php } ?>>FIM</option>
                                                                <option value="XFO" <?php if ($company->company_currency === "XFO") { ?>selected='selected' <?php } ?>>XFO</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="XPF" <?php if ($company->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="XAF" <?php if ($company->company_currency === "XAF") { ?>selected='selected' <?php } ?>>XAF</option>
                                                                <option value="GMD" <?php if ($company->company_currency === "GMD") { ?>selected='selected' <?php } ?>>GMD</option>
                                                                <option value="GEL" <?php if ($company->company_currency === "GEL") { ?>selected='selected' <?php } ?>>GEL</option>
                                                                <option value="DDM" <?php if ($company->company_currency === "DDM") { ?>selected='selected' <?php } ?>>DDM</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="GHC" <?php if ($company->company_currency === "GHC") { ?>selected='selected' <?php } ?>>GHC</option>
                                                                <option value="GIP" <?php if ($company->company_currency === "GIP") { ?>selected='selected' <?php } ?>>GIP</option>
                                                                <option value="GRD" <?php if ($company->company_currency === "GRD") { ?>selected='selected' <?php } ?>>GRD</option>
                                                                <option value="DKK" <?php if ($company->company_currency === "DKK") { ?>selected='selected' <?php } ?>>DKK</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="GTQ" <?php if ($company->company_currency === "GTQ") { ?>selected='selected' <?php } ?>>GTQ</option>
                                                                <option value="GNE" <?php if ($company->company_currency === "GNE") { ?>selected='selected' <?php } ?>>GNE</option>
                                                                <option value="GWP" <?php if ($company->company_currency === "GWP") { ?>selected='selected' <?php } ?>>GWP</option>
                                                                <option value="GYD" <?php if ($company->company_currency === "GYD") { ?>selected='selected' <?php } ?>>GYD</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="HNL" <?php if ($company->company_currency === "HNL") { ?>selected='selected' <?php } ?>>HNL</option>
                                                                <option value="HKD" <?php if ($company->company_currency === "HKD") { ?>selected='selected' <?php } ?>>HKD</option>
                                                                <option value="HUF" <?php if ($company->company_currency === "HUF") { ?>selected='selected' <?php } ?>>HUF</option>
                                                                <option value="ISJ" <?php if ($company->company_currency === "ISJ") { ?>selected='selected' <?php } ?>>ISJ</option>
                                                                <option value="INR" <?php if ($company->company_currency === "INR") { ?>selected='selected' <?php } ?>>INR</option>
                                                                <option value="IDR" <?php if ($company->company_currency === "IDR") { ?>selected='selected' <?php } ?>>IDR</option>
                                                                <option value="IRR" <?php if ($company->company_currency === "IRR") { ?>selected='selected' <?php } ?>>IRR</option>
                                                                <option value="IQD" <?php if ($company->company_currency === "IQD") { ?>selected='selected' <?php } ?>>IQD</option>
                                                                <option value="IEP" <?php if ($company->company_currency === "IEP") { ?>selected='selected' <?php } ?>>IEP</option>
                                                                <option value="ILS" <?php if ($company->company_currency === "ILS") { ?>selected='selected' <?php } ?>>ILS</option>
                                                                <option value="ITL" <?php if ($company->company_currency === "ITL") { ?>selected='selected' <?php } ?>>ITL</option>
                                                                <option value="JMD" <?php if ($company->company_currency === "JMD") { ?>selected='selected' <?php } ?>>JMD</option>
                                                                <option value="JPY" <?php if ($company->company_currency === "JPY") { ?>selected='selected' <?php } ?>>JPY</option>
                                                                <option value="JOD" <?php if ($company->company_currency === "JOD") { ?>selected='selected' <?php } ?>>JOD</option>
                                                                <option value="KZT" <?php if ($company->company_currency === "KZT") { ?>selected='selected' <?php } ?>>KZT</option>
                                                                <option value="KES" <?php if ($company->company_currency === "KES") { ?>selected='selected' <?php } ?>>KES</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="KPW" <?php if ($company->company_currency === "KPW") { ?>selected='selected' <?php } ?>>KPW</option>
                                                                <option value="KRW" <?php if ($company->company_currency === "KRW") { ?>selected='selected' <?php } ?>>KRW</option>
                                                                <option value="KWD" <?php if ($company->company_currency === "KWD") { ?>selected='selected' <?php } ?>>KWD</option>
                                                                <option value="KGS" <?php if ($company->company_currency === "KGS") { ?>selected='selected' <?php } ?>>KGS</option>
                                                                <option value="LAJ" <?php if ($company->company_currency === "LAJ") { ?>selected='selected' <?php } ?>>LAJ</option>
                                                                <option value="LVL" <?php if ($company->company_currency === "LVL") { ?>selected='selected' <?php } ?>>LVL</option>
                                                                <option value="LBP" <?php if ($company->company_currency === "LBP") { ?>selected='selected' <?php } ?>>LBP</option>
                                                                <option value="ZAR" <?php if ($company->company_currency === "ZAR") { ?>selected='selected' <?php } ?>>ZAR</option>
                                                                <option value="LRD" <?php if ($company->company_currency === "LRD") { ?>selected='selected' <?php } ?>>LRD</option>
                                                                <option value="LYD" <?php if ($company->company_currency === "LYD") { ?>selected='selected' <?php } ?>>LYD</option>
                                                                <option value="CHF" <?php if ($company->company_currency === "CHF") { ?>selected='selected' <?php } ?>>CHF</option>
                                                                <option value="LTL" <?php if ($company->company_currency === "LTL") { ?>selected='selected' <?php } ?>>LTL</option>
                                                                <option value="LUF" <?php if ($company->company_currency === "LUF") { ?>selected='selected' <?php } ?>>LUF</option>
                                                                <option value="MOP" <?php if ($company->company_currency === "MOP") { ?>selected='selected' <?php } ?>>MOP</option>
                                                                <option value="MKN" <?php if ($company->company_currency === "MKN") { ?>selected='selected' <?php } ?>>MKN</option>
                                                                <option value="MGF" <?php if ($company->company_currency === "MGF") { ?>selected='selected' <?php } ?>>MGF</option>
                                                                <option value="MWK" <?php if ($company->company_currency === "MWK") { ?>selected='selected' <?php } ?>>MWK</option>
                                                                <option value="MYR" <?php if ($company->company_currency === "MYR") { ?>selected='selected' <?php } ?>>MYR</option>
                                                                <option value="MVR" <?php if ($company->company_currency === "MVR") { ?>selected='selected' <?php } ?>>MVR</option>
                                                                <option value="MAF" <?php if ($company->company_currency === "MAF") { ?>selected='selected' <?php } ?>>MAF</option>
                                                                <option value="MTL" <?php if ($company->company_currency === "MTL") { ?>selected='selected' <?php } ?>>MTL</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="MRO" <?php if ($company->company_currency === "MRO") { ?>selected='selected' <?php } ?>>MRO</option>
                                                                <option value="MUR" <?php if ($company->company_currency === "MUR") { ?>selected='selected' <?php } ?>>MUR</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="MXV" <?php if ($company->company_currency === "MXV") { ?>selected='selected' <?php } ?>>MXV</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="MDL" <?php if ($company->company_currency === "MDL") { ?>selected='selected' <?php } ?>>MDL</option>
                                                                <option value="MCF" <?php if ($company->company_currency === "MCF") { ?>selected='selected' <?php } ?>>MCF</option>
                                                                <option value="MNT" <?php if ($company->company_currency === "MNT") { ?>selected='selected' <?php } ?>>MNT</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="MAD" <?php if ($company->company_currency === "MAD") { ?>selected='selected' <?php } ?>>MAD</option>
                                                                <option value="MZM" <?php if ($company->company_currency === "MZM") { ?>selected='selected' <?php } ?>>MZM</option>
                                                                <option value="MMK" <?php if ($company->company_currency === "MMK") { ?>selected='selected' <?php } ?>>MMK</option>
                                                                <option value="ZAR" <?php if ($company->company_currency === "ZAR") { ?>selected='selected' <?php } ?>>ZAR</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="NPR" <?php if ($company->company_currency === "NPR") { ?>selected='selected' <?php } ?>>NPR</option>
                                                                <option value="NLG" <?php if ($company->company_currency === "NLG") { ?>selected='selected' <?php } ?>>NLG</option>
                                                                <option value="ANG" <?php if ($company->company_currency === "ANG") { ?>selected='selected' <?php } ?>>ANG</option>
                                                                <option value="XPF" <?php if ($company->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                                                <option value="NZD" <?php if ($company->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                                                <option value="NIO" <?php if ($company->company_currency === "NIO") { ?>selected='selected' <?php } ?>>NIO</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="NGN" <?php if ($company->company_currency === "NGN") { ?>selected='selected' <?php } ?>>NGN</option>
                                                                <option value="NZD" <?php if ($company->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="NOK" <?php if ($company->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                                                <option value="OMR" <?php if ($company->company_currency === "OMR") { ?>selected='selected' <?php } ?>>OMR</option>
                                                                <option value="PKR" <?php if ($company->company_currency === "PKR") { ?>selected='selected' <?php } ?>>PKR</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="PGK" <?php if ($company->company_currency === "PGK") { ?>selected='selected' <?php } ?>>PGK</option>
                                                                <option value="PYG" <?php if ($company->company_currency === "PYG") { ?>selected='selected' <?php } ?>>PYG</option>
                                                                <option value="YDD" <?php if ($company->company_currency === "YDD") { ?>selected='selected' <?php } ?>>YDD</option>
                                                                <option value="PEH" <?php if ($company->company_currency === "PEH") { ?>selected='selected' <?php } ?>>PEH</option>
                                                                <option value="PHP" <?php if ($company->company_currency === "PHP") { ?>selected='selected' <?php } ?>>PHP</option>
                                                                <option value="NZD" <?php if ($company->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                                                <option value="PLN" <?php if ($company->company_currency === "PLN") { ?>selected='selected' <?php } ?>>PLN</option>
                                                                <option value="TPE" <?php if ($company->company_currency === "TPE") { ?>selected='selected' <?php } ?>>TPE</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="QAR" <?php if ($company->company_currency === "QAR") { ?>selected='selected' <?php } ?>>QAR</option>
                                                                <option value="ROK" <?php if ($company->company_currency === "ROK") { ?>selected='selected' <?php } ?>>ROK</option>
                                                                <option value="RUB" <?php if ($company->company_currency === "RUB") { ?>selected='selected' <?php } ?>>RUB</option>
                                                                <option value="RWF" <?php if ($company->company_currency === "RWF") { ?>selected='selected' <?php } ?>>RWF</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="SHP" <?php if ($company->company_currency === "SHP") { ?>selected='selected' <?php } ?>>SHP</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="XCD" <?php if ($company->company_currency === "XCD") { ?>selected='selected' <?php } ?>>XCD</option>
                                                                <option value="WST" <?php if ($company->company_currency === "WST") { ?>selected='selected' <?php } ?>>WST</option>
                                                                <option value="EUR" <?php if ($company->company_currency === "EUR") { ?>selected='selected' <?php } ?>>EUR</option>
                                                                <option value="STD" <?php if ($company->company_currency === "STD") { ?>selected='selected' <?php } ?>>STD</option>
                                                                <option value="SAR" <?php if ($company->company_currency === "SAR") { ?>selected='selected' <?php } ?>>SAR</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="CSD" <?php if ($company->company_currency === "CSD") { ?>selected='selected' <?php } ?>>CSD</option>
                                                                <option value="SCR" <?php if ($company->company_currency === "SCR") { ?>selected='selected' <?php } ?>>SCR</option>
                                                                <option value="SLL" <?php if ($company->company_currency === "SLL") { ?>selected='selected' <?php } ?>>SLL</option>
                                                                <option value="SGD" <?php if ($company->company_currency === "SGD") { ?>selected='selected' <?php } ?>>SGD</option>
                                                                <option value="SKK" <?php if ($company->company_currency === "SKK") { ?>selected='selected' <?php } ?>>SKK</option>
                                                                <option value="SIT" <?php if ($company->company_currency === "SIT") { ?>selected='selected' <?php } ?>>SIT</option>
                                                                <option value="SBD" <?php if ($company->company_currency === "SBD") { ?>selected='selected' <?php } ?>>SBD</option>
                                                                <option value="SOS" <?php if ($company->company_currency === "SOS") { ?>selected='selected' <?php } ?>>SOS</option>
                                                                <option value="ZAL" <?php if ($company->company_currency === "ZAL") { ?>selected='selected' <?php } ?>>ZAL</option>
                                                                <option value="ESB" <?php if ($company->company_currency === "ESB") { ?>selected='selected' <?php } ?>>ESB</option>
                                                                <option value="LKR" <?php if ($company->company_currency === "LKR") { ?>selected='selected' <?php } ?>>LKR</option>
                                                                <option value="SDG" <?php if ($company->company_currency === "SDG") { ?>selected='selected' <?php } ?>>SDG</option>
                                                                <option value="SRG" <?php if ($company->company_currency === "SRG") { ?>selected='selected' <?php } ?>>SRG</option>
                                                                <option value="NOK" <?php if ($company->company_currency === "NOK") { ?>selected='selected' <?php } ?>>NOK</option>
                                                                <option value="SZL" <?php if ($company->company_currency === "SZL") { ?>selected='selected' <?php } ?>>SZL</option>
                                                                <option value="SEK" <?php if ($company->company_currency === "SEK") { ?>selected='selected' <?php } ?>>SEK</option>
                                                                <option value="CHW" <?php if ($company->company_currency === "CHW") { ?>selected='selected' <?php } ?>>CHW</option>
                                                                <option value="SYP" <?php if ($company->company_currency === "SYP") { ?>selected='selected' <?php } ?>>SYP</option>
                                                                <option value="TWD" <?php if ($company->company_currency === "TWD") { ?>selected='selected' <?php } ?>>TWD</option>
                                                                <option value="TJR" <?php if ($company->company_currency === "TJR") { ?>selected='selected' <?php } ?>>TJR</option>
                                                                <option value="TZS" <?php if ($company->company_currency === "TZS") { ?>selected='selected' <?php } ?>>TZS</option>
                                                                <option value="THB" <?php if ($company->company_currency === "THB") { ?>selected='selected' <?php } ?>>THB</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="XOF" <?php if ($company->company_currency === "XOF") { ?>selected='selected' <?php } ?>>XOF</option>
                                                                <option value="NZD" <?php if ($company->company_currency === "NZD") { ?>selected='selected' <?php } ?>>NZD</option>
                                                                <option value="TOP" <?php if ($company->company_currency === "TOP") { ?>selected='selected' <?php } ?>>TOP</option>
                                                                <option value="TTD" <?php if ($company->company_currency === "TTD") { ?>selected='selected' <?php } ?>>TTD</option>
                                                                <option value="TND" <?php if ($company->company_currency === "TND") { ?>selected='selected' <?php } ?>>TND</option>
                                                                <option value="TRL" <?php if ($company->company_currency === "TRL") { ?>selected='selected' <?php } ?>>TRL</option>
                                                                <option value="TMM" <?php if ($company->company_currency === "TMM") { ?>selected='selected' <?php } ?>>TMM</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="AUD" <?php if ($company->company_currency === "AUD") { ?>selected='selected' <?php } ?>>AUD</option>
                                                                <option value="SUR" <?php if ($company->company_currency === "SUR") { ?>selected='selected' <?php } ?>>SUR</option>
                                                                <option value="UGS" <?php if ($company->company_currency === "UGS") { ?>selected='selected' <?php } ?>>UGS</option>
                                                                <option value="UAK" <?php if ($company->company_currency === "UAK") { ?>selected='selected' <?php } ?>>UAK</option>
                                                                <option value="AED" <?php if ($company->company_currency === "AED") { ?>selected='selected' <?php } ?>>AED</option>
                                                                <option value="GBP" <?php if ($company->company_currency === "GBP") { ?>selected='selected' <?php } ?>>GBP</option>
                                                                <option value="USS" <?php if ($company->company_currency === "USS") { ?>selected='selected' <?php } ?>>USS</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="UYI" <?php if ($company->company_currency === "UYI") { ?>selected='selected' <?php } ?>>UYI</option>
                                                                <option value="UZS" <?php if ($company->company_currency === "UZS") { ?>selected='selected' <?php } ?>>UZS</option>
                                                                <option value="VUV" <?php if ($company->company_currency === "VUV") { ?>selected='selected' <?php } ?>>VUV</option>
                                                                <option value="VEB" <?php if ($company->company_currency === "VEB") { ?>selected='selected' <?php } ?>>VEB</option>
                                                                <option value="VNC" <?php if ($company->company_currency === "VNC") { ?>selected='selected' <?php } ?>>VNC</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="USD" <?php if ($company->company_currency === "USD") { ?>selected='selected' <?php } ?>>USD</option>
                                                                <option value="XPF" <?php if ($company->company_currency === "XPF") { ?>selected='selected' <?php } ?>>XPF</option>
                                                                <option value="MAD" <?php if ($company->company_currency === "MAD") { ?>selected='selected' <?php } ?>>MAD</option>
                                                                <option value="YER" <?php if ($company->company_currency === "YER") { ?>selected='selected' <?php } ?>>YER</option>
                                                                <option value="YUM" <?php if ($company->company_currency === "YUM") { ?>selected='selected' <?php } ?>>YUM</option>
                                                                <option value="ZRZ" <?php if ($company->company_currency === "ZRZ") { ?>selected='selected' <?php } ?>>ZRZ</option>
                                                                <option value="ZMK" <?php if ($company->company_currency === "ZMK") { ?>selected='selected' <?php } ?>>ZMK</option>
                                                                <option value="ZWC" <?php if ($company->company_currency === "ZWC") { ?>selected='selected' <?php } ?>>ZWC</option>
                                                            </select> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Language</label>
                                                            <?php
                                                            //! text field is to enter language
                                                            echo $form->textField($company, 'company_language', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_language', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Company Code</label>
                                                            <?php
                                                            //! text field us to neter company code
                                                            echo $form->textField($company, 'company_code', array('class' => "form-control"));
                                                            echo $form->error($company, 'company_code', array('class' => 'school_val_error'));
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Timezone">Timezone</label>
                                                            <?php
                                                            //! dropdown list to select timezone
                                                            echo $form->dropDownList($company, 'company_timezone', array(
                                                                'European Central Time(ECT) - GMT+01:00' => 'European Central Time(ECT) - GMT+01:00',
                                                                'Indiana Eastern Standard Time(IET) - GMT-05:00' => 'Indiana Eastern Standard Time(IET) - GMT-05:00',
                                                                'Indian Standard Time(IST) - GMT+05:30' => 'Indian Standard Time(IST) - GMT+05:30',
                                                                'European Central Time(ECT) - GMT+01:00' => 'European Central Time(ECT) - GMT+01:00',
                                                                'Eastern European Time(EET) - GMT+02:00' => 'Eastern European Time(EET) - GMT+02:00',
                                                                'Arabic Standard Time(ART) - GMT+02:00' => 'Arabic Standard Time(ART) - GMT+02:00',
                                                                'Eastern African Time(EAT) - GMT+03:00' => 'Eastern African Time(EAT) - GMT+03:00',
                                                                'Middle East Time(MET) - GMT+03:30' => 'Middle East Time(MET) - GMT+03:30',
                                                                'Near East Time(NET) - GMT+04:00' => 'Near East Time(NET) - GMT+04:00',
                                                                'Pakistan Lahore Time(PLT) - GMT+05:00' => 'Pakistan Lahore Time(PLT) - GMT+05:00',
                                                                'Bangladesh Standard Time(BST) - GMT+06:00' => 'Bangladesh Standard Time(BST) - GMT+06:00',
                                                                'Vietnam Standard Time(VST) - GMT+07:00' => 'Vietnam Standard Time(VST) - GMT+07:00',
                                                                'China Taiwan Time(CTT) - GMT+08:00' => 'China Taiwan Time(CTT) - GMT+08:00',
                                                                'Japan Standard Time(JST) - GMT+09:00' => 'Japan Standard Time(JST) - GMT+09:00',
                                                                'Australia Central Time(ACT) - GMT+09:30' => 'Australia Central Time(ACT) - GMT+09:30',
                                                                'Australia Eastern Time(AET) - GMT+10:00' => 'Australia Eastern Time(AET) - GMT+10:00',
                                                                'Solomon Standard Time(SST) - GMT+11:00' => 'Solomon Standard Time(SST) - GMT+11:00',
                                                                'New Zealand Standard Time(NST) - GMT+12:00' => 'New Zealand Standard Time(NST) - GMT+12:00',
                                                                'Midway Islands Time(MIT) - GMT-11:00' => 'Midway Islands Time(MIT) - GMT-11:00',
                                                                'Hawaii Standard Time(HST) - GMT-10:00' => 'Hawaii Standard Time(HST) - GMT-10:00',
                                                                'Alaska Standard Time(AST) - GMT-09:00' => 'Alaska Standard Time(AST) - GMT-09:00',
                                                                'Pacific Standard Time(PST) - GMT-08:00' => 'Pacific Standard Time(PST) - GMT-08:00',
                                                                'Phoenix Standard Time(PNT) - GMT-07:00' => 'Phoenix Standard Time(PNT) - GMT-07:00',
                                                                'Mountain Standard Time(MST) - GMT-07:00' => 'Mountain Standard Time(MST) - GMT-07:00',
                                                                'Central Standard Time(CST) - GMT-06:00' => 'Central Standard Time(CST) - GMT-06:00',
                                                                'Eastern Standard Time(EST) - GMT-05:00' => 'Eastern Standard Time(EST) - GMT-05:00',
                                                                'Puerto Rico and US Virgin Islands Time(PRT) - GMT-04:00' => 'Puerto Rico and US Virgin Islands Time(PRT) - GMT-04:00',
                                                                'Canada Newfoundland Time(CNT) - GMT-03:30' => 'Canada Newfoundland Time(CNT) - GMT-03:30',
                                                                'Argentina Standard Time(AGT) - GMT-03:00' => 'Argentina Standard Time(AGT) - GMT-03:00',
                                                                'Brazil Eastern Time(BET) - GMT-03:00' => 'Brazil Eastern Time(BET) - GMT-03:00',
                                                                'Central African Time(CAT) - GMT-01:00' => 'Central African Time(CAT) - GMT-01:00',
                                                                    ), array('prompt' => 'Select ', 'class' => "form-control"));
                                                            ?>
                                                            <?php echo $form->error($company, 'company_timezone', array('class' => 'school_val_error')); ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Logo</label>
                                                            <div data-provides="fileinput" class="fileinput fileinput-new">
                                                                <div class="input-group input-large">
                                                                    <div data-trigger="fileinput" class="form-control uneditable-input input-fixed input-medium">
                                                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                        <span class="fileinput-filename"> </span>
                                                                    </div>
                                                                    <span class="input-group-addon btn default btn-file">
                                                                        <span class="fileinput-new"> Select file </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <?php
                                                                        //! file field for upload company logo
                                                                        echo $form->fileField($company, 'company_logo');
                                                                        echo $form->error($company, 'company_logo', array('class' => 'school_val_error'));
                                                                        ?> </span>
                                                                    <a data-dismiss="fileinput" class="input-group-addon btn red fileinput-exists" href="javascript:;"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="margiv-top-10">
                                                            <button class="btn green" type="submit">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                        <?php
                        $this->endWidget();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    populateCountries("Company_company_country");
    populateCountries("Company_company_country", "Company_company_state");
</script>