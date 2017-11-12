<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model
{
    public function get_user_bills_arr($user_id)
    {
        $query = $this->db->query("SELECT *
										FROM wm_billing
										WHERE bill_user_id = ".intval($user_id)."
										ORDER BY bill_time DESC
										");

        return $query->result_array();

    }

    public function get_user_bills_arr_count($user_id, $limit = 300)
    {
        $query = $this->db->query("SELECT *
										FROM wm_billing
										WHERE bill_user_id = ".intval($user_id)."
										ORDER BY bill_time DESC
										LIMIT {$limit}
										");

        return $query->result_array();

    }

    public function get_user_ballance($user_id)
    {
        $query = $this->db->query("SELECT sum(bill_value) as sum
										FROM wm_billing
										WHERE bill_user_id = ".intval($user_id)."
										");

        $res =  $query->result_array();


        return intval($res[0]['sum']);

    }

    public function add_bill($user_id, $value, $info, $bill_type = 0)
    {
        $insert_arr['bill_user_id'] = intval($user_id);
        $insert_arr['bill_value'] = intval($value);
        $insert_arr['bill_time'] = time();
        $insert_arr['bill_info'] = mysql_real_escape_string($info);
        $insert_arr['bill_type'] = intval($bill_type);


        $this->db->insert('wm_billing', $insert_arr);

        return true;

    }


    public function get_user_full_row_by_alias($alias) {
        $query = $this->db->query("SELECT
                                        *
										FROM users

										WHERE alias = '".mysql_real_escape_string($alias)."'
										LIMIT 1
										");

        $res = $query->result_array();

        if (isset($res[0])) return $res[0];
        else return false;
    }

    public function get_user_full_row_by_email($email) {
        $query = $this->db->query("SELECT
                                        *
										FROM users

										WHERE email = '".mysql_real_escape_string($email)."'
										LIMIT 1
										");

        $res = $query->result_array();

        if (isset($res[0])) return $res[0];
        else return false;
    }

    public function get_user_full_row_by_tel($tel) {
        $query = $this->db->query("SELECT
                                        *
										FROM users

										WHERE phone = '".mysql_real_escape_string($tel)."'
										LIMIT 1
										");

        $res = $query->result_array();

        if (isset($res[0])) return $res[0];
        else return false;
    }

    public function get_user_full_row($user_id) {
        $query = $this->db->query("SELECT
                                        *
										FROM users

										WHERE id = ".intval($user_id)."
										LIMIT 1
										");

        $res = $query->result_array();

        if (isset($res[0])) return $res[0];
        else return false;
    }



    public function check_username($username, $user_id = 0) {

        $users_arr = $this->get_users_table_arr();

        $return = false;

        foreach ($users_arr as $user_row) {
            if ($user_row['username'] == $username && $user_row['id'] != $user_id)
                $return = true;
        }

        return $return;

    }


    public function users_list($page = '1')
    {

        if ($page == 'all') $limit = "LIMIT 999";
        else $limit = "LIMIT ".( (intval($page) - 1)*50).",50";

        $query = $this->db->query("SELECT users.*
										FROM users
										ORDER BY id DESC
										{$limit}
										");

        return $query->result_array();
    }


    public function users_count()
    {
        $query = $this->db->query("SELECT count(*) as pages_count
										FROM users
									");

        $res = $query->result_array();
        return $res[0]['pages_count'];
    }

    public function ajax_autocomplite_by_get_query($query = '') {

        $query = $this->db->query("SELECT users.username
										FROM users
										WHERE
										UPPER(users.username) LIKE UPPER('%".mysql_real_escape_string($query)."%')
										ORDER BY adv_priority, username ASC
										LIMIT 7
										");
        return $query->result_array();

    }

}