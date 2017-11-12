<div>
<div class="top5">&nbsp;</div>
<div class="row">
    <div class="col-md-12">
        <input class="form-control" type="text"  value="<?=$row['tasks_name']?>" placeholder="Name" name="tasks_name" />
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?php if ($row['tasks_time_check'] > 0) echo date('d.m.Y H:i', $row['tasks_time_check'])?>" placeholder="Check Time" title="Check Time" name="tasks_time_check" />
    </div>
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?php if ($row['tasks_time_finish'] > 0) echo date('d.m.Y H:i', $row['tasks_time_finish'])?>" placeholder="Date Finish" title="Income" name="tasks_time_finish" />
    </div>
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?=$row['tasks_dotime']?>" placeholder="Do Time" title="Do Time" name="tasks_dotime" />
    </div>
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?=$row['tasks_outcome']?>" placeholder="Outcome" title="Outcome" name="tasks_outcome" />
    </div>
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?=$row['tasks_income']?>" placeholder="Income" title="Income" name="tasks_income" />
    </div>
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?=$row['tasks_contact']?>" placeholder="Contact" title="Contact" name="tasks_contact" />
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <input class="form-control" type="text" value="<?=$row['tasks_priority']?>" placeholder="Priority" title="Priority" name="tasks_priority" />
    </div>
    <div class="col-md-2">
        <select class="form-control" name="tasks_status">
            <option value="0"><?=$this->text->get('task_new');?></option>
            <option value="1"<?php if ($row['tasks_status'] == 1) echo " selected";?>><?=$this->text->get('task_progress');?></option>
            <option value="2"<?php if ($row['tasks_status'] == 2) echo " selected";?>><?=$this->text->get('task_hold');?></option>
            <option value="3"<?php if ($row['tasks_status'] == 3) echo " selected";?>><?=$this->text->get('task_done');?></option>
            <option value="4"<?php if ($row['tasks_status'] == 4) echo " selected";?>><?=$this->text->get('task_cancel');?></option>
            <option value="5"<?php if ($row['tasks_status'] == 5) echo " selected";?>><?=$this->text->get('task_regular');?></option>
            <option value="6"<?php if ($row['tasks_status'] == 6) echo " selected";?>><?=$this->text->get('task_postponed');?></option>
            <option value="7"<?php if ($row['tasks_status'] == 7) echo " selected";?>><?=$this->text->get('task_idea');?></option>
        </select>
    </div>
    <div class="col-md-4">
        <select class="form-control" name="tasks_access_type">
            <option value="0"><?=$this->text->get('access_1');?></option>
            <option value="1"<?php if ($row['tasks_access_type'] == 1) echo " selected";?>><?=$this->text->get('access_2');?></option>
            <option value="2"<?php if ($row['tasks_access_type'] == 2) echo " selected";?>><?=$this->text->get('access_3');?></option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-control" name="tasks_creator_id">
            <option value="0">Any Creator</option>
            <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $row['tasks_creator_id']) echo " selected";?>><?=$manager['email']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-control" name="tasks_user_id">
            <option value="0">Any Performer</option>
            <?php foreach($managers_arr as $manager) { if ($manager['username'] != '') $manager['email'] = $manager['username']; ?>
                <option value="<?=$manager['id']?>"<?php if ($manager['id'] == $row['tasks_user_id']) echo " selected";?>><?=$manager['email']?></option>
            <?php } ?>
        </select>
    </div>
</div>

<input type="hidden" value="<?=time()?>" placeholder="Advanced" name="tasks_time_edit" />


<?php

$info_height = 50;

$info_height = $info_height + count(explode("\n", $row['tasks_info']))*18;

?>
<div class="row">
    <div class="col-md-12">
        <textarea class="form-control" rows="6" style="height:<?=$info_height?>px;" placeholder="Advanced" name="tasks_info"><?=$row['tasks_info']?></textarea>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <input class="form-control" type="text"  value="<?=$row['tasks_result']?>" placeholder="Result Info" name="tasks_result" />
    </div>
</div>

<div class="log" style="display:none;">
    <b>Log:</b> <br/>

    <?php
    if ($row['tasks_log'] == '') $row['tasks_log'] = Array();
    else $row['tasks_log'] = json_decode($row['tasks_log']);
    foreach (array_reverse($row['tasks_log']) as $log) {

        $updates = '';
        foreach ($log->updates as $column => $update) {
            $updates .= "[".$column."] ".$update." | ";
        }
        echo "<a href='/go/user/".$log->user."'>[".$log->user."]</a> ".print_r($updates, true)." (".date("Y-m-d H:i", $log->time).")";
        // print_r($log);
        echo "<br/>";
    }
    ?>
</div>


<div class="chat" style="display:none;">
    <b>Chat:</b><br/>

    <?php
    if ($row['tasks_chat'] == '') $row['tasks_chat'] = Array();
    else $row['tasks_chat'] = json_decode($row['tasks_chat']);
    foreach ($row['tasks_chat'] as $chat) {
        echo "<a href='/go/user/".$chat->user."'>[".$chat->user."]</a> ".$chat->message." (".date("Y-m-d H:i", $chat->time).")";
        echo "<br/>";
    }
    ?>
    <br>
    <input class="form-control" type="text" value="" placeholder="Add Comment" name="tasks_chat" />

</div>

    <a class="btn btn-xs btn-warning btn-log-chat" onclick="$(this).parent().find('.log').toggle();">LOG</a>
    <a class="btn btn-xs btn-warning btn-log-chat" onclick="$(this).parent().find('.chat').toggle();">CHAT</a>

<div style="padding: 0.5%;">
    <a class="btn btn-xs btn-danger del_btn">Del</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="btn btn-xs btn-primary cancel_btn">Cancel</a>
    <a class="btn btn-xs btn-success edit_request_btn">Edit!</a>
    <span class="msg"></span>

</div>
</div>
    <!-- <a class="btn btn-xs btn-warning" onclick="$(this).parent().find('.log').toggle();">LOG</a>
    <a class="btn btn-xs btn-warning" onclick="$(this).parent().find('.chat').toggle();">CHAT</a> -->

<!-- <div class="row">
    <div class="col-md-1">
        <a class="btn btn-xs btn-danger del_btn">Del</a>
    </div>
    <div class="col-md-1">
        <a class="btn btn-xs btn-primary cancel_btn">Cancel</a>
    </div>
    <div class="col-md-1">
        <a class="btn btn-xs btn-success edit_request_btn">Edit!</a>
    </div>
    
    <span class="msg"></span>
    <div class="col-md-1 col-md-offset-7">
        <a class="btn btn-xs btn-warning" onclick="$(this).parent().find('.log').toggle();">LOG</a>
    </div>
    <div class="col-md-1">
        <a class="btn btn-xs btn-warning" onclick="$(this).parent().find('.chat').toggle();">CHAT</a>
    </div>
</div> -->

