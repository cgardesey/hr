<!--
// Copyright (c) 2015 All Right Reserved, https://web-school.in
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
-->
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

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="panel-body">
                                    <?php
                                    //! Listing of all created task
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'dataProvider' => $model->search(),
                                        'id' => 'item-grid',
                                        'selectableRows' => 1,
                                        'ajaxUpdate' => true,
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
                                                'header' => 'Task',
                                                'value' => '$data->task_heading',
                                                'htmlOptions' => array('width' => '25%'),
                                            ),
                                            array(
                                                'header' => 'Priority',
                                                'value' => 'Taskmanager::model()->getpriority($data->task_priority)',
                                                'htmlOptions' => array('width' => '10%'),
                                            ),
                                            
                                              array(
                                                'header' => 'User Name',
                                                'value' => 'Taskmanager::model()->getuser($data->usertypeid,$data->userid)',
                                                'htmlOptions' => array('width' => '25%'),
                                            ),
                                             array(
                                                'header' => 'Task Date',
                                                'value' => '$data->task_date',
                                                'htmlOptions' => array('width' => '15%'),
                                            ),
                                             array(
                                                'header' => 'Status',
                                                'value' => 'Taskmanager::model()->getstatus($data->task_status)',
                                                'htmlOptions' => array('width' => '10%'),
                                            ),
                                            array('class' => 'CButtonColumn',
                                                'header' => 'Manage',
                                                'template' => '{update} {view} {delete}',
                                                'htmlOptions' => array('width' => '5%'),
                                                'buttons' => array(
                                                    'update' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'options' => array('class' => 'glyphicon glyphicon-pencil'),
                                                    ),
                                                     'view' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'options' => array('class' => 'glyphicon glyphicon-eye-open'),
                                                    ),
                                                    'delete' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'url' => 'Yii::app()->controller->createUrl("/core/taskmanager/delete",array("id"=>$data["taskmanagerid"]))',
                                                        'options' => array('class' => 'glyphicon glyphicon-remove'),
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
                </div>

            </div>
        </div>
    </div>
</div>