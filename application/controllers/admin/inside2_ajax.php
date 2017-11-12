<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inside2_ajax extends Controller_Admin
{

    //======================== REALTY EMAILING FUNCTIONS STARTS
    public function get_emailing_statistics()
    {
        // кол-во одиночных рассылок
        $this->db->where('type', 'realty_emailing_filters');
        $this->db->or_where('type', 'realty_emailing_clients');
        $this->db->from('tkn_mailer_requests');
        $single_mails = $this->db->count_all_results(); // Produces an integer, like 17
        // кол-во объектов в одиночных рассылках
        $single_objects_qty = $single_mails;
        // кол-во массовых рассылок
        $this->db->where('type', 'mass_realty_emailing_filters');
        $this->db->or_where('type', 'mass_realty_emailing_clients');
        $this->db->from('tkn_mailer_requests');
        $mass_mails = $this->db->count_all_results(); // Produces an integer, like 17
        // кол-во объектов в массовых рассылках
        $this->db->select_sum('objects_qty');
        $this->db->where('type', 'mass_realty_emailing_filters');
        $this->db->or_where('type', 'mass_realty_emailing_clients');
        $mass_objects_qty = $this->db->get('tkn_mailer_requests')->row_array()['objects_qty'];
        if(!$mass_objects_qty) $mass_objects_qty = 0;
        // кол-во открывших email
        $this->db->where('activity_type_id', 8);
        $this->db->from('activities');
        $opened_emails = $this->db->count_all_results(); // Produces an integer, like 17
        // кол-во перешедших на объект
        $this->db->where('activity_type_id', 9);
        $this->db->from('activities');
        $went_to_object = $this->db->count_all_results(); // Produces an integer, like 17
        // кол-во перешедших списко вариантов (массовая рассылка)
        $this->db->where('activity_type_id', 10);
        $this->db->from('activities');
        $went_to_variants = $this->db->count_all_results(); // Produces an integer, like 17
        // html
        $html = '<div class="table-responsive emailing_statistics" style="margin-top: 5px;"><table class="table table-bordered"><tr><th><u>Одиночные</u></th><th><u>Массовые</u></th></tr>';
        $html .= '<tr><td colspan="2"><i>Кол-во рассылок</i></td></tr>';
        $html .= "<tr><td>{$single_mails}</td><td>{$mass_mails}</td></tr>";
        $html .= '<tr><td colspan="2"><i>Разослано объектов</i></td></tr>';
        $html .= "<tr><td>{$single_objects_qty}</td><td>{$mass_objects_qty}</td></tr>";
        $html .= '<tr><td colspan="2"><b><u>Общее</u></b></td></tr>';
        $html .= '<tr><td colspan="2"><i>Открыли email</i></td></tr>';
        $html .= "<tr><td colspan='2'>{$opened_emails}</td></tr>";
        $html .= '<tr><td colspan="2"><i>Перешли на объект</i></td></tr>';
        $html .= "<tr><td colspan='2'>{$went_to_object}</td></tr>";
        $html .= '<tr><td colspan="2"><i>Перешли к списку вариантов</i></td></tr>';
        $html .= "<tr><td colspan='2'>{$went_to_variants}</td></tr>";
        $html .= '</table></div>';

        echo $html;

    }

    public function mass_realty_emailing_select_data()
    {
        //$this->inside_lib->check_access('inside2_obj_type', 'view');
        $this->db->select('id, name');
        $this->db->order_by('name', 'ASC');
        $res = $this->db->get('obj_type')->result_array();
        echo json_encode($res);
    }

    public function mass_realty_emailing_get_users()
    {
        $this->inside_lib->check_access('inside2_users', 'view');
        $this->db->select('id, fio, email, company');
        $this->db->where_in('estate_type', [1, 2]);
        $this->db->where('email !=', '');
        $this->db->order_by('fio', 'ASC');
        $res = $this->db->get('users')->result_array();
        echo json_encode($res);
    }

    public function mail_opened()
    {
        $this->inside_lib->check_access('inside2_activities', 'edit');

        if (isset($_GET['u'], $_GET['mr'], $_GET['c'], $_GET['mi'])) {

            $hash = 'sdf3fuguhkjaf';
            $user_id = intval($_GET['u']);
            $mail_id = intval($_GET['mr']);
            $mailer_id = intval($_GET['mi']);
            $code_string = sha1($user_id . $hash . $mail_id . $hash . $user_id);
            $code = crypt($code_string, $hash);

            if ($_GET['c'] === $code) {
                // create activity
                $activities_open_object = array(
                    'activity_type_id' => 8,
                    'activity_table' => 'users',
                    'activity_element_id' => $user_id,
                    'activity_user' => $mailer_id,
                    'activity_text' => "Открыл email по рассылке #{$mail_id}",
                    'activity_time' => date("Y-m-d H:i:s"),
                );
                $this->db->insert('activities', $activities_open_object);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function mass_realty_emailing_filters()
    {
        $this->inside_lib->check_access('inside2_realty_base', 'view');
        $this->inside_lib->check_access('inside2_users', 'view');
        $this->inside_lib->check_access('inside2_activities', 'edit');
        $this->inside_lib->check_access('inside2_tkn_mailer_requests', 'edit');

        // currency
        $currency_alias = $_POST['currency'];
        $this->load->model('Inside_model');
        $currency_array = $this->Inside_model->get_currency_by_alias($currency_alias);

        // other data
        $cell_ids = $_POST['cell_ids'];
        $data_post = $_POST['data'];
        $mailer_id = $this->ion_auth->user()->row()->id;
        $objects_qty = count(explode(', ', $cell_ids));

        // getting sender data
        $this->db->select('fio, phone,  email');
        $this->db->where('id', $mailer_id);
        $sender_data = $this->db->get('users')->row_array();

        if (is_array($data_post) AND count($data_post) > 0 AND $cell_ids != '') {
            //get object s data
            $this->db->select('realty_base.id, realty_base.address, realty_base.price_m2, realty_base.price, realty_base.price_rent, realty_base.square, realty_base.main_img, realty_base.offer_type, cities.name');
            $ids = explode(', ', $cell_ids);
            // escaping data
            foreach ($ids as &$object_id) $object_id = intval($object_id);
            unset ($object_id);
            $this->db->from('realty_base');
            $this->db->join('cities', 'cities.id = realty_base.city_id', 'left');
            $this->db->where_in('realty_base.id', $ids);
            $objects = $this->db->get()->result_array();

            //tkn_mailer_requests
            $data_mailer = array(
                'time' => date("Y-m-d H:i:s"),
                'user_id' => $mailer_id,
                'type' => 'mass_realty_emailing_filters',
                'json_objects' => $this->db->escape_str($cell_ids),
                'json_filters' => json_encode($_POST['params']),
                'objects_qty' => $objects_qty,
            );
            $this->db->insert('tkn_mailer_requests', $data_mailer);
            $mail_id = $this->db->insert_id();

            // recipient array
            $recipient_data = array();

            // mail model
            $this->load->model('Mail_model');

            // form data and sent emails
            foreach ($data_post as $user_data) {

                //======crypt starts
                $hash = 'sdf3fuguhkjaf';
                $code_string = sha1($user_data['id'] . $hash . $mail_id . $hash . $user_data['id']);
                $code = crypt($code_string, $hash);
                //======crypt ends

                $ids_for_list = '';

                foreach ($objects as &$object) {
                    $object['link'] = "http://tkn.kiev.ua/show/object/" . $object['id'] . "/?ms=email_link&u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&oi=" . $object['id'] . "&mi=" . $mailer_id;
                    // making ids string for list page
                    $ids_for_list .= $object['id'] . '_';
                }
                unset($object);

                // trim undescope in the end
                $ids_for_list = trim($ids_for_list, '_');
                $template_data = array(
                    'ids_string' => "http://tkn.kiev.ua/find/objects/?ms=email_link&u={$user_data['id']}&mr={$mail_id}&c={$code}&mi={$mailer_id}&emailing_list={$ids_for_list}",
                    'hidden_image' => "<img style='display:none' src='http://tkn.kiev.ua/admin/inside2_ajax/mail_opened?u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&mi=" . $mailer_id . "'>",
                    'objects' => $objects,
                    'sender' => $sender_data,
                    'currency' => $currency_array,
                );

                // sending mail
                $this->Mail_model->realty_mailing($template_data, $user_data['email']);

                // recipient data
                $recipient_data[] = array(
                    'activity_type_id' => 12,
                    'activity_table' => 'users',
                    'activity_element_id' => $user_data['id'],
                    'activity_user' => $mailer_id,
                    //'activity_text' => "Получил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                    'activity_text' => "Получил рассылку #{$mail_id}",
                    'activity_time' => date("Y-m-d H:i:s"),
                );
            }

            //activities sender
            $data_activities_sender = array(
                'activity_type_id' => 11,
                'activity_table' => 'users',
                'activity_element_id' => $mailer_id,
                'activity_user' => $mailer_id,
                //'activity_text' => "Выполнил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                'activity_text' => "Выполнил рассылку #{$mail_id}",
                'activity_time' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('activities', $data_activities_sender);

            //activities recipient
            $this->db->insert_batch('activities', $recipient_data);

        }
    }

    public function mass_realty_emailing_clients()
    {

        $this->inside_lib->check_access('inside2_realty_base', 'view');
        $this->inside_lib->check_access('inside2_users', 'view');
        $this->inside_lib->check_access('inside2_activities', 'edit');
        $this->inside_lib->check_access('inside2_tkn_mailer_requests', 'edit');

        // currency
        $currency_alias = $_POST['currency'];
        $this->load->model('Inside_model');
        $currency_array = $this->Inside_model->get_currency_by_alias($currency_alias);

        // other data
        $cell_ids = $_POST['cell_ids'];
        $users_ids = $_POST['users_ids'];
        $mailer_id = $this->ion_auth->user()->row()->id;
        $objects_qty = count(explode(', ', $cell_ids));

        // getting sender data
        $this->db->select('fio, phone,  email');
        $this->db->where('id', $mailer_id);
        $sender_data = $this->db->get('users')->row_array();

        if (is_array($users_ids) AND count($users_ids) > 0 AND $cell_ids != '') {
            //get object s data
            $this->db->select('realty_base.id, realty_base.address, realty_base.price_m2, realty_base.price, realty_base.price_rent, realty_base.square, realty_base.main_img, realty_base.offer_type, cities.name');
            $ids = explode(', ', $cell_ids);
            // escaping data
            foreach ($ids as &$object_id) $object_id = intval($object_id);
            unset ($object_id);
            $this->db->from('realty_base');
            $this->db->join('cities', 'cities.id = realty_base.city_id', 'left');
            $this->db->where_in('realty_base.id', $ids);
            $objects = $this->db->get()->result_array();

            //tkn_mailer_requests
            $data_mailer = array(
                'time' => date("Y-m-d H:i:s"),
                'user_id' => $mailer_id,
                'type' => 'mass_realty_emailing_clients',
                'json_objects' => $this->db->escape_str($cell_ids),
                'objects_qty' => $objects_qty,
            );
            $this->db->insert('tkn_mailer_requests', $data_mailer);
            $mail_id = $this->db->insert_id();

            // recipient array
            $recipient_data = array();

            // mail model
            $this->load->model('Mail_model');

            // escaping data
            foreach ($users_ids as &$user_id) $user_id = intval($user_id);
            unset ($user_id);
            // get users info
            $this->db->select('id, email');
            $this->db->where_in('id', $users_ids);
            $users_data = $this->db->get('users')->result_array();

            // form data and sent emails
            foreach ($users_data as $user_data) {

                //======crypt starts
                $hash = 'sdf3fuguhkjaf';
                $code_string = sha1($user_data['id'] . $hash . $mail_id . $hash . $user_data['id']);
                $code = crypt($code_string, $hash);
                //======crypt ends

                $ids_for_list = '';

                foreach ($objects as &$object) {
                    $object['link'] = "http://tkn.kiev.ua/show/object/" . $object['id'] . "/?ms=email_link&u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&oi=" . $object['id'] . "&mi=" . $mailer_id;
                    // making ids string for list page
                    $ids_for_list .= $object['id'] . '_';
                }
                unset($object);

                // trim undescope in the end
                $ids_for_list = trim($ids_for_list, '_');
                $template_data = array(
                    'ids_string' => "http://tkn.kiev.ua/find/objects/?ms=email_link&u={$user_data['id']}&mr={$mail_id}&c={$code}&mi={$mailer_id}&emailing_list={$ids_for_list}",
                    'hidden_image' => "<img style='display:none' src='http://tkn.kiev.ua/admin/inside2_ajax/mail_opened?u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&mi=" . $mailer_id . "'>",
                    'objects' => $objects,
                    'sender' => $sender_data,
                    'currency' => $currency_array,
                );

                // sending mail
                $this->Mail_model->realty_mailing($template_data, $user_data['email']);

                // recipient data
                $recipient_data[] = array(
                    'activity_type_id' => 12,
                    'activity_table' => 'users',
                    'activity_element_id' => $user_data['id'],
                    'activity_user' => $mailer_id,
                    //'activity_text' => "Получил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                    'activity_text' => "Получил рассылку #{$mail_id}",
                    'activity_time' => date("Y-m-d H:i:s"),
                );
            }

            //activities sender
            $data_activities_sender = array(
                'activity_type_id' => 11,
                'activity_table' => 'users',
                'activity_element_id' => $mailer_id,
                'activity_user' => $mailer_id,
                //'activity_text' => "Выполнил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                'activity_text' => "Выполнил рассылку #{$mail_id}",
                'activity_time' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('activities', $data_activities_sender);

            //activities recipient
            $this->db->insert_batch('activities', $recipient_data);

        }
    }

    public function realty_emailing_clients()
    {
        $this->inside_lib->check_access('inside2_realty_base', 'view');
        $this->inside_lib->check_access('inside2_users', 'view');
        $this->inside_lib->check_access('inside2_activities', 'edit');
        $this->inside_lib->check_access('inside2_tkn_mailer_requests', 'edit');

        // currency
        $currency_alias = $_POST['currency'];
        $this->load->model('Inside_model');
        $currency_array = $this->Inside_model->get_currency_by_alias($currency_alias);

        // other data
        $cell_id = intval($_POST['cell_id']);
        $users_ids = $_POST['users_ids'];
        $mailer_id = $this->ion_auth->user()->row()->id;

        // getting sender data
        $this->db->select('fio, phone,  email');
        $this->db->where('id', $mailer_id);
        $sender_data = $this->db->get('users')->row_array();

        if (is_array($users_ids) AND count($users_ids) > 0 AND $cell_id != 0) {

            //get object s data
            $this->db->select('realty_base.id, realty_base.address, realty_base.price_m2, realty_base.price, realty_base.price_rent, realty_base.square, realty_base.main_img, realty_base.offer_type, cities.name');
            $this->db->from('realty_base');
            $this->db->join('cities', 'cities.id = realty_base.city_id', 'left');
            $this->db->where('realty_base.id', $cell_id);
            $object = $this->db->get()->row_array();

            // escaping users ids
            foreach ($users_ids as &$user_id) $user_id = intval($user_id);
            unset($user_id);

            // get users data
            $this->db->select('id, email');
            $this->db->where_in('id', $users_ids);
            $users_data = $this->db->get('users')->result_array();

            //tkn_mailer_requests
            $data_mailer = array(
                'time' => date("Y-m-d H:i:s"),
                'user_id' => $mailer_id,
                'type' => 'realty_emailing_clients',
                'json_objects' => $cell_id,
            );
            $this->db->insert('tkn_mailer_requests', $data_mailer);
            $mail_id = $this->db->insert_id();

            // recipient array
            $recipient_data = array();

            // mail model
            $this->load->model('Mail_model');

            // form data and send emails
            foreach ($users_data as $user_data) {

                //======crypt starts
                $hash = 'sdf3fuguhkjaf';
                $code_string = sha1($user_data['id'] . $hash . $mail_id . $hash . $user_data['id']);
                $code = crypt($code_string, $hash);
                //======crypt ends

                // making link for template
                $object['link'] = "http://tkn.kiev.ua/show/object/" . $object['id'] . "/?ms=email_link&u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&oi=" . $object['id'] . "&mi=" . $mailer_id;

                $template_data = array(
                    'hidden_image' => "<img style='display:none' src='http://tkn.kiev.ua/admin/inside2_ajax/mail_opened?u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&mi=" . $mailer_id . "'>",
                    'objects' => array($object),
                    'sender' => $sender_data,
                    'currency' => $currency_array,
                );


                // sending mail
                $this->Mail_model->realty_mailing($template_data, $user_data['email']);

                // recipient data
                $recipient_data[] = array(
                    'activity_type_id' => 12,
                    'activity_table' => 'users',
                    'activity_element_id' => $user_data['id'],
                    'activity_user' => $mailer_id,
                    //'activity_text' => "Получил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                    'activity_text' => "Получил рассылку #{$mail_id}",
                    'activity_time' => date("Y-m-d H:i:s"),
                );
            }

            //activities sender
            $data_activities_sender = array(
                'activity_type_id' => 11,
                'activity_table' => 'users',
                'activity_element_id' => $mailer_id,
                'activity_user' => $mailer_id,
                //'activity_text' => "Выполнил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                'activity_text' => "Выполнил рассылку #{$mail_id}",
                'activity_time' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('activities', $data_activities_sender);

            //activities recipient
            $this->db->insert_batch('activities', $recipient_data);

        }
    }

    public function realty_emailing_filters()
    {
        $this->inside_lib->check_access('inside2_realty_base', 'view');
        $this->inside_lib->check_access('inside2_users', 'view');
        $this->inside_lib->check_access('inside2_activities', 'edit');
        $this->inside_lib->check_access('inside2_tkn_mailer_requests', 'edit');

        // currency
        $currency_alias = $_POST['currency'];
        $this->load->model('Inside_model');
        $currency_array = $this->Inside_model->get_currency_by_alias($currency_alias);

        // other data
        $cell_id = intval($_POST['cell_id']);
        $users_data = $_POST['data'];
        $mailer_id = $this->ion_auth->user()->row()->id;

        // getting sender data
        $this->db->select('fio, phone,  email');
        $this->db->where('id', $mailer_id);
        $sender_data = $this->db->get('users')->row_array();

        if (is_array($users_data) AND count($users_data) > 0 AND $cell_id != 0) {

            //get object s data
            $this->db->select('realty_base.id, realty_base.address, realty_base.price_m2, realty_base.price, realty_base.price_rent, realty_base.square, realty_base.main_img, realty_base.offer_type, cities.name');
            $this->db->from('realty_base');
            $this->db->join('cities', 'cities.id = realty_base.city_id', 'left');
            $this->db->where('realty_base.id', $cell_id);
            $object = $this->db->get()->row_array();

            //tkn_mailer_requests
            $data_mailer = array(
                'time' => date("Y-m-d H:i:s"),
                'user_id' => $mailer_id,
                'type' => 'realty_emailing_filters',
                'json_objects' => $cell_id,
                'json_filters' => json_encode($_POST['params']),
            );
            $this->db->insert('tkn_mailer_requests', $data_mailer);
            $mail_id = $this->db->insert_id();

            // recipient array
            $recipient_data = array();

            // mail model
            $this->load->model('Mail_model');

            // form data and sent emails
            foreach ($users_data as $user_data) {

                //======crypt starts
                $hash = 'sdf3fuguhkjaf';
                $code_string = sha1($user_data['id'] . $hash . $mail_id . $hash . $user_data['id']);
                $code = crypt($code_string, $hash);
                //======crypt ends

                // making link for template
                $object['link'] = "http://tkn.kiev.ua/show/object/" . $object['id'] . "/?ms=email_link&u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&oi=" . $object['id'] . "&mi=" . $mailer_id;

                $template_data = array(
                    'hidden_image' => "<img style='display:none' src='http://tkn.kiev.ua/admin/inside2_ajax/mail_opened?u=" . $user_data['id'] . "&mr=" . $mail_id . "&c=" . $code . "&mi=" . $mailer_id . "'>",
                    'objects' => array($object),
                    'sender' => $sender_data,
                    'currency' => $currency_array,
                );

                // sending mail
                $this->Mail_model->realty_mailing($template_data, $user_data['email']);

                // recipient data
                $recipient_data[] = array(
                    'activity_type_id' => 12,
                    'activity_table' => 'users',
                    'activity_element_id' => intval($user_data['id']),
                    'activity_user' => $mailer_id,
                    //'activity_text' => "Получил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                    'activity_text' => "Получил рассылку #{$mail_id}",
                    'activity_time' => date("Y-m-d H:i:s"),
                );
            }

            //activities sender
            $data_activities_sender = array(
                'activity_type_id' => 11,
                'activity_table' => 'users',
                'activity_element_id' => $mailer_id,
                'activity_user' => $mailer_id,
                //'activity_text' => "Выполнил рассылку по объекту #{$cell_id} [{$object['address']}], рассылка #{$mail_id}",
                'activity_text' => "Выполнил рассылку #{$mail_id}",
                'activity_time' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('activities', $data_activities_sender);

            //activities recipient
            $this->db->insert_batch('activities', $recipient_data);

        }
    }

    public function realty_emailing_table()
    {
        $this->inside_lib->check_access('inside2_realty_orders', 'view');
        $this->inside_lib->check_access('inside2_users', 'view');
        //$this->inside_lib->check_access('inside2_rel_orders_users', 'view');

        //types
        $types = isset($_POST['type']) ? $_POST['type'] : array();
        $escaped_types = array();
        $types_string = '';
        if (count($types) > 0) {
            foreach ($types as $type) {
                $escaped_types[] = intval($type);
            }
        }
        if ($escaped_types) $types_string = implode(', ', $escaped_types);

        $budget_from = intval($_POST['price_from']);
        $budget_to = intval($_POST['price_to']);
        $m_from = intval($_POST['m_from']);
        $m_to = intval($_POST['m_to']);
        $partners = '';
        if ($_POST['partners'] == 'checked') $partners = 'ok';

        $budget_from_where = '';
        if ($budget_from != 0) $budget_from_where = " AND realty_orders.adv_budget_from >= {$budget_from} ";
        $budget_to_where = '';
        if ($budget_to != 0) $budget_to_where = " AND realty_orders.adv_budget_to <= {$budget_to} ";
        $m_from_where = '';
        if ($m_from != 0) $m_from_where = " AND realty_orders.adv_square_from >= {$m_from} ";
        $m_to_where = '';
        if ($m_to != 0) $m_to_where = " AND realty_orders.adv_square_to <= {$m_to} ";
        $type_where = '';
        if (count($escaped_types) >= 2) $type_where = " realty_orders.adv_obj_type_id IN ({$types_string}) ";
        elseif (count($escaped_types) == 1) $type_where = " realty_orders.adv_obj_type_id = {$types_string}";
        else $type_where = " 1";

        $partners_where = ' AND users.estate_type = 1';
        if ($partners === 'ok') $partners_where = ' AND users.estate_type IN (1,2) ';

        $where = " WHERE {$type_where} {$partners_where} 
                        {$budget_from_where} {$budget_to_where} {$m_from_where} {$m_to_where} 
                         AND users.email != ''
                         GROUP BY users.email";

        $sql = "SELECT users.id, users.fio, users.email, users.company FROM rel_orders_users
                    LEFT JOIN realty_orders ON realty_orders.id = rel_orders_users.order_id
                    LEFT JOIN users ON users.id = rel_orders_users.user_id
                    {$where}
                    ORDER BY users.fio";

        $res = $this->db->query($sql)->result_array();
        if ($res) {
            echo json_encode($res);
        } else {
            echo '';
        }

    }

    //======================== REALTY EMAILING FUNCTIONS ENDS

    public function many2many_table($table_name = '', $adv_input_name = '')
    {
        // Include Config
        // Get Many2Many Array
        // custom sql
        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($adv_rel_inputs as $row) {
            if ($row['name'] == $adv_input_name) {
                $config_array = $row;
                break;
            }
        }

        $this->inside_lib->check_access('inside2_' . $config_array['table'], 'view');
        $res = $this->inside_lib->autocomplete_specified_table($config_array['table'], $config_array['join_key'], $config_array['join_name'], $config_array['adv_field'], $config_array['adv_field_2'], $config_array['adv_field_unix'], 5);

        if (isset($res[0]) AND $_GET['q'] != '') {
            echo json_encode($res);
        }
    }

    public function many2many_specified($table_name = '', $adv_input_name = '')
    {
        // Include Config
        // Get Many2Many Array
        // custom sql
        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($adv_rel_inputs as $row) {
            if ($row['name'] == $adv_input_name) {
                $config_array = $row;
                break;
            }
        }


        $this->inside_lib->check_access('inside2_' . $config_array['table'], 'view');
        $res = $this->inside_lib->autocomplete_specified_search($config_array['table'], $config_array['join_key'], $config_array['join_name'], $config_array['join_table'], $config_array['join_table_field'], $config_array['join_table_key'], $config_array['join_key_for_join_table'], $config_array['adv_field'], $config_array['adv_field_unix'], 5);

        if (isset($res[0]) AND $_GET['q'] != '') {
            echo json_encode($res);
        }
    }

    public function doubles_check_autocomplete($table_name = '', $adv_input_name = '')
    {
        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($table_columns as $row) {
            if ($row['name'] == $adv_input_name) {
                $config_array = $row;
                break;
            }
        }

        $this->inside_lib->check_access('inside2_' . $config_array['select_table'], 'view');
        $res = $this->inside_lib->autocomplete_search($config_array['select_table'], $config_array['select_index'], $config_array['select_field'], false, 5);
        if (isset($res[0]) AND $_GET['q'] != '') {
            echo json_encode($res);
        }
    }

    // AJAX Select 1.0
    public function rel_search_type($table_name = '', $adv_input_name = '')
    {

        // if(empty($table_name) OR empty($rel_table_name)) die();
        // Include Config
        // Get Many2Many Array
        // custom sql

        if (!file_exists('application/config/pdg_tables/' . $table_name . '.php')) {
            show_404();
            die();
        };

        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($adv_rel_inputs as $row) {
            if ($row['name'] == $adv_input_name) {
                $config_array = $row;
                break;
            }
        }

        $custom_sql = false;
        if (isset($config_array['custom_sql'])) $custom_sql = $config_array['custom_sql'];

        $this->inside_lib->check_access('inside2_' . $config_array['table'], 'view');
        $res = $this->inside_lib->autocomplete_search($config_array['table'], $config_array['join_key'], $config_array['join_name'], $custom_sql);
        if (isset($res[0]) AND $_GET['q'] != '') {
            echo json_encode($res);
        }
    }

    /*public function get_join_select_options($table_name = '', $rel_table_name = '')
    {
        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($adv_rel_inputs as $row) {
            if ($row['name'] == $rel_table_name) {
                $config_array = $row;
                break;
            }
        }
        $options = '';
        foreach ($config_array['join_select_variants'] as $option) {
            $options .= '<option>' . $option['name'] . '</option>';
        }

        echo $options;
    }*/

    public function autocomplete_search($table_name = '', $adv_input_name = '')
    {
        include('application/config/pdg_tables/' . $table_name . '.php');
        $config_array = array();
        foreach ($table_columns as $row) {
            if ($row['name'] == $adv_input_name) {
                $config_array = $row;
                break;
            }
        }

        $custom_sql = false;
        if (isset($config_array['custom_sql'])) $custom_sql = $config_array['custom_sql'];

        $this->inside_lib->check_access('inside2_' . $config_array['select_table'], 'view');
        $res = $this->inside_lib->autocomplete_search($config_array['select_table'], $config_array['select_index'], $config_array['select_field'], $custom_sql);
        if (isset($res[0]) AND $_GET['q'] != '') {
            echo json_encode($res);
        }
    }

    public function get_statuses_by_type($table = '', $input_name = '', $type = '', $selected_status = null)
    {

        $this->inside_lib->check_access('inside2_' . $table, 'view');

        if (!file_exists('application/config/pdg_tables/' . $table . '.php')) {
            show_404();
            die();
        };

        include('application/config/pdg_tables/' . $table . '.php');

        $statuses = '';

        foreach ($adv_rel_inputs as $rel_row) {
            if ($rel_row['name'] == $input_name) {
                foreach ($rel_row['status_options'] as $status) {
                    if (in_array($type, $status['type_id'])) {
                        if ($selected_status === $status['status_id']) $selected = " SELECTED"; else $selected = "";
                        $statuses .= "<option value='{$status['status_id']}'" . $selected . ">{$status['name']}</option>";
                    }
                }
            }
        }

        echo $statuses;
    }

    public function change_mass_status()
    {
        $ids = $this->input->post('ids');
        $status_value = $this->input->post('status_value');
        $table = $this->input->post('table');

        $this->inside_lib->check_access('inside2_' . $table, 'view');

        $table = $this->inside_lib->defend_filter(4, $table);

        if (!file_exists('application/config/pdg_tables/' . $table . '.php')) {
            echo 'Error';
            die();
        };
        include('application/config/pdg_tables/' . $table . '.php');

        if ($ids) {
            $status_value = intval($status_value);

            foreach ($adv_rel_inputs as $rel_row) {
                if ($rel_row['name'] == $table_config['status_rel_name']) {
                    $status_field = $rel_row['status_id_field'];
                    foreach ($rel_row['status_options'] as $status) {
                        if ($status_value == $status['status_id']) {
                            $new_status_name = $status['name'];
                            if (isset($status['interval'])) $new_status_interval = $status['interval'];
                        }
                    }
                    if(isset($rel_row['alert_field'])) {
                        $alert_field = $rel_row['alert_field'];
                    }
                }
            }

            $user_id = $this->ion_auth->get_user_id();

            foreach ($ids as &$id) {
                $id = intval($id);
            }
            unset($id);

            // Get records to update
            $this->db->select($table_config['key']);
            $this->db->from($table);
            $this->db->where("$status_field !=", $status_value);
            $this->db->where_in($table_config['key'], $ids);
            $records_to_update = $this->db->get()->result_array();

            foreach ($records_to_update as &$record) {
                $record = $record[$table_config['key']];
            }
            unset($record);

            $already_have_new_status = array_diff($ids, $records_to_update);

            if ($records_to_update) {
                // Change status in db
                $status_data = array($status_field => $status_value);
                if(isset($alert_field)) {
                    $status_data[$alert_field] = 0;
                }
                $this->db->where_in($table_config['key'], $records_to_update);
                $this->db->update($table, $status_data);

                // Add activity about status change
                $datetime = date("Y-m-d H:i:s");

                if (isset($new_status_interval)) {
                    $timestamp = strtotime(date("Y-m-d H:i:s") . " + " . "{$new_status_interval} hours");
                    $noty_datetime = date("Y-m-d H:i:s", $timestamp);
                }

                $activity_data = array();
                foreach ($records_to_update as $id) {
                    $activity_data[] = array(
                        'activity_element_id' => $id,
                        'activity_user' => $user_id,
                        'activity_text' => "Статус сменился на <b>{$new_status_name}</b>",
                        'activity_type_id' => 4,
                        'activity_time' => $datetime,
                        'activity_table' => $table,
                        'activity_data' => ''
                    );
                    if (isset($new_status_interval)) {
                        $activity_data[] = array(
                            'activity_element_id' => $id,
                            'activity_user' => $user_id,
                            'activity_text' => "Напомнить по истечении времени нахождения в статусе <b>{$new_status_name}</b> [через {$new_status_interval} час.]!!!",
                            'activity_type_id' => 5,
                            'activity_time' => $noty_datetime,
                            'activity_table' => $table,
                            'activity_data' => ''
                        );
                    }
                }

                $this->db->insert_batch('activities', $activity_data);
            }

            // Noty about already have status
            if ($already_have_new_status) {
                if ($records_to_update) {
                    if (count($already_have_new_status) > 1) {
                        echo '{"message":"Статус обновлен! Элементы ' . implode(', ', $already_have_new_status) . ' уже имеют статус ' . mb_strtoupper($new_status_name) . '", "update":' . json_encode($records_to_update) . '}';
                    } else {
                        echo '{"message":"Статус обновлен! Элемент ' . implode(', ', $already_have_new_status) . ' уже имеет статус ' . mb_strtoupper($new_status_name) . '", "update":' . json_encode($records_to_update) . '}';
                    }
                } elseif (count($ids) > 1) {
                    echo '{"message":"Все выбранные элементы уже имеют статус ' . mb_strtoupper($new_status_name) . '!"}';
                } elseif (count($ids) <= 1) {
                    echo '{"message":"Выбранный элемент уже имеет статус ' . mb_strtoupper($new_status_name) . '!"}';
                }
            } elseif ($records_to_update) {
                echo '{"message":"Статус обновлен", "update":' . json_encode($records_to_update) . '}';
            }

        }
    }

    public function add_uploads_image()
    {
        if (!$this->ion_auth->logged_in()) {
            show_404();
        }
        if (!isset($_POST['table']) OR $_POST['table'] == '') {
            echo 'Error';
            die();
        }
        $this->inside_lib->check_access('inside2_' . $_POST['table'], 'edit');

        $tmp_name = $_POST['name'];

        // Check folder change
        if (isset ($_POST['folder'])) $folder = $_POST['folder'] . "/";
        else $folder = "";
        // Update File System!

        if (isset($_POST['del_img_' . $tmp_name])) {
            //var_dump($_POST[$tmp_name]);
            $this->inside_lib->c7_delete_image($_POST[$tmp_name], $folder);
            //return '';

            $was_deleted = true;
        }

        if (isset($_POST['not_upload_img'])) {
            unset($_FILES);
        }

        if (isset($_FILES[$tmp_name]['name'])) {
            // Rename if cirilic name
            $_FILES[$tmp_name]['name'] = $this->inside_lib->ru2en_img($_FILES[$tmp_name]['name']);

            $_FILES[$tmp_name]['name'] = $this->inside_lib->C7_fs_file_upload($_FILES[$tmp_name]['tmp_name'], $_FILES[$tmp_name]['name'], "/files/uploads/" . $folder);

            if (isset($_POST['resize'])) {

                $this->load->library('image_lib');

                $path_to_image = $_SERVER["DOCUMENT_ROOT"] . "/files/uploads/" . $folder . $_FILES[$tmp_name]['name'];
                list($width, $height) = getimagesize($path_to_image);

                if (isset($_POST['new_width'])) $new_width = intval($_POST['new_width']);
                else $new_width = 200;

                if (isset($_POST['new_height'])) $new_height = intval($_POST['new_height']);
                else $new_height = 200;

                $config = Array();
                $config['height'] = $new_height;
                $config['width'] = $new_width;

                if (!empty($_POST['crop_center'])) {

                    $config_by_width = Array();
                    $config_by_width ['width'] = $new_width;
                    $config_by_width ['height'] = '800';
                    $config_by_width ['master_dim'] = 'width';
                    $config_by_width ['y_axis'] = round(($height * $new_width / $width - $new_height) / 2);
                    $config_by_width ['x_axis'] = 0;

                    $config_by_height = Array();
                    $config_by_height['height'] = $new_height;
                    $config_by_height['width'] = '800';
                    $config_by_height['master_dim'] = 'height';
                    $config_by_height['x_axis'] = round(($width * $new_height / $height - $new_width) / 2);
                    $config_by_height['y_axis'] = 0;

                    $config = $config_by_width;
                    $tmp_height = $height * $new_width / $width;
                    if ($tmp_height < $new_height) $config = $config_by_height;
                } else {
                    if (isset($_POST['resize_by_width'])) {
                        $config['master_dim'] = 'width';
                    } elseif (isset($_POST['resize_by_height'])) {
                        $config['master_dim'] = 'height';
                    } else {
                    }
                }

                //echo "Do Resize for: ".$path_to_image;
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path_to_image;
                // $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    //echo $CI->image_lib->display_errors();
                }

                $config['maintain_ratio'] = FALSE;
                $config['width'] = $new_width;
                $config['height'] = $new_height;

                $this->image_lib->initialize($config);

                if (isset($_POST['crop_center'])) {
                    if ($_POST['crop_center']) {

                        if (!$this->image_lib->crop()) {
                            //echo $CI->image_lib->display_errors();
                        }

                    }
                }
                $this->image_lib->clear();
            }

            echo "<span class='path_to_folder'>" . $folder . "</span><span class='path_to_image'>" . $_FILES[$tmp_name]['name'] . "</span>";
        }
    }

    public function add_uploads_multi_image()
    {
        if (!$this->ion_auth->logged_in()) {
            show_404();
        }
        if (!isset($_POST['table']) OR $_POST['table'] == '') {
            echo 'Error';
            die();
        }
        if (!isset($_POST['name']) OR $_POST['name'] == '') {
            echo 'Error';
            die();
        }
        $this->inside_lib->check_access('inside2_' . $_POST['table'], 'edit');

        $files_arr = Array();

        $my_img_arr = @$_POST['m_images_' . $_POST['name']];
        $del_img_arr = @$_POST['del_img_m_images_' . $_POST['name']];

        for ($i = 0; $i < count($my_img_arr); $i++) {
            $no_del = true;
            for ($j = 0; $j < count($del_img_arr); $j++) {
                if ($del_img_arr[$j] == $my_img_arr[$i]) {
                    $this->inside_lib->c7_delete_image($my_img_arr[$i], $_POST['folder'] . "/");
                    $no_del = false;
                }

            }
            if ($no_del) $files_arr[] = $my_img_arr[$i];

        }

        if (isset ($_FILES['add_file_' . $_POST['name']])) {
            $this->load->library('image_lib');

            $cpt = count($_FILES['add_file_' . $_POST['name']]['name']);
            for ($i = 0; $i < $cpt; $i++) {

                $_FILES['add_file_now']['name'] = $_FILES['add_file_' . $_POST['name']]['name'][$i];
                $_FILES['add_file_now']['type'] = $_FILES['add_file_' . $_POST['name']]['type'][$i];
                $_FILES['add_file_now']['tmp_name'] = $_FILES['add_file_' . $_POST['name']]['tmp_name'][$i];
                $_FILES['add_file_now']['error'] = $_FILES['add_file_' . $_POST['name']]['error'][$i];
                $_FILES['add_file_now']['size'] = $_FILES['add_file_' . $_POST['name']]['size'][$i];

                $folder = $_POST['folder'] . '/';
                $tmp_name = 'add_file_now';
                $config = Array();
                $this->image_lib->clear();

                // Rename
                $_FILES[$tmp_name]['name'] = $this->inside_lib->ru2en_img($_FILES[$tmp_name]['name']);

                $_FILES[$tmp_name]['name'] = $this->inside_lib->C7_fs_file_upload($_FILES[$tmp_name]['tmp_name'], $_FILES[$tmp_name]['name'], "/files/uploads/" . $folder);


                if ($_FILES[$tmp_name]['name']) $files_arr[] = $_FILES[$tmp_name]['name']; // Add File to Array

                if (isset($_POST['resize'])) {

                    $path_to_image = $_SERVER["DOCUMENT_ROOT"] . "/files/uploads/" . $folder . $_FILES[$tmp_name]['name'];
                    list($width, $height) = getimagesize($path_to_image);

                    //echo $width." x ".$height." !!!";

                    if (isset($_POST['new_width'])) $new_width = intval($_POST['new_width']);
                    else $new_width = 200;

                    if (isset($_POST['new_height'])) $new_height = intval($_POST['new_height']);
                    else $new_height = 200;

                    $config['height'] = $new_height;
                    $config['width'] = $new_width;

                    if (!empty($_POST['crop_center'])) {

                        $config_by_width ['width'] = $new_width;
                        $config_by_width ['height'] = '800';
                        $config_by_width ['master_dim'] = 'width';
                        $config_by_width ['y_axis'] = round(($height * $new_width / $width - $new_height) / 2);
                        $config_by_width ['x_axis'] = 0;

                        $config_by_height['height'] = $new_height;
                        $config_by_height['width'] = '800';
                        $config_by_height['master_dim'] = 'height';
                        $config_by_height['x_axis'] = round(($width * $new_height / $height - $new_width) / 2);
                        $config_by_height['y_axis'] = 0;

                        $config = $config_by_width;
                        $tmp_height = $height * $new_width / $width;
                        if ($tmp_height < $new_height) $config = $config_by_height;

                    } else {
                        if (!empty($_POST['resize_by_width'])) {
                            $config['master_dim'] = 'width';
                        } elseif (!empty($_POST['resize_by_height'])) {
                            $config['master_dim'] = 'height';
                        } else {
                        }
                    }

                    //echo "Do Resize for: ".$path_to_image;
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $path_to_image;
                    // $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;

                    $this->image_lib->initialize($config);

                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    }

                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = $new_width;
                    $config['height'] = $new_height;

                    $this->image_lib->initialize($config);

                    if (isset($_POST['crop_center'])) {
                        if ($_POST['crop_center']) {

                            if (!$this->image_lib->crop()) {
                                echo $this->image_lib->display_errors();
                            }

                        }
                    }

                }

            }
        }
        if (!empty($files_arr)) {
            echo '<ul class="multi_images_response_' . $_POST['name'] . '">';
            foreach ($files_arr as $file) {
                echo "<li>$file</li>";
            }
            echo '</ul>';
        }
    }

    public function change_mass_access()
    {
        $ids = $this->input->post('ids');
        $access_value = $this->input->post('access_value');
        $table = $this->input->post('table');

        $this->inside_lib->check_access('inside2_' . $table, 'view');

        $table = $this->inside_lib->defend_filter(4, $table);

        if (!file_exists('application/config/pdg_tables/' . $table . '.php')) {
            echo 'Error';
            die();
        };
        include('application/config/pdg_tables/' . $table . '.php');

        if ($ids) {
            $access_value = intval($access_value);

            $access_update_array = array(
                1 => array('ar_all_view' => 1, 'ar_all_edit' => 1),
                2 => array('ar_all_view' => 1, 'ar_group_edit' => 1),
                3 => array('ar_all_view' => 1, 'ar_creator_edit' => 1),
                4 => array('ar_group_view' => 1, 'ar_group_edit' => 1),
                5 => array('ar_group_view' => 1, 'ar_creator_edit' => 1),
                6 => array('ar_creator_view' => 1, 'ar_creator_edit' => 1),
            );
            $update_array = isset($access_update_array[$access_value]) ? $access_update_array[$access_value] : null;

            if (!$this->ion_auth->is_admin()) {
                $items_without_access = $this->check_edit_access();
            } else {
                $items_without_access = array();
            }
            $items_with_access = array_diff($ids, $items_without_access);

            if ($items_with_access && $update_array) {

                $sql_in_string = implode(', ', $items_with_access);

                $this->db->query("UPDATE $table SET ar_all_view=0, ar_all_edit=0, ar_group_view=0, ar_group_edit=0, ar_creator_view=0, ar_creator_edit=0 WHERE {$table_config['key']} IN ($sql_in_string)");

                $this->db->where_in($table_config['key'], $items_with_access);
                $this->db->update($table, $update_array);
            }

            // Notyfication
            if ($items_without_access) {
                if ($items_with_access) {
                    if (count($items_without_access) > 1) {
                        echo '{"message":"Права доступа обновлены! Элементы ' . implode(', ', $items_without_access) . ' нельзя редактировать!"}';
                    } else {
                        echo '{"message":"Права доступа обновлены! Элемент ' . implode(', ', $items_without_access) . ' нельзя редактировать!"}';
                    }
                } elseif (count($ids) > 1) {
                    echo '{"message":"Выбранные элементы нельзя редактировать!"}';
                } elseif (count($ids) <= 1) {
                    echo '{"message":"Выбранный элемент нельзя редактировать!"}';
                }
            } elseif ($items_with_access) {
                echo '{"message":"Права доступа обновлены!"}';
            }
        }
    }

    private function check_edit_access()
    {
        if (isset($_POST['ids'])) {

            $table = $this->inside_lib->defend_filter(4, $_POST['table']);

            include('application/config/pdg_tables/' . $table . '.php');

            $current_user = $this->ion_auth->get_user_id();

            $user_in_work_group = $this->ion_auth->in_group($table_config['access_work_groups']);

            if (isset($table_config['access_creator_fields'])) {
                $creators_access_users = array();
                foreach ($table_config['access_creator_fields'] as $field_name) {
                    $creators_access_users_keys[] = $field_name;
                }

                $creators_access_users_key_string = implode(', ', $creators_access_users_keys);

                if ($creators_access_users_key_string) {
                    $this->db->select($creators_access_users_key_string . ', ' . $table_config['key']);
                    $this->db->where_in($table_config['key'], $_POST['ids']);
                    $creator_users_array = $this->db->get($table)->result_array();

                    //$ids_by_item = array();
                    foreach ($creator_users_array as $item) {
                        foreach ($item as $key => $value) {
                            if ($key != $table_config['key'] AND $value != 0) {
                                $ids_by_item[$item[$table_config['key']]][] = $value;
                            }
                        }
                    }
                }
            }

            $this->db->select("{$table_config['key']}, ar_all_edit, ar_group_edit, ar_creator_edit, ar_user_id");
            $this->db->where_in($table_config['key'], $_POST['ids']);
            $access_data = $this->db->get($table)->result_array();

            $access_entrance = array();

            foreach ($access_data as $edit_item) {

                if ($edit_item['ar_all_edit'] == 1) {
                    continue;
                } elseif ($edit_item['ar_group_edit'] == 1 AND $user_in_work_group) {
                    continue;
                } elseif ($edit_item['ar_creator_edit'] == 1 AND ($edit_item['ar_user_id'] == $current_user OR (isset($ids_by_item[$edit_item[$table_config['key']]]) AND in_array($current_user, $ids_by_item[$edit_item[$table_config['key']]]))) AND $user_in_work_group) { // made fix for creator (who in group)
                    continue;
                } else {
                    $access_entrance[] = $edit_item[$table_config['key']];
                }
            }

            return $access_entrance;
        }
    }

    public function change_agreement_statuses($status_id = null, $element_id = 0)
    {
        if (!$this->ion_auth->logged_in()) {
            show_404();
        }
        if ($status_id === null OR $element_id == 0) {
            echo 'Error';
            die();
        }
        if (!isset($_POST['table']) OR $_POST['table'] == '') {
            echo 'Error';
            die();
        }

        $this->inside_lib->check_access('inside2_' . $_POST['table'], 'edit');

        if($status_id == 2 && !$this->ion_auth->is_admin()) {
            echo '{"status":0}';
        }

        $user_id = $this->ion_auth->get_user_id();

        $data = array(
            'tree_id' => intval($element_id),
            'user_id' => $user_id,
            'status' => intval($status_id)
        );

        if($this->db->query("SELECT * FROM realty_tree_agrees WHERE tree_id={$element_id} AND user_id={$user_id}")->row_array()) {
            $this->db->where('tree_id', $element_id);
            $this->db->where('user_id', $user_id);
            $this->db->update('realty_tree_agrees', $data);
        } else {
            $this->db->insert('realty_tree_agrees', $data);
        }

        $data_activities = array(
            'activity_type_id' => 13,
            'activity_table' => $_POST['table'],
            'activity_element_id' => $element_id,
            'activity_user' => $user_id,
            'activity_text' => $text = $status_id == 1 ? "Подтвердил согласие!" : "Отменил согласие!",
            'activity_time' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('activities', $data_activities);

        echo '{"status":1}';
    }

    public function get_agreed_users($tree_id = null)
    {
        if (!$this->ion_auth->is_admin()) {
            show_404();
        }
        if ($tree_id === null) {
            echo 'Error';
            die();
        }
        if (!isset($_POST['table']) OR $_POST['table'] == '') {
            echo 'Error';
            die();
        }

        //$this->inside_lib->check_access('inside2_' . $_POST['table'], 'edit');

        $users = $this->db->query("SELECT users.id, users.fio, realty_tree_agrees.status
                          FROM realty_tree_agrees
                          LEFT JOIN users ON users.id = realty_tree_agrees.user_id
                          WHERE realty_tree_agrees.tree_id = {$tree_id}")->result_array();

        $users_list = '';

        foreach ($users as $user) {
            if($user['status'] == 1) {
                $users_list .= "<li user_id='{$user['id']}'>[{$user['id']}] {$user['fio']} <i style='color: crimson;' class=\"fa fa-times control_user_status\" aria-hidden=\"true\"></i></li>";
            } else {
                $users_list .= "<li user_id='{$user['id']}'>[{$user['id']}] {$user['fio']} <i style='color: #5cb85c;' class=\"fa fa-check control_user_status\" aria-hidden=\"true\"></i></li>";
            }
        }

        if($users_list) {
            echo $users_list;
        } else {
            echo 'Пусто!';
        }
    }

    public function control_user_status($tree_id = 0, $user_id = 0)
    {
        if (!$this->ion_auth->is_admin()) {
            show_404();
        }
        if ($tree_id ==0 OR $user_id == 0) {
            echo 'Error';
            die();
        }
        if (!isset($_POST['table']) OR $_POST['table'] == '') {
            echo 'Error';
            die();
        }

        if (!isset($_POST['status']) OR $_POST['status'] == '') {
            echo 'Error';
            die();
        }

        //$this->inside_lib->check_access('inside2_' . $_POST['table'], 'edit');

        $data = array(
            'status' => intval($_POST['status'])
        );

        $this->db->where('tree_id', $tree_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('realty_tree_agrees', $data);

        $data_activities = array(
            'activity_type_id' => 13,
            'activity_table' => $_POST['table'],
            'activity_element_id' => $tree_id,
            'activity_user' => $user_id,
            'activity_text' => $text = $_POST['status'] == 1 ? "Подтвердил согласие у пользователя c id #$user_id!" : "Отменил согласие у пользователя c id #$user_id!",
            'activity_time' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('activities', $data_activities);

        if(intval($_POST['status']) == 1) {
            echo '{"status":1}';
        } elseif(intval($_POST['status']) == 2) {
            echo '{"status":2}';
        } else {
            echo '{"status":0}';
        }

    }
}