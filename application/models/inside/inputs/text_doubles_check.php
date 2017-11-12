<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_doubles_check
{

    public function input_form($input_array)
    {

        ob_start();
        ?>
        <input class="form-control" type="text" id="<?= $input_array['name'] ?>" name="<?= $input_array['name'] ?>"
               value="<?= $input_array['value'] ?>"/>
        <div class="doubles_check_help_<?= $input_array['name'] ?>" style="list-style: none; margin-top: 5px;" ></div>

        <script>

            /*MASKED*/
            <?php if (isset($input_array['mask'])) {  ?>
            <?php if(isset($input_array['placeholder'])) $placeholder = "{placeholder: '{$input_array['placeholder']}'}"; else $placeholder = ''; ?>
                    $('#<?=$input_array['name']?>').mask('<?=$input_array['mask']?>', <?=$placeholder?>);
            <?php } ?>

            /*HELPER*/
            $("#<?=$input_array['name']?>").on("keyup", function () {

                var query = $(this).val();
                if (pdg_timer.doubles_check !== undefined) clearTimeout(pdg_timer.doubles_check);
                pdg_timer.doubles_check = setTimeout(function () {

                    $.get("/admin/inside2_ajax/doubles_check_autocomplete/" + global_pdg_table + '/' + '<?=$input_array['name']?>' + "?q=" + encodeURI(query), function (data) {
                        $('.doubles_check_help_<?= $input_array['name'] ?>').empty();

                        if (data != '') {
                            data = $.parseJSON(data);

                            for (var key in data) {
                                $('.doubles_check_help_<?= $input_array['name'] ?>').append('<a><li index="' + data[key].<?=$input_array['select_index']?> + '">' + data[key].<?=$input_array['select_field']?> + '</li></a>');
                            }

                            // open edit dialog
                            $(".doubles_check_help_<?= $input_array['name'] ?>").find('li').on('click', function () {
                                open_edit_dialog($(this).attr('index'), '<?= $input_array['select_table'] ?>');
                            });
                        } else {
                            $('.doubles_check_help_<?= $input_array['name'] ?>').append('<li>Нет совпадений</li>');
                        }
                    })
                }, 700);
            });

        </script>

        <?php
        $data = ob_get_clean();
        //$data .= '<br /><a href="/inside/table/' . $input_array['table'] . '" target="_blank">Open join table</a><br /><br />';
        return $data;

    }

    public function input_filter($input_array)
    {
        return '<input style="width:100px; height: 10px; border-color:green;" type="text" id="' . $input_array['name'] . '" name="' . $input_array['name'] . '" value="' . $input_array['value'] . '" /><br />';
    }

}
