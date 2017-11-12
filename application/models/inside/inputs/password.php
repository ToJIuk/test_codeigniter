<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Password {


	public function input_form($input_array)
	{
      return "<input type=\"password\" name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input form-control\" value=\"\">";
	}
	public function db_save($input_array)
	{
		return false;
	}

}
