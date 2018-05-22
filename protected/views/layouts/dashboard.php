<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo Yii::app()->name; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />


<!--        <link href="<?php // echo Yii::app()->request->baseUrl;       ?>/css/fullcalendar.css" rel="stylesheet" type="text/css">
<link href="<?php // echo Yii::app()->request->baseUrl;       ?>/css/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print">-->
        <!-- END PAGE LEVEL PLUGINS -->
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="#">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/logo.png" alt="logo" width="150" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <?php
                            $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
                            //! Displaying notifications
                            //! Circular notification
                            echo ' <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default">0</span>
                            </a> <ul class="dropdown-menu">
                                <li class="external"><h3><span class="bold">Notifications</span> </h3></li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">';

                            echo '<li class=""><h5><span class="bold">Circular</span></h5></li>';

                            echo '<li>
                                            <a href="#">
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span></span>
                                            </a>
                                        </li>';
                            echo '<li class=""><h5><span class="bold">Events</span></h5></li>';
                            echo '<li>
                                            <a href="#">
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span></span>
                                            </a>
                                        </li>
                                    ';
                            echo '</ul>
                                </li>';
                            ?> 
                    </ul>
                    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope-open"></i>
                            <span class="badge badge-default"> 0 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>You have
                                    <span class="bold">0 New</span> Messages</h3>
                                <a href="#">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <li>
                                        <a href="#">
                                            <span class="photo">
                                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/placeholder.jpg" class="img-circle" alt=""> 
                                            </span>
                                            <span class="subject">
                                                <span class="from"> </span>
                                                <span class="time"></span>
                                            </span>
                                            <span class="message">  </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <?php
                            if (Yii::app()->user->usertypeid === '0') { //! Super admin
                                $userphoto = "";
                                $username = "Admin";
                            } else {
                                $employee = Employee::model()->findByPk(Yii::app()->user->userid);
                                $userphoto = $employee->employee_photo;
                                $username = $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname;
                            }
                            ?>
                            <?php if ($userphoto == "") { ?>
                                <img alt="" class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/images/placeholder.jpg" />
                            <?php } else { ?>
                                <img alt="" class="img-circle" src="<?php echo Yii::app()->request->baseUrl . "/banner/" . $userphoto; ?>" />
                            <?php } ?>             
                            <span class="username username-hide-on-mobile"> <?php echo $username; ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <?php
                            if (Yii::app()->user->usertypeid != 0) {
                                ?>
                                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employee/profile"><i class="icon-user"></i> My Profile </a></li>
                            <?php } ?>
                            <!--<li><a href="<?php // echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/changepassword"><i class="icon-lock"></i>Change Password</a></li>-->
                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/logout"><i class="icon-key"></i> Log Out </a></li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">

                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="ping-top: 20px">
                        <?php
                           if (Yii::app()->user->usertypeid === '0') {
                            ?>
                            <li class="sidebar-toggler-wrapper hide">
                                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                                <div class="sidebar-toggler"> </div>
                                <!-- END SIDEBAR TOGGLER BUTTON -->
                            </li>
                            <li class="nav-item start active open">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" class="nav-link ">
                                            <!--<i class="icon-bar-chart"></i>-->
                                            <span class="title">Dashboard</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                            
                            
                            
                                
                                    <li class="nav-item "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/financialyear/create" class="nav-link "> Financial Year </a></li>
                                    <li class="nav-item "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/company/create" class="nav-link "> Company Details </a></li>
    
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/usertype/create" class="nav-link "><span class="title"> User Type</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/department/create" class="nav-link "><span class="title"> Department</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/division/create" class="nav-link "><span class="title"> Division</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/jobcategory/create" class="nav-link "><span class="title"> Job Category</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/designation/create" class="nav-link "><span class="title"> Segment</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/jobtitle/create" class="nav-link "><span class="title"> Job Title</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/workshift/create" class="nav-link "><span class="title"> Work Shift</span></a></li>
                                    <li class="nav-item  "><a href="../../../export.php" class="nav-link "><span class="title"> Mail</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employementstatus/create" class="nav-link "><span class="title"> Employment Status</span></a></li>
                                
                            </li>
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Employee Management</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employee/create" class="nav-link "><span class="title">New Employees</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employee/admin" class="nav-link "><span class="title">Employee List</span></a></li>
                                    <li class="nav-item  "><a href="../hrms_basic/Payroll-master/index.php" class="nav-link "><span class="title">Staff Payroll</span> </a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/jobdetails/create" class="nav-link "><span class="title">Transfers</span></a></li>
                                <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employee/report" class="nav-link "><span class="title">Reports</span></a></li>
                                </ul>
                            </li>
                            

                            
                           
                            
                            
                            
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle"> 
                                    <i class="glyphicon glyphicon-list-alt"></i>
                                    <span class="title">Task Manager</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/taskmanager/create" class="nav-link "><span class="title">Assign Task</span></a></li>
                                    <li class="nav-item  "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/taskmanager/admin" class="nav-link "><span class="title">Task Details</span></a></li>
                                </ul>
                            </li>

                           
                        </ul>
                        <?php
                         }
                         else
                         {?>
                                <li class="sidebar-toggler-wrapper hide">
                                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                                <div class="sidebar-toggler"> </div>
                                <!-- END SIDEBAR TOGGLER BUTTON -->
                            </li>
                            <li class="nav-item start active open">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" class="nav-link ">
                                            <!--<i class="icon-bar-chart"></i>-->
                                            <span class="title">Dashboard</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item  ">
                                
                                
                            
                            
                                
                                    
                                    <li class="nav-item "><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/employee/profile" class="nav-link "> Edit Profile </a></li>
                        
                        <?php }
                            ?>
                    <div class="modal fade" id="upgrade">
                        <div class="modal-dialog" style="opacity: 0.9">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">X</button>
                                    <h2 id="myModalLabel" class="modal-title" align="center" style="color: #F14017;"><b>Upgrade to Premium</b></h2>
                                </div>
                                <div class="modal-body">
                                   <p align="center"> Get the Most Out Of HumanFlow <br><br>
                                    <a href="http://humanflow.in" class="btn btn-success">Upgrade Now</a>
                                   </p>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn dark btn-outline" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <?php echo $content; ?>
                <!-- END CONTENT BODY -->
            </div>

        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2018 &copy; Copyright © 2018 Human Resource Management System, Prep-eez  </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <?php
        $financialyear = Financialyear::model()->findByAttributes(array('status' => 1));  //! $financialyear stores active financial year details
        ?>
        <!-- BEGIN CORE PLUGINS -->
        <!--<script src="<?php // echo Yii::app()->request->baseUrl;                            ?>/css/assets/global/plugins/jquery.min.js" type="text/javascript"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
<!--        <script type="text/javascript" src="<?php // echo Yii::app()->request->baseUrl;       ?>/css/fullcalendar.min.js"></script>-->
    </body>

</html>
<script>
    if ($('#calendar1').length) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar1').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                prev: '<',
                next: '>'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                endtime = $.fullCalendar.formatDate(end, 'h:mm tt');
                starttime = $.fullCalendar.formatDate(start, 'ddd, MMM d, h:mm tt');
                var mywhen = starttime + ' - ' + endtime;
                $('#createEventModal #apptStartTime').val(start);
                $('#createEventModal #apptEndTime').val(end);
                $('#createEventModal #apptAllDay').val(allDay);
                $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal('show');
            },
            eventClick: function (event, element) {
                var title = prompt('Event Title:');
                event.title = title;
                if (title) {
                    $('#calendar').fullCalendar('updateEvent', event);
                }
                ;
            },
            editable: true,
        });
        // Render in hidden elements
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#calendar1').fullCalendar('render');
        });
    }
</script>