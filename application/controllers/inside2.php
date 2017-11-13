<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inside2 extends Controller_Admin
{

    function __construct()
    {

        session_start();
        parent::__construct();

    }

    public function index()
    {
        redirect('/inside/table/realty_orders/');
    }

    public function table($table_name = 'inside_top_menu')
    {
        if (!empty($_GET)){
            $this->load->model('inside_model');
            $this->inside_model->generate_docx($_GET['id']);
        }

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

            $this->data['control_form'] = $this->load->view('admin/pages/inside/inside_form', array('table_name' => $table_name, 'filters' => $filters, 'status_filter_options' => $status_filter_options), TRUE);

            // Terminal Message
            $this->data['terminal'] = 'AJAX loading...';

        } else {
            // Head Scripts
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';

        }
        // Load View
        // $this->load->view('inside/main_template/simple_one', $input_view_data);
        $this->data['page_center'] = 'inside/interface';
        // echo "DashBoard";

        $this->__render();

        // ------------------------------------------------------------------------------------------------------

    }

    public function scope()
    {

        $this->load->model('inside_model');

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
        $table_arr = $this->inside_model->get_table_arr($table_name, $filter);
        $input_view_data['table_arr'] = $table_arr['res'];
        $input_view_data['sql'] = $table_arr['sql'];
        $input_view_data['debug'] = $this->input->post('pdg_fsearch', true);
        // Wear PDG_view
        $this->load->view('admin/pages/inside/inside_table', $input_view_data);

        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------------------------------ AJAX Edit Window ------------------------------
    public function edit_dialog()
    {

        $this->load->library('inside_lib');
        $this->load->library('inside_lib');
        $this->load->model('inside_model');
        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);
        $cell_id = intval($this->input->post('cell_id'));

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'view');

        // Get table row
        $edit_cell_arr = $this->inside_model->get_table_cell_arr($table_name, $cell_id);

        //$user_grops = $this->ion_auth->group()->result_array();


        //  ================= Check column access ===============
        $user_groups_ion = $this->ion_auth->get_users_groups()->result_array();
        $user_groups = array();
        foreach ($user_groups_ion as $group) {
            $user_groups[] = $group['name'];
        }
        unset($user_groups_ion);
        //  ================= Check column access ===============

        // ============== Access system =======================
        //if (!$edit_cell_arr) {
        //echo 'Access denied';
        //die();
        // }// If no access echo message and stop
        // ============== Access system =======================

        // Load Table Config
        include('application/config/pdg_tables/' . $table_name . '.php');

        // =================Tabs access==============
        $unaccess_tabs = array();
        if (isset($table_config['tabs_access'])) {
            foreach ($table_config['tabs_access'] as $key => $groups) {
                if(!array_intersect($user_groups, $groups)) {
                    $unaccess_tabs[] = $key;
                }
            }
        }
        // =================Tabs access==============

        // Wear table inputs
        foreach ($table_columns as $config_row) {
            $tmp_name = $config_row['name'];
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'edit';
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type']))
                // Check column access
                if(!isset($config_row['group_access_arr']) OR array_intersect($user_groups, $config_row['group_access_arr'])) {
                    $gen_inputs_arr[$tmp_name] = $this->inside_lib->make_input("input_form", $config_row);
                }
        }
        // Add Relationships to table
        if (isset($adv_rel_inputs)) {
            foreach ($adv_rel_inputs as $rel_input_row) {
                if(!isset($rel_input_row['group_access_arr']) OR array_intersect($user_groups, $rel_input_row['group_access_arr'])) {
                    $rel_input_row['base_table'] = $table_name;
                    $rel_input_row['make_type'] = 'edit';
                    $gen_inputs_arr[$rel_input_row['name']] = $this->inside_lib->make_rel_input("input_form", $rel_input_row, $cell_id);
                }
            }
        }

        // Add Chat Data
        $query = $this->db->query("SELECT * FROM inside_row_chat WHERE row_chat_invisible = 0 AND row_chat_row_id = " . $cell_id . " AND row_chat_table = '" . $table_name . "' ORDER BY row_chat_datetime DESC");
        $this->data['chat_messages'] = $query->result_array();

        // Add All Groups Select
        // NEED Refactoring!
        // $this->load->model('inside/custom_interfaces/inside_access/main_model', 'access_custom_model');
        // $this->data['group_select'] = $this->access_custom_model->group_select_by_id_return();

        $this->data['group_select'] = '';


        // Load View
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = $this->input->post('dialog_id');
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_config['key'];
        $this->data['table_config'] = $table_config;
        $this->data['table_columns'] = $table_columns;
        $this->data['unaccess_tabs'] = $unaccess_tabs;
        if (isset($adv_rel_inputs)) $this->data['adv_rel_inputs'] = $adv_rel_inputs;

        header('Content-Type: text/html; charset=utf-8');
        $this->load->view('admin/pages/inside/inside_edit_form', $this->data);
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------------------------------ AJAX Edit Window ------------------------------
    // Copy OF Edit Dialog
    public function add_dialog($cell_id = 0)
    { // << for ADD
        $this->load->library('inside_lib');
        $this->load->model('inside_model');
        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        //  ================= Check column access ===============
        $user_groups_ion = $this->ion_auth->get_users_groups()->result_array();
        $user_groups = array();
        foreach ($user_groups_ion as $group) {
            $user_groups[] = $group['name'];
        }
        unset($user_groups_ion);
        //  ================= Check column access ===============


        // Get table row
        if ($cell_id > 0) $edit_cell_arr = $this->inside_model->get_table_cell_arr($table_name, $cell_id);
        else $edit_cell_arr = Array(); // << for ADD
        // Load Table Config
        include('application/config/pdg_tables/' . $table_name . '.php');

        // ============== Access system =======================
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {
            if (!$this->ion_auth->in_group($table_config['access_work_groups'])) {
                echo 'Access denied'; die();
            }
        }
        // ============== Access system =======================

        // =================Tabs access==============
        $unaccess_tabs = array();
        if (isset($table_config['tabs_access'])) {
            foreach ($table_config['tabs_access'] as $key => $groups) {
                if(!array_intersect($user_groups, $groups)) {
                    $unaccess_tabs[] = $key;
                }
            }
        }
        // =================Tabs access==============

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

            if (isset($config_row['input_type'])) {
                if(!isset($config_row['group_access_arr']) OR array_intersect($user_groups, $config_row['group_access_arr'])) { // CHECK INPUT ACCESS
                    $gen_inputs_arr[$tmp_name] = $this->inside_lib->make_input("input_form", $config_row);
                }
            }
        }
        // Add Relationships to table
        if (isset($adv_rel_inputs)) {
            foreach ($adv_rel_inputs as $rel_input_row) {
                if(!isset($rel_input_row['group_access_arr']) OR array_intersect($user_groups, $rel_input_row['group_access_arr'])) { // CHECK INPUT ACCESS
                    $rel_input_row['base_table'] = $table_name;
                    $rel_input_row['make_type'] = 'add'; // << for ADD
                    $gen_inputs_arr[$rel_input_row['name']] = $this->inside_lib->make_rel_input("input_form", $rel_input_row, $cell_id);
                }
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
        $this->data['unaccess_tabs'] = $unaccess_tabs;
        if (isset($adv_rel_inputs)) $this->data['adv_rel_inputs'] = $adv_rel_inputs;

        header('Content-Type: text/html; charset=utf-8');
        $this->load->view('admin/pages/inside/inside_add_form', $this->data); // << for ADD
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------- INSERT, UPDATE, DELETE DB Requests ----------------------------------
    public function edit_request($table_name, $tab, $cell_id)
    {
        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // access system
        if (!$this->access_system_edit('edit',$table_name, $cell_id)) {
            die();
        }

        // ------------------------------------------------------ AJAX EDIT Request ------------------------------
        $this->load->model('inside_model');
        $result = $this->inside_model->update_table_cell($table_name, $tab, $cell_id);
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

    public function add_request($table_name)
    {

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // ============== Access system =======================
        include('application/config/pdg_tables/' . $table_name . '.php');
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {
            if(!$this->ion_auth->in_group($table_config['access_work_groups'])) {
                echo null; die();
            }
        }
        // ============== Access system =======================

        // ------------------------------------------------------ AJAX ADD Request ------------------------------
        $this->load->model('inside_model');
        $result = $this->inside_model->insert_table_cell($table_name);
        $input_view_data['message'] = $result;
        $this->load->view('inside/lib/message', $input_view_data);
        // ------------------------------------------------------------------------------------------------------

    }

    public function del_request($table_name)
    {

        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // access system
        if (!$this->access_system_edit('del',$table_name)) {
            die();
        }

        // ------------------------------------------------------ AJAX DEL Request ------------------------------
        $this->load->model('inside_model');
        $result = $this->inside_model->del_table_cell($table_name);
        $input_view_data['message'] = $result;
        $this->load->view('inside/lib/message', $input_view_data);
        // ------------------------------------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------- AJAX Part of Chat System -------
    public function add_chat_comment($table_name, $item_id)
    {
        // Access Check
        $this->inside_lib->check_access('inside2_' . $table_name, 'edit');

        // Load Libs and Models
        $this->load->library('inside_lib');
        $this->load->model('inside_model');

        // User Info Array (Empty Hash is not bad, its session style)
        $user_info_arr = $this->inside_lib->get_user_info($this->session->userdata('user_id'));

        $comment = $this->input->post('comment');
        $datetime = date("Y-m-d H:i:s");

        $comment = $this->inside_lib->defend_filter(1, $comment);

        $table_name = $this->inside_lib->defend_filter(4, $table_name);
        $item_id = intval($item_id);

        $what_replace = array("\r\n", "\n", "\r");
        $replace = '<br />';
        $comment = str_replace($what_replace, $replace, $comment);

        $input['row_chat_table'] = $table_name;
        $input['row_chat_row_id'] = $item_id;
        $input['row_chat_user_name'] = $user_info_arr['users']['first_name'] . " " . $user_info_arr['users']['last_name'];
        $input['row_chat_user_id'] = intval($user_info_arr['users']['id']);
        $input['row_chat_content'] = $comment;
        $input['row_chat_datetime'] = $datetime;

        $this->db->insert('inside_row_chat', $input);

        ob_start();
        ?>
        <div style="padding: 10px; margin-top: 10px; border-top: 1px dotted #777;">
            <b><?php echo $user_info_arr['users']['first_name'] . " " . $user_info_arr['users']['last_name']; ?></b> <i
                    class="gray">[<?php echo $datetime; ?>]</i>: <?php echo $comment; ?>
        </div>
        <?php
        echo ob_get_clean();
        // ------------------------------------------------------------------------------------------------------

    }

// ------------------------------------------------------------------------------------------------------ACCESS SYSTEM EDIT
    private function access_system_edit($type, $table_name, $cell_id = '')
    {
        // Load Config
        include('application/config/pdg_tables/' . $table_name . '.php');
        if (isset($table_config['access_system']) AND !$this->ion_auth->is_admin()) {

            $current_user = $this->ion_auth->get_user_id();

            $user_in_work_group = $this->ion_auth->in_group($table_config['access_work_groups']);

            if (isset($table_config['access_creator_fields'])) {
                $creators_access_users = array();
                foreach ($table_config['access_creator_fields'] as $field_name) {
                    $creators_access_users_keys[] = $field_name;
                }

                $creators_access_users_key_string = implode(', ',$creators_access_users_keys);

                if($creators_access_users_key_string) {
                    if ($type === 'edit') {
                        $this->db->select($creators_access_users_key_string);
                        $creator_users_id = $this->db->get_where($table_name, array($table_config['key'] => $cell_id), 1)->row_array();

                        foreach ($creator_users_id as $id) {
                            if ($id != 0) {
                                $ids_array[] = $id;
                            }
                        }
                    } elseif($type === 'del') {
                        $this->db->select($creators_access_users_key_string.', '.$table_config['key']);
                        $this->db->where_in($table_config['key'], $_POST['del_ids']);
                        $creator_users_array = $this->db->get($table_name)->result_array();

                        //$ids_by_item = array();
                        foreach ($creator_users_array as $item) {
                            foreach ($item as $key => $value) {
                                if($key != $table_config['key'] AND $value != 0) {
                                    $ids_by_item[$item[$table_config['key']]][] = $value;
                                }
                            }
                        }
                    }
                }

            }

            if ($type === 'edit') {
                $this->db->select('ar_all_edit, ar_group_edit, ar_creator_edit, ar_user_id');
                $access_data = $this->db->get_where($table_name, array($table_config['key'] => $cell_id), 1)->row_array();

                /*if ($access_data['ar_user_id'] == $current_user) { // old code for all creators
                    return true;
                }*/
                if ($access_data['ar_all_edit'] == 1) {
                    return true;
                } elseif ($access_data['ar_group_edit'] == 1 AND $user_in_work_group) {
                    return true;
                } elseif ($access_data['ar_creator_edit'] == 1 AND ($access_data['ar_user_id'] == $current_user OR (isset($ids_array) AND in_array($current_user,$ids_array))) AND $user_in_work_group) { // made fix for creator (who in group)
                    return true;
                } else {
                    return false;
                }
            } elseif($type === 'del') {
                if (isset($_POST['del_ids'])) {

                    $this->db->select("{$table_config['key']}, ar_all_edit, ar_group_edit, ar_creator_edit, ar_user_id");
                    $this->db->where_in($table_config['key'], $_POST['del_ids']);
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
                        } elseif ($del_item['ar_creator_edit'] == 1 AND ($del_item['ar_user_id'] == $current_user OR (isset($ids_by_item[$del_item[$table_config['key']]]) AND in_array($current_user,$ids_by_item[$del_item[$table_config['key']]]))) AND $user_in_work_group) { // made fix for creator (who in group)
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

}