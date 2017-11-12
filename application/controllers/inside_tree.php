<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inside_tree extends Controller_Admin
{

    private static $test;

//========================= TREE =======================================
    public function tree($table_name = 'it_pm_tree', $parent_id = '0')
    {
// Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'init');

// Check and filter table_name
        if ($table_name == "") $table_name = "default_form";
        $table_name = $this->inside_lib->defend_filter(4, $table_name);
        $this->data['table_name'] = $table_name;

// SEO data
        $this->data['inside_title'] = "Inside Table View : " . $table_name;

        $this->load->model('inside_model');

// Isset Config File
        if (file_exists('application/config/pdg_tables/' . $table_name . '.php')) {
            include('application/config/pdg_tables/' . $table_name . '.php');

            if (isset($table_config)) $this->data['table_config'] = $table_config;

            $filters = $this->inside_model->generate_top_filters2($table_name);

// =========== Status filter =============
            $status_filter_options = array();
            if (isset($table_config['status_rel_name'])) {
                foreach ($adv_rel_inputs as $rel_row) {
                    if ($rel_row['name'] == $table_config['status_rel_name']) {
                        $status_config = $rel_row;
                        $status_filter_options = $status_config['status_options'];
                    }
                }
            }
// =========== Status filter =============

            $this->data['control_form'] = $this->load->view('admin/pages/tree2/inside_tree/inside_form', array('table_name' => $table_name, 'filters' => $filters, 'status_filter_options' => $status_filter_options), TRUE);

// Terminal Message
            $this->data['terminal'] = 'AJAX loading...';

        } else {
// Head Scripts
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';

        }
// Load View
// $this->load->view('inside/main_template/simple_one', $input_view_data);
        $this->data['page_center'] = 'tree2/inside_tree/interface';
// echo "DashBoard";

        $this->__render();

    }

    public function scope_tree()
    {

        $this->load->model('inside_tree_model');

        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);

// Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'view');

// Filtering POST data
        $input_view_data['table_name'] = $table_name;
        $filter['order'] = $this->input->post('pdg_order', true);
        $filter['asc'] = $this->input->post('pdg_asc', true);
        $filter['limit'] = $this->input->post('pdg_limit', true);
        $filter['page'] = $this->input->post('pdg_page', true);
        $filter['fsearch'] = $this->input->post('pdg_fsearch', true);
        $filter['fsearch'] = $this->inside_lib->defend_filter(1, $filter['fsearch']);
        $filter['fkey'] = intval($this->input->post('pdg_fkey', true));
        $filter['order'] = $this->inside_lib->defend_filter(1, $filter['order']);
        $filter['asc'] = $this->inside_lib->defend_filter(1, $filter['asc']);
        $filter['limit'] = intval($filter['limit']);
        $filter['page'] = intval($filter['page']);

// Get Array
        $table_arr = $this->inside_tree_model->get_tree_custom_arr($table_name, $filter);
        $input_view_data['sql'] = $table_arr['sql'];
        $input_view_data['debug'] = $this->input->post('pdg_fsearch', true);





// Wear PDG_view

        $input_view_data['tree_res'] = $table_arr['res'];
        if (isset($table_arr['count_arr'])) {
            $input_view_data['count_arr'] = $table_arr['count_arr'];
        }

        //include data
        include('application/config/pdg_tables/' . $table_name . '.php');
        $input_view_data['table_config'] = $table_config;
        //$input_view_data['table_columns'] = $table_columns;

        if(isset($table_config['sum_function'])) {
            $input_view_data['show_sum_footer'] = true;
        }
        if(isset($table_config['avg_function'])) {
            $input_view_data['show_avg_footer'] = true;
        }

        // IF ADMIN
        if($this->ion_auth->is_admin()) {
            $input_view_data['is_admin'] = true;
        }



        // ================RECURSION=======================
        /*$recursion_count = $this->agregate_recursive($table_name, $table_config['agregation_field']);

        foreach ($input_view_data['tree_res'] as &$item) {
            if($recursion_count[$item[$table_config['key']]]) {
                $item[$table_config['agregation_field']] = $recursion_count[$item[$table_config['key']]];
            }
        }
        unset($item);*/
        // ================RECURSION=======================

        /*echo '<pre>';
        var_dump($count_arr); die();*/
        $this->load->view('admin/pages/tree2/inside_tree/net', $input_view_data);

// ------------------------------------------------------------------------------------------------------

    }

    private function agregate_recursive($table = 'it_pm_tree', $field = 'pdg_color', $parent_id = 0) {

        $res = $this->db->get($table)->result_array();

        $ids = array();

        foreach ($res as $key => $item) {
            if($item['parent_id'] == $parent_id) {
                $ids[] = $item['id'];
            }
        }

        $sum_by_id = array();

        foreach ($ids as $id) {
            $sum_by_id[$id] = $this->recurse($res, $id, $field);
            self::$test  = null;
        }

        return $sum_by_id;
    }

    private function recurse($arr, $parent_id, $field) {
        //static $sum;

        foreach ($arr as $key => $item) {

            if($item['parent_id'] == $parent_id AND $item['haschild'] == 1) {

                $this->recurse($arr, $item['id'], $field);

            } elseif ($item['parent_id'] == $parent_id AND $item['haschild'] == 0) {

                self::$test += intval($item[$field]);
            }
        }

        return self::$test;

        //return $sum;
    }

    public function children($id)
    {
        //if (!$this->ion_auth->is_admin()) exit();

        $this->load->model('inside_tree_model');
        $this->data['table_name'] = $this->inside_lib->defend_filter(4, $this->input->post('pdg_table', true));

        // Access Check
        $this->inside_lib->check_access('inside2_' . $this->data['table_name'], 'view');

        /**/
        // Filtering POST data
        $filter['order'] = $this->input->post('pdg_order', true);
        $filter['asc'] = $this->input->post('pdg_asc', true);
        $filter['limit'] = $this->input->post('pdg_limit', true);
        $filter['page'] = $this->input->post('pdg_page', true);
        //$filter['fsearch'] = $this->input->post('pdg_fsearch', true);
        //$filter['fsearch'] = $this->inside_lib->defend_filter(1, $filter['fsearch']);
        //$filter['fkey'] = intval($this->input->post('pdg_fkey', true));
        $filter['order'] = $this->inside_lib->defend_filter(1, $filter['order']);
        $filter['asc'] = $this->inside_lib->defend_filter(1, $filter['asc']);
        $filter['limit'] = intval($filter['limit']);
        $filter['page'] = intval($filter['page']);
        $filter['parent_id'] = intval($id);

        // Get Array
        $data = $this->inside_tree_model->get_tree_custom_arr($this->data['table_name'], $filter);
        /**/
        $this->data['tree_res'] = $data['res'];
        if (isset($data['count_arr'])) {
            $this->data['count_arr'] = $data['count_arr'];
        }

        // IF ADMIN
        if($this->ion_auth->is_admin()) {
            $this->data['is_admin'] = true;
        }

        // ================RECURSION=======================
        /*include('application/config/pdg_tables/' . $this->data['table_name'] . '.php');
        $recursion_count = $this->agregate_recursive($this->data['table_name'], $table_config['agregation_field'],$id);

        foreach ($this->data['tree_res'] as &$item) {
            if($recursion_count[$item[$table_config['key']]]) {
                $item[$table_config['agregation_field']] = $recursion_count[$item[$table_config['key']]];
            }
        }
        unset($item);*/
        // ================RECURSION=======================

        //include('application/config/pdg_tables/' . $this->data['table_name'] . '.php');

        /*$this->data['tree_res'] = $this->db->query("SELECT
                                                      *
                                                    FROM " . $this->data['table_name'] . "
                                                    WHERE parent_id = " . intval($id) . "
                                                    ORDER BY ". $table_config['order_field'] ."
                                                    LIMIT 100
        ")->result_array();*/
        $this->load->view('admin/pages/tree2/inside_tree/net_childrens', $this->data);
    }

    // ------------------------------------------------------ AJAX Edit Window ------------------------------
    public function edit_dialog()
    {

        $this->load->library('inside_lib');
        $this->load->model('inside_model');
        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);
        $cell_id = intval($this->input->post('cell_id'));

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'view');

        // Get table row
        $edit_cell_arr = $this->inside_model->get_table_cell_arr($table_name, $cell_id);

        // ============== Access system =======================
        //if (!$edit_cell_arr) {
        //echo 'Access denied';
        //die();
        // }// If no access echo message and stop
        // ============== Access system =======================

        // Load Table Config
        include('application/config/pdg_tables/' . $table_name . '.php');
        // Wear table inputs
        foreach ($table_columns as $config_row) {
            $tmp_name = $config_row['name'];
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'edit';
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type']))
                $gen_inputs_arr[$tmp_name] = $this->inside_lib->make_input("input_form", $config_row);
        }
        // Add Relationships to table
        if (isset($adv_rel_inputs)) {
            foreach ($adv_rel_inputs as $rel_input_row) {
                $rel_input_row['base_table'] = $table_name;
                $rel_input_row['make_type'] = 'edit';
                $gen_inputs_arr[$rel_input_row['name']] = $this->inside_lib->make_rel_input("input_form", $rel_input_row, $cell_id);
            }
        }

        // Add Chat Data
        $query = $this->db->query("SELECT * FROM inside_row_chat WHERE row_chat_invisible = 0 AND row_chat_row_id = " . $cell_id . " AND row_chat_table = '" . $table_name . "' ORDER BY row_chat_datetime DESC");
        $this->data['chat_messages'] = $query->result_array();

        // Add All Groups Select
        $this->load->model('inside/custom_interfaces/inside_access/main_model', 'access_custom_model');
        $this->data['group_select'] = $this->access_custom_model->group_select_by_id_return();

        // Load View
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = $this->input->post('dialog_id');
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_config['key'];
        $this->data['table_config'] = $table_config;
        $this->data['table_columns'] = $table_columns;
        if (isset($adv_rel_inputs)) $this->data['adv_rel_inputs'] = $adv_rel_inputs;

        header('Content-Type: text/html; charset=utf-8');
        $this->load->view('admin/pages/tree2/inside_tree/inside_edit_form', $this->data);
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------------------------------ AJAX Edit Window ------------------------------
    // Copy OF Edit Dialog
    public function add_dialog($cell_id = 0, $parent_id = null)
    {
        // << for ADD
        $this->load->library('inside_lib');
        $this->load->model('inside_model');
        $this->load->model('inside_tree_model');
        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');


        // Get table row
        if ($cell_id > 0) $edit_cell_arr = $this->inside_tree_model->get_tree_cell_arr($table_name, $cell_id);
        else $edit_cell_arr = Array(); // << for ADD
        // Load Table Config
        include('application/config/pdg_tables/' . $table_name . '.php');

        // ============== Access system =======================
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {
            if (!$this->ion_auth->in_group($table_config['access_user_work_group'])) {
                echo 'Access denied';
                die();
            }
        }
        // ============== Access system =======================

        // Wear table inputs
        foreach ($table_columns as $config_row) {
            $tmp_name = $config_row['name'];
            if (!isset($edit_cell_arr[$tmp_name])) $edit_cell_arr[$tmp_name] = '';
            if (isset($config_row['default_value'])) $edit_cell_arr[$tmp_name] = $config_row['default_value'];
            if (isset($config_row['default_current_user_id'])) $edit_cell_arr[$tmp_name] = $this->data['user']->id;
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'add'; // << for ADD
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type']))
                $gen_inputs_arr[$tmp_name] = $this->inside_lib->make_input("input_form", $config_row);
        }
        // Add Relationships to table
        if (isset($adv_rel_inputs)) {
            foreach ($adv_rel_inputs as $rel_input_row) {
                $rel_input_row['base_table'] = $table_name;
                $rel_input_row['make_type'] = 'add'; // << for ADD
                $gen_inputs_arr[$rel_input_row['name']] = $this->inside_lib->make_rel_input("input_form", $rel_input_row, $cell_id);
            }
        }

        // Load View
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = $this->input->post('dialog_id');
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_config['key'];
        $this->data['table_config'] = $table_config;
        $this->data['table_columns'] = $table_columns;
        $this->data['parent_id'] = $parent_id;
        if (isset($adv_rel_inputs)) $this->data['adv_rel_inputs'] = $adv_rel_inputs;

        header('Content-Type: text/html; charset=utf-8');
        $this->load->view('admin/pages/tree2/inside_tree/inside_add_form', $this->data); // << for ADD
        // ------------------------------------------------------------------------------------------------------

    }


    // ------------------------------- INSERT, UPDATE, DELETE DB Requests ----------------------------------
    public function edit_request($table_name, $tab, $cell_id)
    {
        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // access system
        if (!$this->access_system_edit('edit', $table_name, $cell_id)) {
            die();
        }

        // ------------------------------------------------------ AJAX EDIT Request ------------------------------
        $this->load->model('inside_tree_model');
        $result = $this->inside_tree_model->update_table_cell($table_name, $tab, $cell_id);
        $input_view_data['message'] = $result;
        $this->load->view('inside/lib/message', $input_view_data);
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------- INSERT, UPDATE, DELETE DB Requests ----------------------------------
    public function fast_edit()
    {

        $table_name = $_POST['table'];
        $cell_id = intval($_POST['line_id']);

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        $this->db->where($_POST['key_id'], $cell_id);
        $this->db->update($table_name, Array($this->input->post('column') => $this->input->post('value', true)));
        echo 1;

    }

    public function add_request($table_name, $parent_id = null)
    {
        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // ============== Access system =======================
        include('application/config/pdg_tables/' . $table_name . '.php');
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {
            if (!$this->ion_auth->in_group($table_config['access_user_work_group'])) {
                echo null;
                die();
            }
        }
        // ============== Access system =======================

        // ------------------------------------------------------ AJAX ADD Request ------------------------------
        $this->load->model('inside_tree_model');
        $result = $this->inside_tree_model->insert_tree_cell($table_name, $parent_id);
        $input_view_data['message'] = $result;
        $this->load->view('inside/lib/message', $input_view_data);
        // ------------------------------------------------------------------------------------------------------

    }

    public function del_request($table_name)
    {

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // access system
        if (!$this->access_system_edit('del', $table_name)) {
            die();
        }

        // ------------------------------------------------------ AJAX DEL Request ------------------------------
        $this->load->model('inside_tree_model');
        $result = $this->inside_tree_model->del_table_cell($table_name);
        $input_view_data['message'] = $result;
        $this->load->view('inside/lib/message', $input_view_data);
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------------------------------------------------------------------------------ACCESS SYSTEM EDIT
    private function access_system_edit($type, $table_name, $cell_id = '')
    {
        // Load Config
        include('application/config/pdg_tables/' . $table_name . '.php');
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {

            $current_user = $this->ion_auth->get_user_id();

            $user_in_work_group = $this->ion_auth->in_group($table_config['access_user_work_group']);

            if ($type === 'edit') {
                $this->db->select('ar_all_edit, ar_group_edit, ar_creator_edit, ar_user_id');
                $access_data = $this->db->get_where($table_name, array($table_config['access_id_column'] => $cell_id), 1)->row_array();

                /*if ($access_data['ar_user_id'] == $current_user) { // old code for all creators
                    return true;
                }*/
                if ($access_data['ar_all_edit'] == 1) {
                    return true;
                } elseif ($access_data['ar_group_edit'] == 1 AND $user_in_work_group) {
                    return true;
                } elseif ($access_data['ar_creator_edit'] == 1 AND $access_data['ar_user_id'] == $current_user AND $user_in_work_group) { // made fix for creator (who in group)
                    return true;
                } else {
                    return false;
                }
            } elseif ($type === 'del') {
                if (isset($_POST['del_ids'])) {

                    $this->db->select('ar_all_edit, ar_group_edit, ar_creator_edit, ar_user_id');
                    $this->db->where_in($table_config['access_id_column'], $_POST['del_ids']);
                    $access_data = $this->db->get($table_name)->result_array();

                    $access_entrance = true;

                    foreach ($access_data as $del_item) {
                        /*if ($del_item['ar_user_id'] == $current_user) { // old code for all creators
                            continue;
                        }*/
                        if ($del_item['ar_all_edit'] == 1) {
                            continue;
                        } elseif ($del_item['ar_group_edit'] == 1 AND $user_in_work_group) {
                            continue;
                        } elseif ($del_item['ar_creator_edit'] == 1 AND $del_item['ar_user_id'] == $current_user AND $user_in_work_group) { // made fix for creator (who in group)
                            continue;
                        } else {
                            $access_entrance = false;
                        }
                    }

                    return $access_entrance;
                }
            }
        }
        return true;
    }

// ------------------------------------------------------------------------------------------------------ACCESS SYSTEM EDIT

    public function change_priority($table_name = '')
    {
        // Access Check
        if (!$this->ion_auth->logged_in()) {
            show_404();
            die();
        }
        if (!$table_name) {
            show_404();
            die();
        }
        $table_name = $this->inside_lib->defend_filter(4, $table_name);
        if (!file_exists('application/config/pdg_tables/' . $table_name . '.php')) {
            show_404();
            die();
        }
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');


        // Load Table Config
        include('application/config/pdg_tables/' . $table_name . '.php');
        $that = $this->input->post('that', true);

        if (isset($that['id_prev'], $that['id_next'])) {

            //intval
            $that['id_prev'] = intval($that['id_prev']);
            $that['id_next'] = intval($that['id_next']);
            $that['id_self'] = intval($that['id_self']);
            $prev = $that['ar_prev'];
            foreach ($prev as &$value) {
                $value = intval($value);
            }
            $prev = implode(', ', $prev);
            unset($value);
            $next = $that['ar_next'];
            foreach ($next as &$value) {
                $value = intval($value);
            }
            $next = implode(', ', $next);
            unset($value);
            //all ids
            $all_ids = $that['id_self'] . ', ' . $prev . ', ' . $next;

            $sql = "UPDATE {$table_name} 
                                    SET {$table_config['priority_field']} = (
                                    case
                                      when {$table_config['key']} = {$that['id_self']} then (SELECT {$table_config['priority_field']} FROM (SELECT * FROM {$table_name}) as subtable WHERE {$table_config['key']} = {$that['id_next']}) - 1
                                      when {$table_config['key']} IN ({$prev}) then {$table_config['priority_field']} - 1
                                      when {$table_config['key']} IN ({$next}) then {$table_config['priority_field']} + 1
                                    end)
                                    WHERE {$table_config['key']} IN ($all_ids)";

        } elseif (isset($that['id_prev']) AND !isset($that['id_next'])) {

            //intval
            $that['id_prev'] = intval($that['id_prev']);
            $that['id_self'] = intval($that['id_self']);

            $sql = "UPDATE {$table_name} 
                                    SET {$table_config['priority_field']} = (SELECT {$table_config['priority_field']} FROM (SELECT * FROM {$table_name}) as subtable WHERE {$table_config['key']} = {$that['id_prev']}) + 1
                                    WHERE {$table_config['key']} = {$that['id_self']}";

        } elseif (isset($that['id_next']) AND !isset($that['id_prev'])) {
            //intval
            $that['id_next'] = intval($that['id_next']);
            $that['id_self'] = intval($that['id_self']);

            $sql = "UPDATE {$table_name} 
                                    SET {$table_config['priority_field']} = (SELECT {$table_config['priority_field']} FROM (SELECT * FROM {$table_name}) as subtable WHERE {$table_config['key']} = {$that['id_next']}) - 1
                                    WHERE {$table_config['key']} = {$that['id_self']}";
        }

        //update
        if ($this->db->query($sql)) echo 'OK!';
        else echo 'ERROR!';

    }
}