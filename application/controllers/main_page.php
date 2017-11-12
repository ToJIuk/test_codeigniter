<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_Page extends Controller_Base {
	
	public $__load_default = true;
	
	public function index() {

		$this->data['seo_title'] = $this->data['sitename'].' Main Page';
		$this->data['seo_description'] = $this->data['sitename'].' for business';
		$this->data['seo_keywords'] = '';

		$this->__render();
	}

}