<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Table_Activities {


    public function input_form($input_array, $cell_id)
    {
        $CI =& get_instance();

        $table = 'activities';
        if(isset($input_array['custom_activity_table'])) {
            $table = $input_array['custom_activity_table'];
        }

        // Add Activity Data
        if($input_array['make_type'] == 'edit') {
            if($table != 'activities') {
                $query = $CI->db->query("SELECT {$table}.*, users.id as 'user_id',  users.fio, activities_type.icon as 'activity_icon', activities_type.name as 'activity_name' 
                                     FROM {$table}
                                     LEFT JOIN users ON {$table}.activity_user = users.id
                                     LEFT JOIN activities_type ON {$table}.activity_type_id = activities_type.id
                                     WHERE {$table}.activity_element_id = {$cell_id}
                                     ORDER BY {$table}.activity_time DESC");
            } else {
                $query = $CI->db->query("SELECT activities.*, users.id as 'user_id', users.fio, activities_type.icon as 'activity_icon', activities_type.name as 'activity_name'  
                                     FROM activities
                                     LEFT JOIN users ON activities.activity_user = users.id
                                     LEFT JOIN activities_type ON activities.activity_type_id = activities_type.id
                                     WHERE activities.activity_table = '{$input_array['base_table']}' AND activities.activity_element_id = {$cell_id}
                                     ORDER BY activities.activity_time DESC");
            }
            $activity_messages = $query->result_array();
        }
        ob_start();
        ?>
        <!--<form method="post" action="/inside2/edit_request/<?/*= $input_array['base_table']; */?>/<?/*= $input_array['tab']; */?>/<?/*= $cell_id;*/?>">-->
            <textarea name="message" style="width:610px; height: 60px; margin-right: 20px;" id="activity-message"></textarea>
        <?php if($input_array['make_type'] == 'edit') { ?>
            <a class="btn btn-success white add_activity_comment" style="margin-bottom: 10px;">Add</a>
            <div class="activity_comments_holder">
                <?php
                if($activity_messages) {
                foreach ($activity_messages as $row) { ?>
                    <div style="padding: 10px; border-top: 1px dotted #777;">
                        <p style="margin-left: 15px;"><i style="color:#1b6d85" class="fa <?= $row['activity_icon'];?> fa-lg color-tooltip" data-toggle="tooltip" data-placement="top" title="<?= $row['activity_name']; ?>"></i> <b><i class="fa fa-user" aria-hidden="true"></i> <?= '[#'.$row['user_id'].'] ' . $row['fio'];?></b> | <i class="gray"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $row['activity_time'];?></i></p>
                        <p style="margin-left: 15px;"><span style="color: #e9573f"><?= $row['activity_text'];?></span></p>
                    </div>
                <?php } }?>
            </div>
       <!-- </form>-->
        <script>
            // Add activity comment
            $("body").on('click', ".add_activity_comment", function() {

                 var mess_holder = $(this).parent().children(".activity_comments_holder");
                 var message = $('#activity-message').val();

                 if($.trim(message)) {
                     $.ajax({
                         type: "POST",
                         url: '/inside2/edit_request/<?= $input_array['base_table']; ?>/<?= $input_array['tab']; ?>/<?= $cell_id;?>',
                         data: { message: message},
                         success: function (data){
                             $('#activity-message').val('');
                             mess_holder.prepend(data);
                             // Delete message 'OK!' on the end
                             $('.activity_comments_holder font').remove();
                             inside_temporary_dialog('Comment Saved!');
                         }
                    });
                 }
             });
        </script>
        <?php }
        $form = ob_get_clean();
        return '<div id="'.$cell_id.'">'.$form.'</div>';
    }

    public function pre_db_save($input_array, $cell_id)
    {
        // ==================================
        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');
        // ==================================

        $CI =& get_instance();
        if($input_array['update']) {
            $table = $CI->inside_lib->defend_filter(4, $input_array['base_table']);
            $row = $CI->db->query("SELECT * FROM {$table} WHERE {$table_config['key']} = ?", array($cell_id))->row_array();

            $what_new = '';
            foreach ($row as $column => $value) {
                if (isset($input_array['update'][$column])) {
                    // ================ Фикс (проверка на пустоту) ==================
                    if($input_array['update'][$column] == false && $value == false) continue;
                    // ==============================================================
                    if ($value != $input_array['update'][$column]) {
                        $title = (isset($input_array['names'][$column])) ? $input_array['names'][$column] : $column;
                        $what_new .= "[$title : $value => {$input_array['update'][$column]}]\r\n";
                    }
                }
            }

            unset($input_array['update'],$input_array['names']);

            if ($what_new) {
                $this->save_activity(2, $what_new, $cell_id, $input_array);
            }
        }


        //============================ Status changed functionality =====================================

        if (isset($_POST['status_id'])) {

            /*include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');*/

            foreach ($adv_rel_inputs as $rel_row) {
                if ($rel_row['name'] == $table_config['status_rel_name']) {

                    // Get previous status id
                    $old_status_id = $CI->db->query("SELECT {$rel_row['status_id_field']} FROM {$input_array['base_table']} WHERE {$input_array['base_table']}.{$table_config['key']} = ?", array($cell_id))->row_array();

                    foreach ($rel_row['status_options'] as $status){
                        if($old_status_id[$rel_row['status_id_field']] == intval($status['status_id'])) {
                            $old_status_name = $status['name'];
                        }
                        if($_POST['status_id'] == $status['status_id']) {
                            $new_status_name = $status['name'];
                            if(isset($status['interval'])) $new_status_interval = $status['interval'];
                        }
                    }
                }
            }


            //$old_status = $CI->db->query("SELECT status FROM orders_status LEFT JOIN realty_orders ON orders_status.id=realty_orders.status_id WHERE realty_orders.id = ?", array($cell_id))->row_array();
            //$new_status = $CI->db->query("SELECT status, interval_hours FROM orders_status WHERE id = ?", array($_POST['status']))->row_array();

            if($old_status_name != $new_status_name) {

            // Remove notification
            $CI->db->where('activity_element_id', $cell_id);
            $CI->db->where('activity_table', $input_array['base_table']);
            $CI->db->update('activities', array('notification_status' => 0));

            // Remove alert on table page
            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($input_array['base_table'], array('alert' => 0));

            /*if(!$old_status) {
                $old_status['status'] = 'Не выбрано';
            }
            if(!$new_status) {
                $new_status['status'] = 'Не выбрано';
                $new_status['interval_hours'] = null;
            }*/

                if(isset($new_status_interval)) {
                    $this->save_activity(5,
                        "Напомнить по истечении времени нахождения в статусе <b>{$new_status_name}</b> [через {$new_status_interval} час.]!!!",
                        $cell_id,
                        $input_array,
                         array('interval' => $new_status_interval, 'notification_status' => 1));
                }

                $this->save_activity(4, "Статус сменился с <b>{$old_status_name}</b> на <b>{$new_status_name}</b>", $cell_id, $input_array);
            }
        }

        if (isset($_SESSION['change_status'])) {
            $this->save_activity(5, "Превышен лимит нахождения в данном статусе. Предупреждение о смене статуса отправлено на почту", $cell_id, $input_array);

            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($input_array['base_table'], array('alert' => 1));
        }

        if (isset($_SESSION['overdue_task'])) {
            $this->save_activity(5, "Просроченное задание! Предупреждение отправлено на почту исполнителя", $cell_id, $input_array);
        }

        //========================================================================================================
    }

    public function db_save($input_array, $cell_id)
    {
        if(trim($_POST['message']) != '') {
           return $this->save_activity(3, $_POST['message'], $cell_id, $input_array);
        }
    }

    public function db_add($input_array, $cell_id)
    {
        // Add status time noty while adding new element
        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');

        foreach ($adv_rel_inputs as $rel_row) {
            if ($rel_row['name'] == $table_config['status_rel_name']) {
                foreach ($rel_row['status_options'] as $status){
                    if($_POST['status_id'] == $status['status_id']) {
                        $new_status_name = $status['name'];
                        if(isset($status['interval'])) $new_status_interval = $status['interval'];
                    }
                }
            }
        }

        if(isset($new_status_interval)) {
            $this->save_activity(5,
                "Напомнить по истечении времени нахождения в статусе <b>{$new_status_name}</b> [через {$new_status_interval} час.]!!!",
                $cell_id,
                $input_array,
                array('interval' => $new_status_interval, 'notification_status' => 1));
        }

        $message = $_POST['message'];
        return $this->save_activity(1, $message, $cell_id, $input_array);
    }

    public function save_activity($type, $text, $item, $data, $another_data = null)
    {
        // ==================================
        include('application/config/pdg_tables/' . $data['base_table'] . '.php');
        // ==================================

        $CI =& get_instance();

        // Access Check
        if(isset($data['custom_activity_table'])) {
            $CI->inside_lib->check_access('inside2_'.$data['custom_activity_table'],'edit');
        } else {
            $CI->inside_lib->check_access('inside2_'.$data['base_table'],'edit');
        }

        // User Info Array (Empty Hash is not bad, its session style)
        $user_info_arr = $CI->inside_lib->get_user_info($CI->session->userdata('user_id'));
        if(isset($another_data['interval']) && $type == 5) {
            $timestamp = strtotime(date("Y-m-d H:i:s")." + "."{$another_data['interval']} hours");
            $datetime = date("Y-m-d H:i:s", $timestamp);
        } else {
            $datetime = date("Y-m-d H:i:s");
        }
        $activity_data = array(
            'role' => $user_info_arr['groups'][0]['name']
        );
        $activity_data = json_encode($activity_data);
        $element_id = intval($item);

        if($type == 1 || $type == 3) {
            $text = $CI->inside_lib->defend_filter(1, $text);
            $what_replace   = array("\r\n", "\n", "\r");
            $replace = '<br />';
            $text = str_replace($what_replace, $replace, $text);
        }

        $input['activity_element_id'] = $element_id;
        $input['activity_user'] = $user_info_arr['id'];
        $input['activity_text'] = $text;
        $input['activity_type_id'] = $type;
        $input['activity_time'] = $datetime;
        $input['activity_data'] = $activity_data;

        if(isset($another_data['notification_status'])) {
            $input['notification_status'] = $another_data['notification_status'];
        }

        if(isset($data['custom_activity_table'])) {
            $CI->inside_lib->defend_filter(4,$data['custom_activity_table']);
            $CI->db->insert($data['custom_activity_table'], $input);
        } else {
            $input['activity_table'] = $data['base_table'];
            $CI->db->insert('activities', $input);
        }

        if($type != 1) {

            $activity = $CI->db->query("SELECT name, icon FROM activities_type WHERE id={$type}")->row_array();

            ob_start(); ?>
            <div style="padding: 10px; border-top: 1px dotted #777;">
                <p style="margin-left: 15px;"><i style="color:#1b6d85" class="fa <?= $activity['icon'];?> fa-lg color-tooltip" data-toggle="tooltip" data-placement="top" title="<?= $activity['name'];?>"></i> <b><i class="fa fa-user" aria-hidden="true"></i> <?= '[#'.$user_info_arr['id'].'] ' . $user_info_arr['users']['fio'];?></b> | <i class="gray"><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $datetime;?></i></p>
                <p style="margin-left: 15px;"><span style="color: #e9573f"><?= $text;?></span></p>
            </div>
            <?php echo ob_get_clean();
        }
    }
}
