<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

}

// ============================================= Website Base Controller ===============================================
class Controller_Base extends CI_Controller {

	public $__load_default = false;

	public $data = array();
	public $options = array();
	
	public function __construct() {
		
		parent::__construct();
		
		if($this->__load_default){
			$this->__load_default();

		}

	}
	
	public function __load_default() {


		$this->data['sitename'] = "Inside 3.1";
		$this->data['default_lang'] = "ru";

		// ---------------   Languages   ------------------------
		$this->load->model('lang_model');

		// Get Lang from URL
		$this->data['all_lang_arr'] = $this->lang_model->get_all_lang_arr();
		foreach ($this->data['all_lang_arr'] as $lang_row)
		{
			if ($lang_row['lang_alias'] == $this->uri->segment(1)) $this->options['lang'] = $lang_row['lang_alias'];
		}

		if (!isset($this->options['lang'])) $this->options['lang'] = $this->data['default_lang'];

		$this->data['global_lang_alias'] = $this->options['lang'];

		//Save Language in Session
		$this->session->set_userdata(Array('lang' => $this->options['lang']));


		if ($this->options['lang'] == "ru") $this->data['lang_link_prefix'] = "";
		else $this->data['lang_link_prefix'] = "/".$this->options['lang'];

		// Vocabulary
		$this->load->model('text_model', 'text');
		$this->text->init($this->options['lang']);


		// --------------------- Catalog ------------------

		/*
		// Default Data for every __load_default = true Controller
		$this->load->model('categories');

		$this->data['categories_arr'] = $this->categories->get_all_categories_arr();



		// --------------------- Web-Site Auth ------------------

		$this->load->model('menu');
		$menu_arr = $this->menu->get_menu_arr();
		$columns['id_column'] = 'menu_id';
		$columns['pid_column'] = 'menu_pid';
		$columns['name_column'] = 'menu_name';
		$columns['haschild_column'] = 'menu_haschild';
		$columns['invisible_column'] = 'menu_invisible';
		$columns['url_column'] = 'menu_url';
		$columns['url_prefix'] = '';
		$columns['data_prefix'] = '';

		$this->data['menu_tree'] = $this->inside_lib->make_tree_view($menu_arr, $columns, '', ' id="nav" class="dropdown dropdown-horizontal img_shadow"');
		*/

		$this->load->library('ion_auth');

		if ($this->ion_auth->logged_in())
		{
			$this->data['user'] = $this->ion_auth->user()->row();
		}
		else $this->data['user'] = false;


		// PROFILER
		if ($this->ion_auth->is_admin() && isset($_GET['ci_profiler'])) {
			$this->output->enable_profiler(TRUE);
		}

		if ($this->ion_auth->is_admin() && isset($_GET['php_info'])) {
			echo "<b>Files included</b><br/>";

			foreach (get_included_files() as $key => $value) {
				echo "[$key] $value\n<br/>";
			}

			echo "<br/><b>Interfaces</b><br/>";
			foreach (get_declared_interfaces() as $key => $value) {
				echo "[$key] $value\n<br/>";
			}

			echo "<br/><b>Classes (OOP)</b><br/>";
			foreach (get_declared_classes() as $key => $value) {
				echo "[$key] $value\n<br/>";
			}

			$f_all = get_defined_functions();

			echo "<br/><b>Project User Functions</b><br/>";

			foreach ($f_all['user'] as $key => $value) {
				echo "[$key] $value\n<br/>";
			}

			echo "<br/><b>PHP Internal Functions</b><br/>";

			foreach ($f_all['internal'] as $key => $value) {
				echo "[$key] $value\n<br/>";
			}

			echo "<br/><b>PHP Defined Constants</b><br/>";
			$i = 1;
			foreach (get_defined_constants() as $key => $value) {
				echo "[$i] $key = $value\n<br/>";
				$i++;
			}

			unset($f_all);
			unset($key);
			unset($value);
			unset($i);
			print_r(get_defined_vars());

		}

		$this->data['page_center'] = 'index';
		
		
		
	}


	public function __render($layout = 'outside/main_template') {

		// Default in every Page, where use RENDER not AJAX	
		
		$this->load->view($layout, $this->data);
		
	}
	

}

// =============================================== Admin Base Controller ===============================================
class Controller_Admin extends CI_Controller {

	public $__load_default = true;

	public $data = array();
	public $options = array();

	public function __construct() {

		parent::__construct();

		if($this->__load_default){
			$this->__load_default();

		}

	}

	public function __load_default() {


		$this->data['sitename'] = "Inside";
		$this->data['default_lang'] = "ru";

		// ---------------   Languages   ------------------------
		$this->load->model('lang_model');

		// Get Lang from URL
		$this->data['all_lang_arr'] = $this->lang_model->get_all_lang_arr();
		foreach ($this->data['all_lang_arr'] as $lang_row)
		{
			if ($lang_row['lang_alias'] == $this->uri->segment(1)) $this->options['lang'] = $lang_row['lang_alias'];
		}

		if (!isset($this->options['lang'])) $this->options['lang'] = $this->data['default_lang'];

		$this->data['global_lang_alias'] = $this->options['lang'];

		//Save Language in Session
		$this->session->set_userdata(Array('lang' => $this->options['lang']));


		if ($this->options['lang'] == "ru") $this->data['lang_link_prefix'] = "";
		else $this->data['lang_link_prefix'] = "/".$this->options['lang'];

		// Vocabulary
		$this->load->model('text_model', 'text');
		$this->text->init($this->options['lang']);

		$this->load->library('ion_auth');

		if ($this->ion_auth->logged_in())
		{
			$this->data['user'] = $this->ion_auth->user()->row();
			$this->load->model('inside/menu/inside_menu');
			$this->data['menu_arr'] = $this->inside_menu->get_top_menu_arr();
			$this->data['top_menu'] = $this->load->view('admin/pages/inside/inside_menu', $this->data, TRUE);
		}
		else {
			$this->data['user'] = false;
			die();
		}


		// PROFILER
		if ($this->ion_auth->is_admin() && isset($_GET['ci_profiler'])) {
			$this->output->enable_profiler(TRUE);
		}

		$this->data['page_center'] = 'index';

	}


	public function __render($layout = 'admin/admin_template') {

		if (!isset($this->data['interface_name'])) {
			$this->data['interface_name'] = 'Inside 3.1';
			if (isset($this->data['table_name'])) $this->data['interface_name'] = $this->data['table_name'];
		}


		// Default in every Page, where use RENDER not AJAX
		$this->load->view($layout, $this->data);

	}


}
