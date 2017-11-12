<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_masked {


    public function input_form ($input_array)
    {
        $data = '<input class="form-control" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" />';

        if (isset($input_array['mask'])) {
            if(isset($input_array['placeholder'])) $placeholder = ", {placeholder: '{$input_array['placeholder']}'}"; else $placeholder = '';
            $data .= "<script>$('#{$input_array['name']}').mask('{$input_array['mask']}'".$placeholder.");</script>";
        } /*elseif (isset($input_array['email_mask'])) {
            $data .= "<script>$('#{$input_array['name']}').inputmask({ alias: \"email\"});</script>";
        }*/

        return $data;
    }

    public function input_filter ($input_array)
    {
        return '<input style="width:100px; height: 10px; border-color:green;" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" /><br />';
    }

}