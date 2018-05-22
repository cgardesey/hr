<?php
Yii::app()->clientScript->registerCoreScript('jquery');
//! Displaying detailed view of the selected task.
?>
<style type="text/css">
    #header { 
        border-bottom: 1px solid #DDDDDD; 
    }
</style>
<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Task Manager</span><i class="fa fa-circle"></i></li>
            <li><span>Task Details</span></li>
        </ul>
    </div>
    <h3 class="page-title">Task Details</h3>
    <div class="row">
        <div class="col-md-12">
       <div class="panel panel-white">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="form-group col-sm-6" >
                                    <label class="col-sm-5 control-label">Task</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo $model->task_heading; ?></p>
                                    </div>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label class="col-sm-5 control-label">Description</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo $model->task_description; ?></p>
                                    </div>
                                </div>

                            </div>
                            <div id="header"></div>
                            <div class="row">
                               <div class="form-group col-sm-6" >
                                    <label class="col-sm-5 control-label">Date</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo $model->task_date; ?></p>
                                    </div>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label class="col-sm-5 control-label">User Name</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo Taskmanager::model()->getuser($model->usertypeid, $model->userid); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div id="header"></div>
                            <div class="row">
                               <div class="form-group col-sm-6" >
                                    <label class="col-sm-5 control-label">Priority</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo Taskmanager::model()->getpriority($model->task_priority); ?></p>
                                    </div>
                                </div>
                                <div class="form-group col-sm-5">
                                    <label class="col-sm-5 control-label">Status</label>
                                    <div class="col-sm-7">
                                        <p class="form-control-static"><?php echo Taskmanager::model()->getstatus($model->task_status); ?></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>  
    </div>
</div>