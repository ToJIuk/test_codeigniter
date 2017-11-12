<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Select_autocomplete
{
    public function input_form($input_array)
    {

        $CI =& get_instance();
        if (isset($input_array['select_sql'])) $sql = $input_array['select_sql'];
        else $sql = "SELECT ".$input_array['select_index'].", ".$input_array['select_field']." FROM ".$input_array['select_table']." ORDER BY ".$input_array['select_field']." ASC";
        $res = $CI->db->query($sql)->result_array();

        $i=0;
        foreach ($res as $row)
        {
            $variants[$i]['name'] = $row [$input_array['select_field']];
            $tmp_index = $input_array['select_index'];
            $variants[$i]['id'] = $row [$tmp_index];
            $i++;
        }

        $i=0;
        $selected= '';
        while (isset ($variants[$i]['id']))
        {
            if ($input_array['value'] == $variants[$i]['id']) $selected = array('id' => $variants[$i]['id'], 'name' => $variants[$i]['name']);
            $i++;
        }

        ob_start();
        ?>


        <!--<select name="<?/*= $input_array['name'] */?>" class="hidden select_<?/*= $input_array['name'] */?>">
            <?php /*if($selected != '') { */?>
                <option value="<?/*=$selected['id']*/?>"><?/*=$selected['name']*/?></option>
            <?php /*} */?>
        </select>-->

        <input type="text"
               name="<?=$input_array['name']?>"
               value="<?php if($selected != '') echo $selected['id']?>"
               class="hidden select_<?= $input_array['name'] ?>">

        <br><input type="text"
                   class="form-control autocomplete_<?= $input_array['name'] ?>"
                   value="<?php if($selected == '') echo 'Не выбрано'; else echo $selected['name'] ?>">

        <script>
            $('.autocomplete_<?= $input_array['name'] ?>').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '/admin/inside2_ajax/autocomplete_search/' + global_pdg_table + '/' + '<?=$input_array['name']?>' + '/',
                        dataType: 'json',
                        data: {q: request.term},
                        success: function (data) {
                            response(data.map(function (value) {
                                return {
                                    key: value.<?=$input_array['select_index']?>,
                                    label: value.<?=$input_array['select_field']?>
                                }
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    /*$('.select_<//?= $input_array['name'] ?>').find('option').remove();
                    $('.select_<//?= $input_array['name'] ?>').append(
                        '<option value="' + ui.item.key + '" selected>' + ui.item.label + '</option>'
                    );*/
                    $('.select_<?= $input_array['name'] ?>').val(ui.item.key);
                },
                minLength: 1
            });
        </script>

        <?php

        $data = ob_get_clean();

        return $data;
    }
}

?>


