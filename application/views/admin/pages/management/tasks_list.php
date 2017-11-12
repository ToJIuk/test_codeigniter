<style>
    tr.form_drop_down td{
        padding: 0 !important;
        border:0 !important;
    }
</style>
<link rel="stylesheet" href="/files/mini_crm/css/style.css">


<div class="admin_div wblock" style="margin:10px; padding: 10px;">


    <div class="btn-add-filters" style="padding: 10px 0px; margin-left: 16px;">
        <a class="btn btn-xs btn-success" onclick="$('.add_line').toggle();">Add</a>
        <a class="btn btn-xs btn-primary" onclick="$('.filters').toggle();">Filters</a>
        <!--
        <b><span class="glyphicon glyphicon-user"></span> <?=$user->email?> [<?=$user->id?>] </b>
        -->
    </div>


    <!-- ========================  FILTERS  ============================== -->
    <div class="container-fluid" style="padding-left: 0 !important;">
        <form class="filters p10" id="filter_form" style="margin-bottom:10px; display:none;" method="GET">

            <div class="row">
                <div class="col-md-1">
                    <a class="btn btn-xs btn-success go_filter">Go!</a>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="tasks_creator_id">
                        <option value="0">All Creators</option>
                        <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                            <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $this->input->get('tasks_creator_id')) echo " selected";?>><?=$manager['email']?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control" name="tasks_user_id">
                        <option value="0">All Performers</option>
                        <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                            <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $this->input->get('tasks_user_id')) echo " selected";?>><?=$manager['email']?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control" name="tasks_status">
                        <option value="">All</option>
                        <option value="0"<?php if ('0' === $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_new');?></option>
                        <option value="1"<?php if (1 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_progress');?></option>
                        <option value="2"<?php if (2 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_hold');?></option>
                        <option value="3"<?php if (3 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_done');?></option>
                        <option value="4"<?php if (4 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_cancel');?></option>
                        <option value="5"<?php if (5 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_regular');?></option>
                        <option value="6"<?php if (6 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_postponed');?></option>
                        <option value="7"<?php if (7 == $this->input->get('tasks_status')) echo " selected";?>><?=$this->text->get('task_idea');?></option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input class="form-control" type="text" name="text" value="<?=$this->input->get('text', true)?>" placeholder="Find..." />
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" style="width:50px;" name="id" value="<?=$this->input->get('id', true)?>" placeholder="ID..." />
                </div>
                <div class="col-md-1">
                    <a class="btn btn-xs btn-success go_filter">Go!</a>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================  ADD  ============================== -->

    <div class="container-fluid">

        <form class="add_line" style="display:none; margin-bottom:10px;" method="POST">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control" value="" placeholder="Name" name="tasks_name" />
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Check Time" title="Check Time" name="tasks_time_check" />
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Date Finish" title="Income" name="tasks_time_finish" />
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Do Time" name="tasks_dotime" />
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Outcome" name="tasks_outcome" />
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Income" title="Income" name="tasks_income" />
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Contact" name="tasks_contact" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" value="" placeholder="Priority" name="tasks_priority" />
                </div>

                <div class="col-md-2">
                    <select class="form-control" name="tasks_status">
                        <option value="0"><?=$this->text->get('task_new');?></option>
                        <option value="1"><?=$this->text->get('task_progress');?></option>
                        <option value="2"><?=$this->text->get('task_hold');?></option>
                        <option value="3"><?=$this->text->get('task_done');?></option>
                        <option value="4"><?=$this->text->get('task_cancel');?></option>
                        <option value="5"><?=$this->text->get('task_regular');?></option>
                        <option value="6"><?=$this->text->get('task_postponed');?></option>
                        <option value="7"><?=$this->text->get('task_idea');?></option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-control" name="tasks_access_type">
                        <option value="0"><?=$this->text->get('access_1');?></option>
                        <option value="1"><?=$this->text->get('access_2');?></option>
                        <option value="2"><?=$this->text->get('access_3');?></option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control" name="tasks_creator_id">
                        <option value="0">Any Creator</option>
                        <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                            <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $user->id) echo " selected";?>><?=$manager['email']?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select class="form-control" name="tasks_user_id">
                        <option value="0">Any Performer</option>
                        <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                            <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $this->input->get('tasks_user_id')) echo " selected";?>><?=$manager['email']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            
            <input type="hidden" value="<?=time()?>" placeholder="Advanced" name="tasks_time_add" />
            
            <div class="row">
                <div class="col-md-12">
                    <textarea class="form-control" rows="3" placeholder="Task full info" name="tasks_info"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input class="form-control" type="text"  value="" placeholder="Result Info" name="tasks_result" />
                </div>
            </div>

            <div style="padding: 10px 3px;">
                <a class="btn btn-xs btn-success add_btn">Add!</a>
                <a class="btn btn-xs btn-primary" style="display:none;" onclick="$(this).hide(); $(this).prev().show();">Add more</a>
                <span class="msg"></span>
            </div>
        </div>
        </form>
    </div>

    <?php

    $columns = Array (
        Array(
            "column" => "",
            "name" => "#",
            "style" => "width: 50px; border-left: 1px solid #ddd;",
        ),
        Array(
            "column" => "",
            "name" => "*",
            "style" => "width: 50px;",
        ),
        Array(
            "column" => "",
            "name" => "ID",
            "style" => "width: 50px;",
        ),
        Array(
            "column" => "",
            "name" => "Creator",
            "style" => "width: 150px;",
        ),
        Array(
            "column" => "",
            "name" => "Performer",
            "style" => "width: 150px;",
        ),
        Array(
            "column" => "",
            "name" => "Name",
            "style" => "width: 350px;",
        ),
        Array(
            "column" => "",
            "name" => "Status",
            "style" => "width: 150px;",
        ),
        Array(
            "column" => "",
            "name" => "Priority",
            "style" => "width: 70px;",
        ),
        Array(
            "column" => "",
            "name" => "Estimate",
            "style" => "width: 70px;",
        ),
        Array(
            "column" => "",
            "name" => "E Spent",
            "style" => "width: 70px;",
        ),
        Array(
            "column" => "",
            "name" => "Test",
            "style" => "width: 70px;",
        ),
        Array(
            "column" => "",
            "name" => "T Spent",
            "style" => "width: 70px;",
        ),
        Array(
            "column" => "",
            "name" => "Sprint",
            "style" => "width: 150px;",
        ),
        Array(
            "column" => "",
            "name" => "Check Time",
            "style" => "width: 150px;",
        ),
    );

    ?>

    <!-- ========================  all_list  ============================== -->

    <table class="table table-responsive table-bordered all_list container-fluid" style="width: 1800px; padding-left: 0 !important;">
        <thead>
            <tr>
            <?php foreach ($columns as $tmp_row) { ?>
            <th><?=$tmp_row['name']?></th>
            <?php } ?>


            </tr>
        </thead>
        <tbody>

        <?php $i = 1; $dotime_sum = 0; foreach ($pages_list_arr as $row) { $not_empty = true;

            // ACCESS

            ?>


            <tr class="status_active table_row" row_id="<?=$row['tasks_id']?>">
                <td class=" table_cell">
                    <?=$i?>
                </td>
                <td class=" table_cell">
                    <a class="btn btn-xs btn-primary edit_btn" style="margin-top: -5px; padding: 0 4px;">edit</a>
                </td>
                <td class=" table_cell">
                    <?=$row['tasks_id']?>
                </td>
                <td class=" table_cell">
                    <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username'];
                        if ($manager['id'] == $row['tasks_creator_id']) $row['tasks_creator_id'] = $manager['email'];
                    } ?>
                    <a href0="/go/user/<?=$row['tasks_creator_id']?>"><?=$row['tasks_creator_id']?></a>
                </td>
                <td class=" table_cell">
                    <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username'];
                        if ($manager['id'] == $row['tasks_user_id']) $row['tasks_user_id'] = $manager['email'];
                    } ?>
                    <a href0="/go/user/<?=$row['tasks_user_id']?>"><?=$row['tasks_user_id']?></a>
                </td>
                <td class=" table_cell">
                    <?=$row['tasks_name']?>
                </td>
                <td class=" table_cell">
                    <?php
                    if ($row['tasks_status'] == 0) echo '<span class="btn btn-default">'.$this->text->get('task_new').'</span>';
                    if ($row['tasks_status'] == 1) echo '<span class="btn btn-warning">'.$this->text->get('task_progress').'</span>';
                    if ($row['tasks_status'] == 2) echo '<span class="btn btn-danger">'.$this->text->get('task_hold').'</span>';
                    if ($row['tasks_status'] == 3) echo '<span class="btn btn-success">'.$this->text->get('task_done').'</span>';
                    if ($row['tasks_status'] == 4) echo $this->text->get('task_cancel');
                    if ($row['tasks_status'] == 5) echo $this->text->get('task_regular');
                    if ($row['tasks_status'] == 6) echo '<span class="btn btn-info">'.$this->text->get('task_postponed').'</span>';
                    if ($row['tasks_status'] == 7) echo $this->text->get('task_idea');
                    ?>
                </td>
                <td class=" table_cell">
                    <?=$row['tasks_priority']?>
                </td>
                <td class=" table_cell">
                    <?=$row['tasks_dotime']?>
                    <?php $dotime_sum += $row['tasks_dotime']?>
                </td>
                <td style="<?=$columns[9]['style']?>" class=" center">
                    0
                </td>
                <td style="<?=$columns[10]['style']?>" class=" center">
                    0
                </td>
                <td style="<?=$columns[11]['style']?>" class=" center">
                    0
                </td>
                <td style="<?=$columns[12]['style']?>" class=" center">
                    Sprint #1
                </td>
                <td style="<?=$columns[13]['style']?>" class=" center<?php if($row['tasks_time_check']< time()) echo " red";?>">
                    <?php if($row['tasks_time_check'] > 0) echo date('d.m.Y', $row['tasks_time_check']);?>
                </td>
            </tr>
            <tr class="form_drop_down">
                <td colspan="999"><form class="edit_form" method="post" row_id="<?=$row['tasks_id']?>"></form></td>

            </tr>

            <?php $i++; } ?>
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        <b>Estimate SUM: <?=$dotime_sum?></b>
    </div>

    <div class="pagination">
        <?=$pagination?>
    </div>


    <?php if (!isset($not_empty)) {?>
        <h3 class="no_tags"></h3>
    <?php } ?>

</div>

