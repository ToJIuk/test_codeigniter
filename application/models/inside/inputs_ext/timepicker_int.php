<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timepicker_int {

    public function input_form($input_array)
    {
        if ($input_array['value'] == 0) {
            if(isset($input_array['interval'])) {
                $input_array['value'] = date('d.m.Y H:i:s',strtotime("{$input_array['interval']}"));
            } else {
                $input_array['value'] = date("d.m.Y H:i:s");
            }
        } else {
            $input_array['value'] = date ("d.m.Y H:i:s", $input_array['value']);
        }
        ob_start();
        ?>
        <div class="form-group date_group">
            <input name="<?=$input_array['name']?>" class="inputTime_<?=$input_array['name']?> form-control" type="text" value="<?=$input_array['value']?>"/>
            <div class="date_icon time_icon_<?=$input_array['name']?>">
                <i style="color: white;" class="glyphicon glyphicon-time"></i>
            </div>
        </div>

        <script>
            $("<?= '.inputTime_'.$input_array['name']?>").mask('00.00.0000 00:00:00');

            $(function(){
                $("<?= '.inputTime_'.$input_array['name']?>").datetimepicker({
                    showSecond: true,
                    dateFormat: 'dd.mm.yy',
                    timeFormat: 'HH:mm:ss',
                    timeOnlyTitle: 'Выберите время',
                    timeText: 'Время',
                    hourText: 'Часы',
                    minuteText: 'Минуты',
                    secondText: 'Секунды',
                    currentText: 'Сейчас',
                    closeText: 'Закрыть'
                });

                $("<?= '.time_icon_'.$input_array['name']?>").click(function() {
                    $("<?= '.inputTime_'.$input_array['name']?>").focus();
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
        return strtotime($input_array['value']);
    }

    public function crud_view($input_array)
    {
        if ($input_array['value'] != 0) {
            return date("d.m.Y H:i:s", $input_array['value']);
        } else {
            return 'Не установлено';
        }
    }
}