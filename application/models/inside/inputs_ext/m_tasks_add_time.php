<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class m_tasks_add_time {


    public function input_form ($input_array)
    {
        return '<input class="hidden form-control" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" />';
    }

    public function input_filter ($input_array)
    {
        return '<input style="width:100px; height: 10px; border-color:green;" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" /><br />';
    }


    public function db_save($input_array)
    {
        if ($input_array['value'] == 0) {
            return time();
        } else {
            return $input_array['value'];
        }

    }


}