<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Many2Many2_multiselect
{


    public function input_form($input_array, $cell_id)
    {
        $select = $input_array['table'] . '.' . $input_array['join_key'] . ', ' . $input_array['table'] . '.' . $input_array['join_name'] . ', ' .
            //$input_array['rel_table'] . '.' . $input_array['join_select'] . ', ' .
            //$input_array['rel_table'] . '.' . $input_array['join_input'] . ', ' .
            $input_array['rel_table'] . '.' . $input_array['rel_join'];

        $sql =
            "SELECT {$select}
             FROM " . $input_array['rel_table'] . "
             LEFT JOIN " . $input_array['table'] . " ON " . $input_array['table'] . "." . $input_array['join_key'] . " = " . $input_array['rel_table'] . "." . $input_array['rel_join'] . "
             WHERE " . $input_array['rel_table'] . "." . $input_array['rel_key'] . " = " . intval($cell_id) . "
            ";
        $CI =& get_instance();
        $query = $CI->db->query($sql);

        $res = $query->result_array();

        ob_start();
        ?>

        <!--SELECT-->
        <br><select name="many2many_<?= $input_array['name'] ?>_multiselect[]" class="multiselect_<?= $input_array['name'] ?>" multiple>
        <?php foreach ($res as $join_row) { ?>
             <option value="<?= $join_row[$input_array['rel_join']] ?>" selected><?= '['. $join_row[$input_array['rel_join']] .'] ' . $join_row[$input_array['join_name']] ?></option>
        <?php } ?>
        </select>

        <link rel="stylesheet" href="/files/jquery_chosen/chosen.min.css">
        <script type="text/javascript" src="/files/jquery_chosen/chosen.jquery.min.js"></script>

        <script>


            $('.multiselect_<?= $input_array['name'] ?>').chosen({ width: '50%' });

            // Удаляем родное окно "не найдено"
            /*$('.chosen-search-input1').on('keyup', function () {
                $('li.no-results').remove();
            });*/

            $('.multiselect_<?= $input_array['name'] ?>').next().find('.chosen-search-input').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '/admin/inside2_ajax/rel_search_type/' + global_pdg_table + '/' + '<?=$input_array['name']?>' + '/',
                        dataType: 'json',
                        data: {q: request.term},
                        success: function (data) {

                            console.log(data);
                            /*if((data.length!='0')) {
                                $('ul.chosen-results').find('li').each(function () {
                                    $(this).remove();//очищаем выпадающий список перед новым поиском
                                });
                                $('select').find('option').each(function () {
                                    $(this).remove(); //очищаем поля перед новым поисков
                                });
                            }*/

                            $('ul.chosen-results').empty(); //очищаем выпадающий список перед новым поиском



                            for (var index in data) {
                                $('.multiselect_<?= $input_array['name'] ?>').append('<option value="' + data[index].<?=$input_array['join_key']?> + '">' + '[' + data[index].<?=$input_array['join_key']?> + '] ' + data[index].<?=$input_array['join_name']?> +'</option>');
                            }
                            $('.multiselect_<?= $input_array['name'] ?>').trigger("chosen:updated");
                        }
                    });
                },
                minLength: 1,
                delay: 500
            });

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

        if (isset($_POST['many2many_' . $input_array['name'] . '_multiselect'])) {

            foreach ($_POST['many2many_' . $input_array['name'] . '_multiselect'] as $join_id) {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }

    public function db_add($input_array, $cell_id)
    {
        if (isset($_POST['many2many_' . $input_array['name'] . '_multiselect'])) {
            $CI =& get_instance();
            foreach ($_POST['many2many_' . $input_array['name'] . '_multiselect'] as $join_id) {
                $join_id = intval($join_id);
                $data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $CI->db->insert($input_array['rel_table'], $data);
            }
        }
    }

}

?>


