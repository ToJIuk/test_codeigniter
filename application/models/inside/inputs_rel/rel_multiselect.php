<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rel_multiselect
{


    public function input_form($input_array, $cell_id)
    {
        $select = $input_array['table'] . '.' . $input_array['join_key'] . ', ' . $input_array['table'] . '.' . $input_array['join_name'] . ', ' .
            $input_array['rel_table'] . '.' . $input_array['rel_join'];

        $sql =
            "SELECT {$select}
             FROM " . $input_array['rel_table'] . "
             LEFT JOIN " . $input_array['table'] . " ON " . $input_array['table'] . "." . $input_array['join_key'] . " = " . $input_array['rel_table'] . "." . $input_array['rel_join'] . "
             WHERE " . $input_array['rel_table'] . "." . $input_array['rel_key'] . " = " . intval($cell_id) . "
            ";
        $sql2 =
            "SELECT {$input_array['join_key']}, {$input_array['join_name']}
             FROM " . $input_array['table'] . "
            ";

        $CI =& get_instance();
        $query = $CI->db->query($sql)->result_array();
        $query2 = $CI->db->query($sql2)->result_array();

        ob_start();
        ?>

        <!--SELECT-->
        <br><select name="rel_<?= $input_array['name'] ?>_multiselect[]" class="rel_<?= $input_array['name'] ?>" multiple>
        <?php foreach ($query2 as $row) { $selected = ''; ?>
            <?php foreach ($query as $join_row) { ?>
                <?php if($join_row[$input_array['rel_join']] == $row[$input_array['join_key']]) $selected = 'selected'; break;?>
            <?php } ?>

            <option value="<?= $row[$input_array['join_key']] ?>"<?=$selected?>>[<?= $row[$input_array['join_key']] ?>] <?= $row[$input_array['join_name']] ?></option>

        <?php } ?>
    </select>

        <link rel="stylesheet" href="/files/jquery_chosen/chosen.min.css">
        <script type="text/javascript" src="/files/jquery_chosen/chosen.jquery.min.js"></script>

        <script>

            $('.rel_<?= $input_array['name'] ?>').chosen({ width: '50%' });

        </script>

        <?php

        $data = ob_get_clean();
        $data .= '<br></select><br /><a href="/inside/table/' . $input_array['table'] . '" target="_blank">Open join table</a><br /><br />';

        return $data;
    }

    public function db_save($input_array, $cell_id)
    {
        $CI =& get_instance();
        $CI->db->query("DELETE FROM " . $input_array['rel_table'] . " WHERE " . $input_array['rel_key'] . " = '" . $cell_id . "'");

        if (isset($_POST['rel_' . $input_array['name'] . '_multiselect'])) {

            foreach ($_POST['rel_' . $input_array['name'] . '_multiselect'] as $join_id) {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }

    public function db_add($input_array, $cell_id)
    {
        if (isset($_POST['rel_' . $input_array['name'] . '_multiselect'])) {
            $CI =& get_instance();
            foreach ($_POST['rel_' . $input_array['name'] . '_multiselect'] as $join_id) {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }

}

?>


