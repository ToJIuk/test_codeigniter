<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Controller_Admin
{

    public function index()
    {

        $this->data['page_center'] = 'dashboard';
        // echo "DashBoard";

        $this->__render();

    }
}