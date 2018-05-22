<?php
$this->layout = '//layouts/dashboard';
$employee = Employee::model()->findByPk(Yii::app()->user->userid);
?>
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="#">Home</a><i class="fa fa-circle"></i></li>
            <li><span>Dashboard</span></li>
        </ul>
    </div>
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h3>
                    <i class="glyphicon glyphicon-education position-left" style="font-size: 35px"></i>
                    <span class="text-semibold"  style="font-size: 30px">Welcome,</span> 
                    <span class="text-warning"  style="font-size: 26px"><?php echo $employee->employee_firstname . " " . $employee->employee_middlename . " " . $employee->employee_lastname; ?></span>
                </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Leave Details</span>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light calendar bordered">
                <div class="portlet-title ">
                    <div class="caption">
<!--                        <i class="icon-calendar font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>-->
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="calendar1"></div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered" style='height:500px'>
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">Task Manager</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height: 370px;" data-always-visible="1" data-rail-visible="0">
                        <div class="datatable-scroll-lg">
                            <table aria-describedby="DataTables_Table_0_info" role="grid" id="DataTables_Table_0" class="table tasks-list table-lg dataTable no-footer" width="100%">
                                <thead>
                                    <tr role="row">
                                        <!--<th style="width: 20px;" colspan="1" rowspan="1">#</th>-->
                                        <th style="width: 40%;" colspan="1" rowspan="1">Task Description</th>
                                        <th style="width: 10%;" colspan="1" rowspan="1">Priority</th>
                                        <th style="width: 15%;" colspan="1" rowspan="1">Task Date</th>
                                        <th style="width: 15%;" colspan="1" rowspan="1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>	
                                    <?php
                                    $criteria = new CDbCriteria;
                                    $criteria->order = 'taskmanagerid DESC';
                                    $criteria->limit = 5;
                                    $criteria->condition = 'usertypeid = :usertypeid';
                                    $criteria->condition = 'userid = :userid';
                                    $criteria->params = array(':usertypeid' => Yii::app()->user->usertypeid);
                                    $criteria->params = array(':userid' => Yii::app()->user->userid);

                                    $tasks = Taskmanager::model()->findAll($criteria);
                                    $i = 1;
                                    if (count($tasks) != 0) {
                                        foreach ($tasks as $task) {
                                            ?>
                                            <tr class="odd" role="row">
                                                <!--<td class="sorting_1"><?php // echo $i;          ?></td>-->
                                                <td>
                                                    <div class="text-semibold"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/taskmanager/view/id/<?php echo $task->taskmanagerid; ?>"><?php echo $task->task_heading; ?></a></div>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($task->task_priority === '1') { //! Highest priority
                                                        echo '<div class="btn-group">
                                                                <a href="#" class="label label-danger dropdown-toggle" data-toggle="dropdown">
                                                                    ' . Taskmanager::model()->getpriority($task->task_priority) . ' 
                                                                </a></div>';
                                                    }
                                                    if ($task->task_priority === '2') { //! Hign
                                                        echo '<div class="btn-group">
                                                                <a href="#" class="label label-info dropdown-toggle" data-toggle="dropdown">
                                                                    ' . Taskmanager::model()->getpriority($task->task_priority) . ' 
                                                                </a></div>';
                                                    }
                                                    if ($task->task_priority === '3') { //! Normal
                                                        echo '<div class="btn-group">
                                                                <a href="#" class="label label-primary dropdown-toggle" data-toggle="dropdown">
                                                                    ' . Taskmanager::model()->getpriority($task->task_priority) . ' 
                                                                </a></div>';
                                                    }
                                                    if ($task->task_priority === '4') { //! Low
                                                        echo '<div class="btn-group">
                                                                <a href="#" class="label label-success dropdown-toggle" data-toggle="dropdown">
                                                                    ' . Taskmanager::model()->getpriority($task->task_priority) . ' 
                                                                </a></div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $task->task_date; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    if ($task->task_status === '1') { //! open
                                                        echo ' <div class="btn-group">
                                                                <a href="#" class="label label-info dropdown-toggle" data-toggle="dropdown">
                                                                   ' . Taskmanager::model()->getstatus($task->task_status) . '
                                                                </a></div>';
                                                    }
                                                    if ($task->task_status === '2') { //! On Hold
                                                        echo ' <div class="btn-group">
                                                                <a href="#" class="label label-warning dropdown-toggle" data-toggle="dropdown">
                                                                   ' . Taskmanager::model()->getstatus($task->task_status) . '
                                                                </a></div>';
                                                    }
                                                    if ($task->task_status === '3') { //! Resolved
                                                        echo ' <div class="btn-group">
                                                                <a href="#" class="label label-success dropdown-toggle" data-toggle="dropdown">
                                                                   ' . Taskmanager::model()->getstatus($task->task_status) . '
                                                                </a></div>';
                                                    }
                                                    if ($task->task_status === '4') { //! Closed
                                                        echo ' <div class="btn-group">
                                                                <a href="#" class="label label-default dropdown-toggle" data-toggle="dropdown">
                                                                   ' . Taskmanager::model()->getstatus($task->task_status) . '
                                                                </a></div>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                <tbody>
                            </table>
                        </div>
                    </div>
                    <div class="scroller-footer">
                        <div class="btn-arrow-link pull-right">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/core/taskmanager/admin">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light tasks-widget bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-green-haze hide"></i>
                        <span class="caption-subject font-green bold uppercase">To do's</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="task-content">
                        <?php
                        if (isset($_GET['todoid'])) {
                            $todoedit = Todo::model()->findByPk($_GET['todoid']);
                            ?>
                            <form action="#">
                                <!--                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="todo_subjectedit" value="<?php // echo $todoedit->todo_subject;                   ?>"> 
                                                                </div>-->
                                <div class="form-group">
                                    <textarea class="form-control" id='todo_contentedit'><?php echo $todoedit->todo_content; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text"  id="todo_dateedit" value="<?php echo $todoedit->todo_date; ?>"  placeholder="Date" class="form-control date-picker">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn green btn-labeled btn-labeled-right" id='todobuttonedit'>
                                            Add <b><i class="icon-circle-right2"></i></b></button>
                                    </div>
                                </div>
                            </form><br>
                        <?php } else { ?>
                            <form action="#">
                                <!--                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="todo_subject" placeholder="Subject"> 
                                                                </div>-->
                                <div class="form-group">
                                    <textarea name="enter-message" class="form-control mb-15" rows="3" cols="1" id='todo_content' placeholder="What's on your mind?"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" value="" id="todo_date" placeholder="Date" class="form-control date-picker">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 text-right">
                                        <button type="button" class="btn green btn-labeled btn-labeled-right" id='todobutton'>
                                            Add <b><i class="icon-circle-right2"></i></b></button>
                                    </div>
                                </div>
                            </form><br>
                        <?php } ?>
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 312px;"><div data-rail-visible1="1" data-always-visible="1" style="height: 312px; overflow: hidden; width: auto;" class="scroller" data-initialized="1">
                                <!-- START TASK LIST -->
                                <ul class="task-list">
                                    <?php
                                    $todos = Todo::model()->findAllByAttributes(array('usertypeid' => Yii::app()->user->usertypeid, 'userid' => Yii::app()->user->userid)); //! $todos stores todo list of logged in user to list
                                    if (count($todos) != 0) {
                                        foreach ($todos as $todo) {
                                            ?>
                                            <li>
                                                <div class="task-title">
                                                    <span class="task-title-sp"> <?php echo $todo->todo_content; ?> </span>
                                                    <?php
                                                    $currentdate = date("Y-m-d"); //! $currentdate store current date
                                                    if ($currentdate > $todo->todo_date) { //! checks if current date is greater than to do date
                                                        ?>
                                                        <span class="label label-sm label-danger"><?php echo $todo->todo_date; ?></span>
                                                    <?php } else if ($currentdate === $todo->todo_date) { //! checks if ciurrent date is equal to todo date
                                                        ?>
                                                        <span class="label label-sm label-warning">Today</span>
                                                        <span class="task-bell">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span>
                                                    <?php } else { ?>
                                                        <span class="label label-sm label-success"><?php echo $todo->todo_date; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="task-config">
                                                    <div class="task-config-btn btn-group">
                                                        <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;" class="btn btn-sm default">
                                                            <i class="fa fa-cog"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/deletetodo/id/<?php echo $todo->todoid; ?>">
                                                                    <i class="fa fa-check"></i> Complete </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/index/todoid/<?php echo $todo->todoid; ?>">
                                                                    <i class="fa fa-pencil"></i> Edit </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="slimScrollBar" style="background: rgb(187, 187, 187) none repeat scroll 0% 0%; width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 217.286px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#todobutton').click(function () {
        if ($('#todo_subject').val() === "") {
            alert("Please enter todo subject");
        } else {
            $.ajax({
                url: '<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/savetodo',
                type: 'POST',
                data: {todocontent: $('#todo_content').val(), todo_date: $('#todo_date').val(), todo_subject: $('#todo_subject').val()},
                success: function (data) {
                    location.reload();
                }

            });
        }

    });
</script>
<?php if (isset($_GET['todoid'])) { ?>
    <script>
        $('#todobuttonedit').click(function () {

            $.ajax({
                url: '<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/updatetodo/id/<?php echo $_GET['todoid']; ?>',
                            type: 'POST',
                            data: {todocontent: $('#todo_contentedit').val(), todo_date: $('#todo_dateedit').val(), todo_subject: $('#todo_subjectedit').val()},
                            success: function (data) {
                                //                    location.reload();
                                window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/index";
                            }

                        });
                    });
    </script>
<?php } ?>