<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Temp extends Controller_Base {

    public $__load_default = true;

    public function mail_tmp() {

        $this->data['title'] = 'Mail TMP';
        $this->data['content'] = '';
        $this->load->view('/mail/mail_tmp1.php', $this->data);

        $this->load->model('mail_model');
        // $this->mail_model->info_letter('cd99@mail.ru, torrison1@gmail.com', $this->data['content']);

    }

    public function mail_test() {


        $this->load->model('mail_model');

        // $this->mail_model->registration_letter('cd99@mail.ru','Alex','Torrison','asdfgh');

        $this->data['content'] = "Mail sent";
        $this->data['page_center'] = 'tmp/empty';

        $this->data['seo_title'] = 'Mail Test';
        $this->data['seo_description'] = 'Mail Test';
        $this->data['seo_keywords'] = 'Mail Test';

        $this->__render();
    }

    public function all_classes() {

        foreach(get_declared_classes() as $row) {
            if ($row == 'ImagickPixel') {
                $write = true;
                $i=0;
            }
            if (isset($write)) {
                echo "[".$i."]";
                print_r($row);
                echo "<br />";
                $i++;
            }

        };
    }


}
	