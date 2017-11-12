<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Link {

	public function input_form($input_array)
	{
    	return "<input type=\"text\" name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input form-control\" value=\"".$input_array['value']."\" >
		          <a style='line-height: 27px;' href='".$input_array['value']."' target='_blank'>&gt;&gt;</a>";
	}

	public function crud_view($input_array)
	{
		return "<a href='".$input_array['value']."' target='_blank'>".$input_array['value']."</a>";
	}


}
