<?php

class Group_New_Access {


    public function input_form($input_array, $cell_id)
    {

        ob_start();
        $CI =& get_instance();
        $access_arr =$CI->db->query("
            SELECT groups_access.*
                    FROM groups_access
                    WHERE group_id = ".intval($cell_id)."
        ")->result_array();

        $access_arr_fast = Array();
        foreach ($access_arr as $access_row) {
            $access_arr_fast[$access_row['module_id']] = Array();
            if ($access_row['module_init'] == 1) $access_arr_fast[$access_row['module_id']]['init'] = 1;
            if ($access_row['module_view'] == 1) $access_arr_fast[$access_row['module_id']]['view'] = 1;
            if ($access_row['module_edit'] == 1) $access_arr_fast[$access_row['module_id']]['edit'] = 1;
        };
        // print_r($access_arr_fast);

        $menu_arr = $CI->inside_lib->AdminTreeMenu();

        foreach ($menu_arr as $row)
        {
// No Shift - is row, Shift is open/close parents ul tags
            if (!isset($row['shift']))
            {
                // Link or Static block
                if ($row['url'] != '') $text = '<a href="'.$row['url'].'" title="'.$row['name'].'">'.$row['name'].'</a>';
                else $text = '<a>'.$row['name'].'</a>';
                // Custom Width
                if ($row['width'] > 0) $width = "width: ".$row['width']."px;";
                else $width = "";
                echo '<li style="'.$width.'">'.$text;
                $init_checked = '';
                $view_checked = '';
                $edit_checked = '';

                if (isset($access_arr_fast[$row['id']]['init'])) $init_checked = ' checked';
                if (isset($access_arr_fast[$row['id']]['view'])) $view_checked = ' checked';
                if (isset($access_arr_fast[$row['id']]['edit'])) $edit_checked = ' checked';

                echo '
                      <span><i class="glyphicon glyphicon-off"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_init" name="access_init[]"'.$init_checked.'>
                      <i class="glyphicon glyphicon-eye-open"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_view" name="access_view[]"'.$view_checked.'>
                      <i class="glyphicon glyphicon-edit"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_edit" name="access_edit[]"'.$edit_checked.'></span>
                ';
                // print_r($row);
                if ($row['haschild'] != 1) echo "</li>";
                else $tmp_width_child = $row['width_child'];
            }
            else
            {
                if ($row['action'] == "open")
                {
                    // Add Childs Width Style
                    if ( (isset($tmp_width_child)) && ($tmp_width_child > 0) ) $width_child = "width: ".$tmp_width_child."px;";
                    else $width_child = "";

                    echo "\n".'<ul style="'.$width_child.'">'."\n";
                    $tmp_width_child = '';
                }
                if ($row['action'] == "close") echo "\n</ul></li>\n";
            }
        }

?>
        <style>

            #access_new li span{
                position: absolute;
                left: 350px;
            }
        </style>
        <script>
            $(function(){

                var fast_check_start;
                $('.access_checkbox').on('mousedown', function(){
                    fast_check_start = $(this);
                });
                $('.access_checkbox').on('mouseup', function(){
                    var end_check_element = $(this);
                    var fast_check_start_checked = fast_check_start.is(':checked');

                    if (
                        fast_check_start.attr('name') == end_check_element.attr('name') &&
                        fast_check_start.val() != end_check_element.val()
                    ) {

                        // console.log(fast_check_start.val());
                        // console.log(end_check_element.val());
                        var start_changes = false;

                        $('.access_checkbox[access_type='+end_check_element.attr('access_type')+']').each(function(){

                            if ($(this).val() == fast_check_start.val()) start_changes = true;
                            if ($(this).val() == end_check_element.val()) start_changes = false;

                            if (start_changes) {
                                console.log($(this).val()+' - '+$(this).attr('access_type'));
                                if ( ! fast_check_start_checked) $(this).prop('checked', true);
                                else $(this).prop('checked', false);
                            }

                        });
                        // Final for This Element
                        if ( ! fast_check_start_checked) $(this).prop('checked', true);
                        else $(this).prop('checked', false);
                    }

                });

            });
        </script>
<?php
        return ob_get_clean();
    }
    public function db_save($input_array, $cell_id)
    {

        $CI =& get_instance();
        $CI->db->where('group_id', $cell_id);
        $CI->db->delete('groups_access');

        $access_save_arr = Array();

        if ( isset($_POST['access_init']) ) { foreach($_POST['access_init'] as $init_modules) {

            $access_save_arr[$init_modules]['module_init'] = 1;

        } }
        if ( isset($_POST['access_view']) ) { foreach($_POST['access_view'] as $init_modules) {

            $access_save_arr[$init_modules]['module_view'] = 1;

        } }
        if ( isset($_POST['access_edit']) ) { foreach($_POST['access_edit'] as $init_modules) {

            $access_save_arr[$init_modules]['module_edit'] = 1;

        } }

        foreach ($access_save_arr as $module_id => $access_arr) {

            $access_arr['group_id'] = $cell_id;
            $access_arr['module_id'] = $module_id;
            // print_r($access_arr); echo "<br /><br />";
            $CI->db->insert('groups_access', $access_arr);
        }

        // $data = array($input_array['table_column_row']['rel_key'] => $cell_id, $input_array['table_column_row']['rel_join'] => $join_id);
        //
    }

}
