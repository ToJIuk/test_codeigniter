<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Many2Many_AJAX_Chosen {


    public function input_form($input_array, $cell_id)
    {
        $CI =& get_instance();
        $query = $CI->db->query("SELECT ".$input_array['table'].".".$input_array['join_name'].",".$input_array['table'].".".$input_array['this_key']."  from ".$input_array['rel_table']."
                                    LEFT JOIN ".$input_array['table']." ON ".$input_array['rel_table'].".".$input_array['rel_join']." = ".$input_array['table'].".".$input_array['this_key']."
                                    WHERE ".$input_array['rel_table'].".".$input_array['rel_key']." = ".intval($cell_id)."

                                    ");
        $res = $query->result_array();


        // For Debug
        //print_r($selected_arr);

        $data = '<select name="'.$input_array['name'].'[]" id="'.$input_array['name'].'" multiple="multiple"  class="chosen-multi-select '.$input_array['name'].'" style="width: 80%;">';

        foreach ($res as $join_row)
        {
            $data .= '<option value="'.$join_row[$input_array['join_key']].'" SELECTED>'.$join_row[$input_array['join_name']].' ['.$join_row[$input_array['join_key']].']</option>';
        }

        $data .= '</select><br /><a href="/inside/table/'.$input_array['table'].'" target="_blank">Open join table</a><br /><br />';

        ob_start();
        ?>
        <script type="text/javascript" src="/files/chosen/chosen.ajaxaddition.jquery.js"></script>
        <script>
            $('.chosen-multi-select.<?=$input_array['name']?>').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url:'/products_ac/'
            },{
                loadingImg: 'loading.gif'
            });
        </script>
        <?php
        $data .= ob_get_clean();

        return $data;
    }
    public function db_save($input_array, $cell_id)
    {
        $CI =& get_instance();
        $CI->db->query("DELETE FROM ".$input_array['rel_table']." WHERE ".$input_array['rel_key']." = '".$cell_id."'");
        if ( isset($_POST[$input_array['name']]) )
        {
            foreach ($_POST[$input_array['name']] as $join_id)
            {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }
    public function db_add($input_array, $cell_id)
    {
        $CI =& get_instance();
        if ( isset($_POST[$input_array['name']]) )
        {
            foreach ($_POST[$input_array['name']] as $join_id)
            {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }

}

?>
