<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Select_autocomplete_search
{
    public function input_form($input_array)
    {
        ob_start();
        ?>

        <br><input type="text"
                   name="<?= $input_array['name'] ?>"
                   class="form-control select_autocomplete_<?= $input_array['name'] ?>"
                   value="<?= $input_array['value'] ?>"
                   placeholder="Поиск в таблице <?= $input_array['select_table'] ?> по <?= $input_array['select_field'] ?>">

        <script>
            $('.select_autocomplete_<?= $input_array['name'] ?>').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '/admin/inside2_ajax/input_autocomplete_search/' + global_pdg_table + '/' + '<?=$input_array['name']?>' + '/',
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
                minLength: 2
            });
        </script>

        <?php

        $data = ob_get_clean();

        return $data;
    }
}

?>


