<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lang_model extends CI_Model
{
	public function get_all_lang_arr()
	{
		$query = $this->db->query("SELECT * 
									FROM wm_lang
									ORDER BY lang_priority ASC
									");

		return $query->result_array();
	}
	
	public function lang_by_alias_row($alias)
	{
		$query = $this->db->query("SELECT * 
									FROM wm_lang
									WHERE lang_alias = '".$alias."'
									");

		$res = $query->result_array();
		if (isset($res[0])) return $res[0];
		else return false;
	}

}