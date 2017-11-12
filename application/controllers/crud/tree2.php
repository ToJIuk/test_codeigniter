<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Inside System Controller (Idea from Power Data Grid 2.0.)

class Tree2 extends Controller_Admin
{

    public $__load_default = true;

    public function index() {

        redirect('/tree/tree2/id/0');

    }
    public function id($id = 0) {

        if ( ! $this->ion_auth->is_admin()) exit();


        $this->data['page_center'] = 'tree2/net';

        $res = $this->db->query("SELECT *  FROM it_pm_tree WHERE id = ".intval($id)." LIMIT 1")->result_array();

        if (isset($res[0]))
            $this->data['page_row'] = $res[0];
        else $this->data['page_row']['name'] = 'ROOT';

        // Childrens Array
        $this->data['tree_res'] = $this->db->query("SELECT
                                                      *
                                                    FROM it_pm_tree
                                                    WHERE parent_id = ".intval($id)."
                                                    LIMIT 100
        ")->result_array();

        $this->data['seo_title'] = 'Tree View for #'.intval($id);
        $this->data['seo_description'] = 'Easy Tree View for #'.intval($id);
        $this->data['seo_keywords'] = 'Tree, View, info, '.intval($id);


        $this->__render();

    }

    public function children($id) {

        if ( ! $this->ion_auth->is_admin()) exit();


        $this->data['tree_res'] = $this->db->query("SELECT
                                                      *
                                                    FROM it_pm_tree
                                                    WHERE parent_id = ".intval($id)."
                                                    LIMIT 100
        ")->result_array();

        $this->load->view('outside/pages/tree2/net_childrens', $this->data);

    }

}