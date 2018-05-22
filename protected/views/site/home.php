<?php
$this->layout = '//layouts/superadminlayout';
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<section class="container clearfix main_section">
    <div id="main_content_outer" class="clearfix">
        <div id="main_content">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="box_stat box_ico">
                        <span class="stat_ico stat_ico_3"><i class="li_bubble"></i></span>
                        <h4><?php
                            echo date("l");
                            ?></h4>
                        <small><?php echo date("F j, Y"); ?></small>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="box_stat box_ico">
                        <span class="stat_ico stat_ico_4"><i class="li_diamond"></i></span>
                       <h4><?php
                            $results = Institution::model()->findAll();
                            $count = count($results);

                            echo $count;
                            ?></h4>
                        <small>Total Institutions</small>
                    </div>
                </div>
                 <div class="col-lg-3 col-md-6">
                    <div class="box_stat box_ico">
                        <span class="stat_ico stat_ico_1"><i class="li_user"></i></span>
                        <h4><?php
                            $results = Student::model()->findAll();
                            $count = count($results);

                            echo $count;
                            ?></h4>
                        <small>Total Students</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="box_stat box_ico">
                        <span class="stat_ico stat_ico_2"><i class="li_user"></i></span>
                        <h4><?php
                            $results = Employeemaster::model()->findAll();
                            $count = count($results);

                            echo $count;
                            ?></h4>
                        <small>Total Employees</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Select your institution</h4>
                            </div>
                            <div class="panel-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <?php
                                        $institution = Institution::model()->findAll();
                                        foreach ($institution as $value => $each) {
                                            $users = Username::model()->findByAttributes(array('institutionid' => $each->institutionid));
                                            $username = $users->username;
                                            $pwd = $users->password;
                                            ?>
                                            <div class="box_user">
                                                <div class="box_user_main">
                                                    <?php if ($each->institution_logo == "") { ?>
                                                        <img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl ?>/images/user_avatar_lg.png" alt="" class="img-thumbnail pull-left">
                                                    <?php } else { ?>
                                                        <img width="100" height="100" src="<?php echo Yii::app()->request->baseUrl . "/banner/" . $each->institution_logo; ?>" alt="" class="img-thumbnail pull-left">
                                                    <?php } ?>
                                                    <div class="box_user_info">
                                                        <a href="<?php echo Yii::app()->request->baseUrl . "/index.php/user/login/login1/id/" . $username . "," . $pwd; ?>"><h2 class="box_user_name"><?php echo $each->institution_name; ?></h2></a>
                                                        <p><span class="glyphicon glyphicon-phone-alt"></span><?php echo $each->institution_mobile; ?></p>
                                                        <p><span class="glyphicon glyphicon-envelope"></span> <?php echo $each->institution_contactemail; ?></p>
                                                    </div>
                                                </div> 
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"></div>
                            <!--<div id="ebro_cal"></div>-->
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

