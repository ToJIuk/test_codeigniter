<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Select_from_Table_smart {

    public function input_form($input_array)
    {
        $test_var = rand(1, 9999999);

        $CI =& get_instance();
        if (isset($input_array['select_sql'])) $sql = $input_array['select_sql'];
        else $sql = "SELECT ".$input_array['select_index'].", ".$input_array['select_field']." FROM ".$input_array['select_table']." ORDER BY ".$input_array['select_field']." ASC";
        $res = $CI->db->query($sql)->result_array();
        $data = '';
        $i=0;
        foreach ($res as $row)
        {
            $variants[$i]['name'] = $row [$input_array['select_field']];
            $tmp_index = $input_array['select_index'];
            $variants[$i]['id'] = $row [$tmp_index];
            $i++;
        }
        $data .= "
  		<select name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input form-control selectpicker select-smart_{$input_array['name'] }_{$test_var}\" data-live-search=\"true\">
  		<option value=\"\">Не выбрано</option>
  		";
        $i=0;
        while (isset ($variants[$i]['id']))
        {
            if ($input_array['value'] == $variants[$i]['id']) $selected = " SELECTED"; else $selected = "";
            $data .= "<option value=\"".$variants[$i]['id']."\"".$selected.">".$variants[$i]['name']."</option>";
            $i++;
        }
        $data .= "
  		</select><div class='smart-btn_{$input_array['name']}_{$test_var}'></div>\n\n
  		";

        ob_start(); ?>
		<script>
        $(function(){

            var selected_value = $(".select-smart_<?= $input_array['name'] ?>_<?=$test_var?>").val();

            if(selected_value) {

                $('.smart-btn_<?= $input_array['name'] ?>_<?=$test_var?>').html("<a value_id='" + selected_value + "' style='margin-top: 5px' class='btn btn-success'>Просмотреть</a>");
            }

            $(".select-smart_<?= $input_array['name'] ?>_<?=$test_var?>").on('change',function() {
                $('.smart-btn_<?= $input_array['name'] ?>_<?=$test_var?>').empty();
                var value_id = $(this).val();
                console.log(1);
                if(value_id) {
                    $('.smart-btn_<?= $input_array['name'] ?>_<?=$test_var?>').html("<a value_id='" + value_id + "' style='margin-top: 5px' class='btn btn-success'>Просмотреть</a>");
                }
            });

            $('.smart-btn_<?= $input_array['name'] ?>_<?=$test_var?>').on('click', 'a', function () {
                    var cell_id = $(this).attr('value_id');
                    open_edit_dialog(cell_id, '<?= $input_array['select_table']; ?>');
            });
		});
		</script>
        <?php
        $data .= ob_get_clean();
        return $data;
    }
}
