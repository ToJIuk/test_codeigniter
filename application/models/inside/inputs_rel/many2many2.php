<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Many2Many2
{
    public function input_form($input_array, $cell_id)
    {
        $CI =& get_instance();

        $select = $input_array['table'] . '.' . $input_array['join_key'] . ', ' . $input_array['table'] . '.' . $input_array['join_name'];
        if (isset($input_array['join_select'])) $select .= ' , ' . $input_array['rel_table'] . '.' . $input_array['join_select'];
        if (isset($input_array['join_input'])) $select .= ' , ' . $input_array['rel_table'] . '.' . $input_array['join_input'];

        $sql =
            "SELECT {$select}
             FROM " . $input_array['rel_table'] . "
             LEFT JOIN " . $input_array['table'] . " ON " . $input_array['table'] . "." . $input_array['join_key'] . " = " . $input_array['rel_table'] . "." . $input_array['rel_join'] . "
             WHERE " . $input_array['rel_table'] . "." . $input_array['rel_key'] . " = " . intval($cell_id) . "
            ";
        $query = $CI->db->query($sql);
        $selected_arr = $query->result_array();

        // join select options
        $join_select_options = '';
        if (isset($input_array['join_select_variants'])) {
            foreach ($input_array['join_select_variants'] as $value) {
                $join_select_options .= '<option>' . $value['name'] . '</option>';
            }
        }

        ob_start();
        ?>

        <div class="rel_items_box_<?= $input_array['name'] ?>"
             style="border: 1px solid #ddd; border-radius: 3px; width: 50%; padding: 7px 5px 5px 5px">
            <input type="text" class="form-control rel_add_autocomplete_<?= $input_array['name'] ?>">

            <?php
            foreach ($selected_arr as $join_row) {
                ?>

                <div style="margin-top:4px; border-top:1px solid #ddd; padding-top:7px;">

                    <!--ROW-->
                    <b>[#<?= $join_row[$input_array['join_key']] ?>] <?= $join_row[$input_array['join_name']] ?></b>
                    <input type="hidden" name="many2many_<?= $input_array['name'] ?>_ids[]"
                           value="<?= $join_row[$input_array['join_key']] ?>">

                    <!--CONTROLS-->
                    <i class="pull-right btn-default btn-xs glyphicon glyphicon-remove del_join_btn"></i>
                    <i join_key_value="<?= $join_row[$input_array['join_key']] ?>"
                       class="pull-right btn-default btn-xs glyphicon glyphicon-pencil edit_join_btn"></i>

                    <!--JOIN INPUT-->
                    <?php if(isset($input_array['join_input'])) {?>
                    <br><input name="many2many_<?= $input_array['name'] ?>_join_input[]"
                               type="text" value="<?= $join_row[$input_array['join_input']] ?>"
                               placeholder="type here..." style="border: none; color: #aaa; font-style: italic">
                    <?php } ?>

                    <!--SELECT-->
                <?php if(isset($input_array['join_select'], $input_array['join_select_variants'])) {?>
                    <select name="many2many_<?= $input_array['name'] ?>_join_select[]">
                        <?php foreach ($input_array['join_select_variants'] as $value) : ?>
                            <option value="<?= $value['name'] ?>" <?php if ($value['name'] == $join_row[$input_array['join_select']]) echo 'selected' ?>><?= $value['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php } ?>


                </div>

                <?php
            }

            ?>

        </div>

        <script>

            // Open item edit dialog
            $('.rel_items_box_<?= $input_array['name'] ?>').on('click', '.edit_join_btn', function () {
                open_edit_dialog($(this).attr('join_key_value'), '<?=$input_array['table']?>');
            });

            // Delete rel
            $('.rel_items_box_<?= $input_array['name'] ?>').on('click', '.del_join_btn', function () {
                    $(this).parent().remove();
            });

            //Add new rel autocomplete
            $('input.rel_add_autocomplete_<?=$input_array['name']?>').autocomplete({
                source: function (request, response) {
                    response([{key: '0', label: 'Add new'}]);
                    $.ajax({
                        url: '/admin/inside2_ajax/rel_search_type/' + global_pdg_table + '/' + '<?=$input_array['name']?>' + '/',
                        dataType: 'json',
                        data: {q: request.term},
                        success: function (data) {
                            response(data.map(function (value) {
                                return {
                                    key: value.<?=$input_array['join_key']?>,
                                    label: value.<?=$input_array['join_name']?>
                                }
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    // if push add new one
                    if (ui.item.key == 0) {
                        open_add_dialog('<?=$input_array['table']?>');
                    } else {
                        // getting select options
                        /*var join_select_options;
                        $.get('/admin/inside2_ajax/get_join_select_options/' + global_pdg_table + '/' + '<=$input_array['name']>' + '/', function (data) {
                            join_select_options = data;
                        });*/
                        /*$('.rel_items_box <//?= $input_array['name'] ?>').append(
                            '<div style="margin-top:4px; border-top:1px solid #ddd; padding-top:7px;">' +
                            '<b>[#' + ui.item.key + '] ' + ui.item.label + '</b>' +
                            '<input type="hidden" name="many2many_<//?= $input_array['name'] ?>_ids[]" value="' + ui.item.key + '">' +
                            '<i class="pull-right btn-default btn-xs glyphicon glyphicon-remove del_join_btn"></i>' +
                            '<i join_key_value="' + ui.item.key + '" class="pull-right btn-default btn-xs glyphicon glyphicon-pencil edit_join_btn"></i>' +
                            '<br><input type="text" name="many2many_<//?= $input_array['name'] ?>_join_input[]" placeholder="type here..." style="border: none; color: #aaa; font-style: italic">' +
                            '<select name="many2many_<//?= $input_array['name'] ?>_join_select[]"><//?=$join_select_options?></select>' +
                            '</div>'
                        );
                        */

                        var html_join_input = '';
                        var html_join_select = '';
                        <?php if(isset($input_array['join_input'])) {?>
                        html_join_input = '<input type="text" name="many2many_<?= $input_array['name'] ?>_join_input[]" placeholder="type here..." style="border: none; color: #aaa; font-style: italic">';
                        <?php } ?>
                        <?php if(isset($input_array['join_select'], $input_array['join_select_variants'])) {?>
                        html_join_select = '<select name="many2many_<?= $input_array['name'] ?>_join_select[]"><?=$join_select_options?></select>';
                        <?php } ?>


                        $('.rel_items_box_<?= $input_array['name'] ?>').append(
                            '<div style="margin-top:4px; border-top:1px solid #ddd; padding-top:7px;">' +
                            '<b>[#' + ui.item.key + '] ' + ui.item.label + '</b>' +
                            '<input type="hidden" name="many2many_<?= $input_array['name'] ?>_ids[]" value="' + ui.item.key + '">' +
                            '<i class="pull-right btn-default btn-xs glyphicon glyphicon-remove del_join_btn"></i>' +
                            '<i join_key_value="' + ui.item.key + '" class="pull-right btn-default btn-xs glyphicon glyphicon-pencil edit_join_btn"></i><br>' +
                            html_join_input + html_join_select + '</div>'
                        );
                    }
                },
                minLength: 1,
                delay: 500
            });
        </script>

        <?php

        $data = ob_get_clean();
        $data .= '<br /><a href="/inside/table/' . $input_array['table'] . '" target="_blank">Open join table</a><br /><br />';
        return $data;

    }

    public function db_save($input_array, $cell_id)
    {
        $CI =& get_instance();
        $CI->db->query("DELETE FROM " . $input_array['rel_table'] . " WHERE " . $input_array['rel_key'] . " = '" . $cell_id . "'");

        if (isset($_POST['many2many_' . $input_array['name'] . '_ids'])) {
            foreach ($_POST['many2many_' . $input_array['name'] . '_ids'] as $key => $value) {

                $join_id = intval($value);
                //$join_input = $_POST['many2many_' . $input_array['name'] . '_join_input'][$key];
                //$select = $_POST['many2many_' . $input_array['name'] . '_join_select'][$key];
                $data = array(
                    $input_array['rel_key'] => $cell_id,
                    $input_array['rel_join'] => $join_id,
                    //$input_array['join_input'] => $join_input,
                    //$input_array['join_select'] => $select,
                );

                if(isset($_POST['many2many_' . $input_array['name'] . '_join_input'])) {
                    $join_input = $_POST['many2many_' . $input_array['name'] . '_join_input'][$key];
                    $data[$input_array['join_input']] = $join_input;
                }

                if(isset($_POST['many2many_' . $input_array['name'] . '_join_select'])) {
                    $select = $_POST['many2many_' . $input_array['name'] . '_join_select'][$key];
                    $data[$input_array['join_select']] = $select;
                }

                $CI->db->insert($input_array['rel_table'], $data);

            }
        }
    }

    public function db_add($input_array, $cell_id)
    {
        $CI =& get_instance();

        if (isset($_POST['many2many_' . $input_array['name'] . '_ids'])) {
            foreach ($_POST['many2many_' . $input_array['name'] . '_ids'] as $key => $value) {

                $join_id = intval($value);
                //$join_input = $_POST['many2many_' . $input_array['name'] . '_join_input'][$key];
                //$select = $_POST['many2many_' . $input_array['name'] . '_join_select'][$key];
                $data = array(
                    $input_array['rel_key'] => $cell_id,
                    $input_array['rel_join'] => $join_id,
                    //$input_array['join_input'] => $join_input,
                    //$input_array['join_select'] => $select,
                );

                if(isset($_POST['many2many_' . $input_array['name'] . '_join_input'])) {
                    $join_input = $_POST['many2many_' . $input_array['name'] . '_join_input'][$key];
                    $data[$input_array['join_input']] = $join_input;
                }

                if(isset($_POST['many2many_' . $input_array['name'] . '_join_select'])) {
                    $select = $_POST['many2many_' . $input_array['name'] . '_join_select'][$key];
                    $data[$input_array['join_select']] = $select;
                }

                $CI->db->insert($input_array['rel_table'], $data);

            }
        }
    }

}
