<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Html {


	public function input_form($input_array)
	{
		// NEED To Remove to HTML input
		$CI =& get_instance();
		if ($CI->ion_auth->is_admin() || $CI->ion_auth->in_group('content')) {
			$_SESSION['kcf'] = 'a_dHgykd_sd7w';
		}

    	if (!isset ($input_array['height'])) {$input_array['width'] = 500; $input_array['height'] = 200;}
    	return "<br /><textarea name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input html_editor\" style=\"width:".$input_array['width']."px;height:".$input_array['height']."px;\">".$input_array['value']."</textarea>";
	}


}