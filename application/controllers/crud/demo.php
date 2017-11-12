<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Demo extends Controller_Admin
{

    public $__load_default = true;
    var $user; // User Array

    function __construct() {

        // $this->data['project_view_folder'] = 'custom';

        parent::__construct();

        if ( ! $this->ion_auth->is_admin()) exit();

        $this->load->model('demo_model', 'model');
        $this->user = $this->data['user'];
        $this->data['controller_name'] = 'crud/demo';

        $this->inside_lib->check_access('crud_demo','init');
    }

    public function index()
    {

        $this->inside_lib->check_access('crud_demo','view');

        // Defaults ?? Maybe switch to Model ???
        if (isset($_GET['page']) AND $_GET['page'] == 1)
            $this->redirect($this->data['controller_name']);
        if ( ! isset($_GET['page'])) $_GET['page'] = 1;
        $_GET['per_page'] = 20;
        // ======================================
        $this->data['page_center'] = 'crud/interface';
        $this->data['seo_title'] = 'CRUD';
        $this->data['seo_description'] = 'CRUD';
        $this->data['seo_keywords'] = 'CRUD';
        $this->__render();

    }

    public function table() {

        $this->inside_lib->check_access('crud_demo','view');

        $this->data['table_id_column'] = $this->model->table_id_column;
        $this->data['table_columns_arr'] = $this->model->table_columns_arr;

        $this->data['crud_data_arr'] = $this->model->get_main();


        $this->load->view('admin/pages/crud/table',$this->data);

    }

    public function addform() {

        $this->inside_lib->check_access('crud_demo','edit');

        $this->data['page_center'] = 'crud/add_form';

        $this->data['seo_title'] = 'CRUDGEN2 AddForm Demo';
        $this->data['seo_description'] = '';
        $this->data['seo_keywords'] = '';

        $this->__render();

    }


    public function editform($id) {

        $this->inside_lib->check_access('crud_demo','view');

        $this->load->model('pages');
        $this->data['row'] = $this->pages->get_page_row($id);

        $this->data['page_center'] = 'crud/edit_form';

        $this->data['seo_title'] = 'CRUDGEN2 EditForm #'.$id;
        $this->data['seo_description'] = '';
        $this->data['seo_keywords'] = '';

        $this->__render();

    }

}