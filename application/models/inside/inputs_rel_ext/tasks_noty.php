<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tasks_noty {

    public function pre_db_save($input_array, $cell_id)
    {
       $CI =& get_instance();

       $CI->load->model('Mail_model');
       $CI->load->model('users');

       include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');

        $db_arr = $CI->db->query("SELECT * FROM {$input_array['base_table']} WHERE {$table_config['key']} = ?", array($cell_id))->row_array();


        if (isset($input_array['update']['tasks_user_id']) AND $_POST['status_id'] != 3) {

            $user_id = intval($input_array['update']['tasks_user_id']);

            if ($user_id > 0) {
                $user_row = $CI->users->get_user_full_row($user_id);
                $email = $user_row['email'];
            } else $email = 'yura.vashchenko@gmail.com';

            if ($user_id != $db_arr['tasks_user_id']) {
                $CI->Mail_model->simple_letter($email, 'Вам передана задача в TKN!', '<br/>Ссылка к списку задач: <a href="http://' . $_SERVER['SERVER_NAME'] . '/inside/table/m_tasks">перейти</a><br>ID задачи: <b>' . $cell_id . '</b><br>Название задачи: <b>' . $db_arr['tasks_name'] . '</b>');
            }
        }


        if (isset($input_array['update']['tasks_creator_id'])) {

            $user_id = intval($input_array['update']['tasks_creator_id']);

            if ($user_id > 0) {
                $user_row = $CI->users->get_user_full_row($user_id);
                $email = $user_row['email'];
            } else $email = 'yura.vashchenko@gmail.com';

            if ($_POST['status_id'] != $db_arr['tasks_status'] AND $_POST['status_id'] == 3 AND $input_array['update']['tasks_creator_id'] != $input_array['update']['tasks_user_id']) {

                $CI->Mail_model->simple_letter($email, 'Ваша задача в TKN - Выполнена!', '<br/>Выполнена задача!<br>Ссылка к списку задач: <a href="http://' . $_SERVER['SERVER_NAME'] . '/inside/table/m_tasks">перейти</a><br>ID задачи: <b>' . $cell_id . '</b><br>Название задачи: <b>' . $db_arr['tasks_name'] . '</b>');
            }
        }
    }

    public function db_add($input_array, $cell_id)
    {
        $CI =& get_instance();

        $CI->load->model('Mail_model');
        $CI->load->model('users');

        include('application/config/pdg_tables/' . $input_array['base_table'] . '.php');

        $db_arr = $CI->db->query("SELECT * FROM {$input_array['base_table']} WHERE {$table_config['key']} = ?", array($cell_id))->row_array();

        $user_id = intval($db_arr['tasks_user_id']);

        if ($user_id > 0) {
            $user_row = $CI->users->get_user_full_row($user_id);
            $email = $user_row['email'];
        } else $email = 'yura.vashchenko@gmail.com';

        $CI->Mail_model->simple_letter($email, 'Новая задача в TKN!','<br/>Ссылка к списку задач: <a href="http://'.$_SERVER['SERVER_NAME'].'/inside/table/m_tasks">перейти</a><br>ID задачи: <b>'.$cell_id.'</b><br>Название задачи: <b>'.$db_arr['tasks_name'].'</b>');
    }
}