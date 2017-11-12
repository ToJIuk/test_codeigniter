<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends Controller_Admin
{

    public function menu_search() {

        $result = Array();
        $result['html'] = '';

        $res = $this->inside_lib->menu_search();

        if (isset($res[0]) AND $_GET['query'] != '') {

            foreach ($res as $row) {
                $result['html'] .= '<li><span style="position: relative;"><a href="'.$row['url'].'" title="'.$row['name'].'">'.$row['name'].'</a></span></li>';
            }

        }

        echo json_encode($result);
    }

    public function menu_search_type() {

        $result = Array();
        $result['html'] = '';

        $res = $this->inside_lib->menu_search();

        if (isset($res[0]) AND $_GET['query'] != '') {

            echo json_encode($res);

        }


    }

    public function user_data() {

        $user_info_arr = $this->inside_lib->get_user_info($this->session->userdata('user_id'));
        $info = "";
        $info .= "This user's groups:<br />";
        foreach ($user_info_arr['groups'] as $groups) {$info .= $groups['description']."<br />";}

        $info = str_replace("<br />", "\n", $info);

        echo $info;
    }

}