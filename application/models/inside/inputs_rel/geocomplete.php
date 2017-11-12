<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Geocomplete
{
    public function input_form($input_array, $cell_id)
    {
        if ($input_array['make_type'] == 'edit') {
            $CI =& get_instance();
            if(isset($input_array['set_fields']['lat'],$input_array['set_fields']['lng'])) {
                $res = $CI->db->query("SELECT geo_lng, geo_lat FROM {$input_array['base_table']} WHERE id = ?", array($cell_id))->row_array();
            }
        }
        ob_start();
        ?>
        <style>
            #show_map {
                height: 248px;
                width: 100%;
                -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
                box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2);
                margin-bottom: 10px;
            }

            #data_div {
                margin-top: 15px;
            }

            #data_div span {
                font-weight: bold;
            }
        </style>
        <div class="geodata">

            <input type="text" id="input_map" class="form-control input_map">
            <br>
            <div>
                <button class="btn btn-primary all-data">Все данные</button>
                <button class="btn btn-success add-new-data hidden">Подставить новые данные</button>
                <br>
                <div id="data_div" hidden>
                    <li>Широта: <span data-geo="lat"></span></li>
                    <li>Долгота: <span data-geo="lng"></span></li>
                    <li>Улица: <span data-geo="route"></span></li>
                    <li>Номер дома: <span data-geo="street_number"></span></li>
                    <li>Почтовый код: <span data-geo="postal_code"></span></li>
                    <li>Населенный пункт: <span data-geo="locality"></span></li>
                    <li>Страна: <span data-geo="country_short"></span></li>
                    <li>Область: <span data-geo="administrative_area_level_1"></span></li>
                </div>
                <br>
                <div id="show_map"></div>
            </div>
        </div>
        <script>
            // Fix for geocomplete
            $('a[href="#<?= $input_array['tab']; ?>"]').on('click', function () {
                if (test_settings.geo) {
                    test_settings.geo = false;
                    $(document).ready(function () {
                        $('.edit_dialog_update').click();
                        $('a[href="#<?= $input_array['tab']; ?>"]').click();
                    });
                }
            });

            $('#input_map').geocomplete({
                details: '#data_div',
                detailsAttribute: "data-geo",
                map: '#show_map',
                <?php if ($input_array['make_type'] == 'edit') { ?>
                    <?php if(isset($input_array['set_fields']['lat'],$input_array['set_fields']['lng'])) { ?>
                    location: [<?= $res['geo_lat'] ?>,<?= $res['geo_lng'] ?>],
                    <?php } ?>
                <?php } ?>
                mapOptions: {
                    zoom: 16
                },
                markerOptions: {
                    draggable: true
                }
            });

            $('.all-data').on('click', function (event) {
                event.preventDefault();
                $("#data_div").toggle(400);
            });

            // Для проверки
            var geodata_refresh = false;

            // Убираем фокус
            $('.input_map').keyup(function (e) {
                var code = e.which;
                if(code==13) {
                    $('.input_map').blur();
                }
            });

            // При изменении geocomplete показываем кнопку
            <?php if(isset($input_array['set_fields'])) {?>
            $('.input_map').change(function () {
                setTimeout(function () {
                    <?php foreach ($input_array['set_fields'] as $data_geo => $input_name) { ?>
                    if ($("#data_div span[data-geo=<?= $data_geo; ?>]").text()) {
                        geodata_refresh = true;
                    }
                    <?php } ?>

                    if (geodata_refresh) {
                        $('.add-new-data').removeClass('hidden');
                    }
                }, 700);
            });

            // Подстановка данных в инпуты
            $('.add-new-data').click(function (event) {
                event.preventDefault();
                <?php foreach ($input_array['set_fields'] as $data_geo => $input_name) { ?>
                $('input[name=<?= $input_name;?>]').val($("#data_div span[data-geo=<?= $data_geo; ?>]").text());
                <?php } ?>
            });
            <?php } ?>
        </script>
        <?php
        return ob_get_clean();
    }
}