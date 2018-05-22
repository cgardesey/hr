<div class="page-content" style="min-height:1683px">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><span>Employee Management</span><i class="fa fa-circle"></i></li>
            <li><span>Employee List</span></li>
        </ul>
    </div>
    <h3 class="page-title">Employee Details</h3>
    <div class="row">
        <div class="col-sm-3"> 
        </div>
        <div class="col-sm-3"> 
        </div>
        <div class="col-sm-3"> 
        </div>
        <div class="col-sm-3"> 
            <input type="text"  id="search" class="form-control" placeholder="Search...">
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-12">
            <?php
            /**
             * Listing of all employees
             */
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'employee-grid',
                'dataProvider' => $model->search(),
                'selectableRows' => 1,
                'ajaxUpdate' => true,
                'hideHeader' => false,
                'template' => "{items}\n{pager}",
                'enableHistory' => false,
                'enableSorting' => false,
                'cssFile' => Yii::app()->baseUrl . '/css/grid.css',
                'htmlOptions' => array('class' => 'grid-view table-responsive'),
                'columns' => array(
                    array(
                        'header' => 'Sl.No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions' => array('width' => '5%'),
                    ),
                    array(
                        'header' => 'Employee Code',
                        'value' => '$data->employee_code',
                    ),
                    array(
                        'header' => 'Employee Name',
                        'value' => '$data->employee_firstname." ".$data->employee_middlename." ".$data->employee_lastname',
                    ),
                    array(
                        'header' => 'Department',
                        'value' => '$data->department->department_name',
                    ),
                     array(
                        'header' => 'Division',
                        'value' => '$data->division->division_name',
                    ),
//                    'employee_qualification',
                    array(
                        'header' => 'Designation',
                        'value' => '$data->designation->designation_name',
                    ),
                    'employee_email',
                    array('class' => 'CButtonColumn',
                        'header' => 'Manage',
                        'template' => ' {view} {delete}',
                        'htmlOptions' => array('width' => '10%'),
                        'buttons' => array(
//                                                'update' => array(
//                                                    'label' => '',
//                                                    'imageUrl' => '',
//                                                    'options' => array('class' => 'glyphicon glyphicon-pencil'),
//                                                ),
                            'view' => array(
                                'label' => '',
                                'imageUrl' => '',
                                'options' => array('class' => 'glyphicon glyphicon-eye-open'),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => '',
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
<script>
    $("input").keyup(function () {
        $('#employee-grid').yiiGridView('update', {
            data: {search: $('#search').val()}
        });
        return false;
    });
</script>