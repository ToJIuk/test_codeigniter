<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Not USED in OnSite Project Manual Version !

class Ajax_api extends Controller_Base {
	
	public $__load_default = true;


	public function add_request() {
		
		$insert_data['requests_user_name'] = mysql_real_escape_string($this->input->post('name'));
		$insert_data['requests_user_phone'] = mysql_real_escape_string($this->input->post('phone'));
		$insert_data['requests_user_email'] = mysql_real_escape_string($this->input->post('email'));
		$insert_data['requests_message'] = mysql_real_escape_string($this->input->post('info'));
		$insert_data['requests_type'] = 1;
		$insert_data['requests_result'] = 1;
		$insert_data['requests_url'] = mysql_real_escape_string($this->input->post('url'));;
		
		
		$insert_data['requests_datetime'] = time();
		$insert_data['requests_user_id'] = intval($this->input->post('user_id'));
		
		$this->db->insert('it_requests', $insert_data);
		
		$res['status'] = 'success';
		
		mail(
			'cd99@mail.ru', 
			'Новая заявка',
			"
			<b>Name:</b> ".$insert_data['requests_user_name']."<br /><br />
			<b>Email:</b> ".$insert_data['requests_user_email']."<br /><br />
			<b>Phone:</b> ".$insert_data['requests_user_phone']."<br /><br />
			<b>Info:</b> ".$insert_data['requests_message']."<br /><br />
			<b>Time:</b> ".date("Y-m-d H:i:s").
			'<br /><br /><b>Link: </b><a href="http://w.ikiev.biz/inside/table/it_requests">Requests Table</a>',
			'Content-type: text/html; charset=utf-8'
			);
		
		echo json_encode($res);
	}

	public function test_request() {

		$this->load->model('mail_model');

		$user_id = 0;
		if (isset($this->data['user']->id)) $user_id = $this->data['user']->id;

		$this->mail_model->simple_letter('cd99@mail.ru', 'New request', 'User #'.$user_id." want PRO account in Wisdom.ikiev.biz!");

		echo "ok";
	}

}