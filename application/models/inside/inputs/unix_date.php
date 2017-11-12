<?php

class Unix_Date {


    public function input_form($input_array)
    {
        if ($input_array['value'] == 0) $input_array['value'] = time();
        $code = "<div class=\"input-group date datetimepicker\">
                    <input type=\"text\" name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" value=\"".date("d.m.Y", intval($input_array['value']))."\" class=\"form-control\">
                    <span class=\"input-group-addon\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>
                </div>";
?>
        <script type="text/javascript">

            $(function () {
                $('.datetimepicker').datetimepicker({
                    locale: 'ru',
                    format: 'L',
                });
            });
        </script>
<?php   echo $code;

        // "<input type=\"text\" name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input\" style=\"width:".$input_array['width']."px\" value=\"".@date("Y-m-d", $input_array['value'])."\" >";

    }
    public function db_save($input_array)
    {
        return strtotime($input_array['value']);
    }
    public function crud_view($input_array)
    {
        if ($input_array['value'] > 1)
            return date("d.m.Y", $input_array['value']);
        else return "";
    }

}
