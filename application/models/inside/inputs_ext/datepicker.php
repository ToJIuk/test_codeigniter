<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datepicker {


    public function input_form($input_array)
    {
        if ($input_array['value'] == 0) {
            $input_array['value'] = date ("d.m.Y");
        } else {
            $input_array['value'] = DateTime::createFromFormat('Y-m-d', $input_array['value'])->format('d.m.Y');
        }
        ob_start();
        ?>
        <div class="form-group date_group">
        <input name="<?=$input_array['name']?>" class="inputDate_<?=$input_array['name']?> form-control" type="text" value="<?=$input_array['value']?>"/>
        <div class="date_icon date_icon_<?=$input_array['name']?>">
            <i style="color: white;" class="glyphicon glyphicon-calendar"></i>
        </div>
        </div>
        <script>
            $("<?= '.inputDate_'.$input_array['name']?>").mask('00.00.0000');

            $(function(){
                $("<?= '.inputDate_'.$input_array['name']?>").datepicker({
                    dateFormat: 'dd.mm.yy'
                });

                $("<?= '.date_icon_'.$input_array['name']?>").click(function() {
                    $("<?= '.inputDate_'.$input_array['name']?>").focus();
                });

                // Русский язык
                $.datepicker.regional['ru'] = {
                    closeText: 'Закрыть',
                    prevText: '&#x3c;Пред',
                    nextText: 'След&#x3e;',
                    currentText: 'Сегодня',
                    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                        'Июл','Авг','Сен','Окт','Ноя','Дек'],
                    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    isRTL: false
                };
                $.datepicker.setDefaults($.datepicker.regional['ru']);
            });
        </script>
        <?php
        return ob_get_clean();
    }

    public function db_save($input_array)
    {
        return DateTime::createFromFormat('d.m.Y', $input_array['value'])->format('Y-m-d');
    }

    public function crud_view($input_array)
    {
        if ($input_array['value'] != 0) {
            return DateTime::createFromFormat('Y-m-d', $input_array['value'])->format('d.m.Y');
        } else {
            return 'Не установлено';
        }
    }
}