<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Copy of Text Class for Redeclare conflicts!

class Text_model extends CI_Model
{

    var $lbook_en;
    var $lbook;

    public function get_all_vocabulary_arr($lang_alias)
    {
        $query = $this->db->query("SELECT *
									FROM wm_vocabulary
									WHERE vocabulary_lang = '".mysql_real_escape_string($lang_alias)."'
									");

        return $query->result_array();
    }

    public function init($lang_alias)
    {
        $en_vocabulary_arr = $this->get_all_vocabulary_arr('en');
        foreach ($en_vocabulary_arr as $row)
        {
            $this->lbook_en[$row['vocabulary_alias']] = $row['vocabulary_name'];
        }
        $vocabulary_arr = $this->get_all_vocabulary_arr($lang_alias);
        foreach ($vocabulary_arr as $row)
        {
            $this->lbook[$row['vocabulary_alias']] = $row['vocabulary_name'];
        }


    }

    public function get($alias)
    {
        if (isset($this->lbook[$alias])) return $this->lbook[$alias];
        elseif (isset($this->lbook_en[$alias])) return $this->lbook_en[$alias];
        else return "{".$alias."}";
    }
}