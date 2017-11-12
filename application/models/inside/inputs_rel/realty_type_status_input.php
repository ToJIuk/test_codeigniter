<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Realty_type_status_input {

    public function input_form($input_array, $cell_id)
    {
        $CI =& get_instance();

        // ==================================
        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');
        // ==================================

        if($input_array['make_type'] == 'add') {

            foreach ($adv_rel_inputs as $rel_row) {
                if ($rel_row['name'] == $table_config['status_rel_name']) {
                    foreach ($rel_row['status_options'] as $status) {
                        if(isset($status['default_add_selected'])) {
                            $selected_status = $status['status_id'];
                            break 2;
                        } else {
                            $selected_status = "";
                        }
                    }
                }
            }


            $type = $CI->db->query("SELECT * FROM {$input_array['types_list_table']}")->result_array();
            $data = "<label>Тип</label><select name='order_type' id='type' class='input form-control selectpicker'>
                    <option value=''>Не выбрано</option>";

            foreach ($type as $row)
            {
                $data .= "<option value=".$row['id'].">".$row['type_name']."</option>";
            }

            $data .= "</select><br><br><label>Статус</label>";

            $data .= "<select name='status_id' id='status' class='input form-control selectpicker'>";
            foreach ($input_array['status_options'] as $option) {
                if ($option['status_id'] == $selected_status) $selected = " SELECTED"; else $selected = "";
                $data .= "<option value='{$option['status_id']}'$selected>{$option['name']}</option>";
            }
            $data .= "</select>";

        } else {

            $type = $CI->db->query("SELECT * FROM {$input_array['types_list_table']}")->result_array();
            $selected_type = $CI->db->query("SELECT {$input_array['status_type_field']} FROM {$input_array['base_table']} WHERE {$table_config['key']}={$cell_id}")->row_array()[$input_array['status_type_field']];

            //$statuses = $CI->db->query("SELECT orders_status.id, orders_status.status FROM rel_order_type_status LEFT JOIN orders_status ON rel_order_type_status.status_id = orders_status.id WHERE type_id={$selected_type}")->result_array();
            $selected_status = $CI->db->query("SELECT {$input_array['status_id_field']} FROM {$input_array['base_table']} WHERE {$table_config['key']}={$cell_id}")->row_array()[$input_array['status_id_field']];

            $data = "<label>Тип</label><select name='order_type' id='type' class='input form-control selectpicker'>
                    <option value='0'>Не выбрано</option>";

            foreach ($type as $row)
            {
                if ($row['id'] == $selected_type) $selected = " SELECTED"; else $selected = "";
                $data .= "<option value=".$row['id'].$selected.">".$row['type_name']."</option>";
            }

            $data .= "</select><br><br><label>Статус</label>";

            $data .= "<select name='status_id' id='status' class='input form-control selectpicker'>";

            foreach ($input_array['status_options'] as $option) {
                if(in_array($selected_type, $option['type_id'])) {
                    if ($option['status_id'] == $selected_status) $selected = " SELECTED"; else $selected = "";
                    $data .= "<option value=".$option['status_id'].$selected.">".$option['name']."</option>";
                }
            }

            /*foreach ($statuses as $row)
            {
                if ($row['id'] == $selected_status) $selected = " SELECTED"; else $selected = "";
                $data .= "<option value=".$row['id'].$selected.">".$row['status']."</option>";
            }*/

            $data .= "</select>";

            $data .= "<script>

                    /*var old_status = $('#status').val();
                    
                    $('#status').change(function() {
                        var new_status = $('#status').val();
                        console.log(new_status);
                        if(old_status != new_status) {
                            $.ajax({
                                type: 'POST',
                                url: '/inside2/edit_request/".$input_array['base_table']."/".$input_array['tab']."/".$cell_id."',
                                data: { status: new_status},
                                success: function (data) {
                                    $('.activity_comments_holder').prepend(data);
                                    //Delete message 'OK!' on the end
                                    $('.activity_comments_holder font').remove();
                                    old_status = new_status;
                                    inside_temporary_dialog('Status Changed!');
                                }
                            });
                        }
                    });*/
                   
                    </script>";

        }
        
        ob_start(); ?>
        <script>
            $('#type').change(function() {
            var type_id = $('#type').val();
            console.log(type_id);
            $.ajax({
                <?php if(isset($selected_status)) {?>
                    url: "/admin/inside2_ajax/get_statuses_by_type/<?= $input_array['base_table']; ?>/<?= $input_array['name']; ?>/" + type_id +"/<?= $selected_status ?>",
                <?php } else { ?>
                    url: "/admin/inside2_ajax/get_statuses_by_type/<?= $input_array['base_table']; ?>/<?= $input_array['name']; ?>/" + type_id,
                <?php } ?>
                success: function (data) {
                if(data) {
                    $('#status').html(data);
                    $('#status').selectpicker('refresh');
                }
            }
            });
        });
        </script>
        <?php
        $data .= ob_get_clean();
        return $data;
    }

    public function db_save($input_array, $cell_id)
    {
        $CI =& get_instance();

        $CI->inside_lib->check_access('inside2_' . $input_array['base_table'], 'edit');
        $table = $CI->inside_lib->defend_filter(4, $input_array['base_table']);

        // ==================================
        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');
        // ==================================

        /*if(isset($_POST['status'])) {
            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($table, array($input_array['status_id_field'] => $_POST['status']));
        }*/

        if(isset($_POST['status_id'])) {
            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($table, array($input_array['status_id_field'] => $_POST['status_id']));
        }

        if(isset($_POST['order_type'])) {
            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($table, array($input_array['status_type_field'] => $_POST['order_type']));
        }

    }

    public function db_add($input_array, $cell_id)
    {
        $CI =& get_instance();

        $CI->inside_lib->check_access('inside2_' . $input_array['base_table'], 'edit');
        $table = $CI->inside_lib->defend_filter(4, $input_array['base_table']);

        // ==================================
        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');
        // ==================================

        if(isset($_POST['status_id'], $_POST['order_type'])) {
            $CI->db->where($table_config['key'], $cell_id);
            $CI->db->update($table, array($input_array['status_id_field'] => $_POST['status_id'],$input_array['status_type_field'] => $_POST['order_type']));
        }
    }
}