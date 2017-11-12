<?php
class Demo_Model extends CI_Model
{

    var $table_id_column = "content_id";

    var $table_columns_arr = Array (
        "checkbox" => Array(
            "crud_name" => '<input id="box0" type="checkbox" class="with-font"><label for="box0"></label>',
            "custom_table_cell_view" => "admin/pages/crud/demo_checkbox_cell",
        ),
        "content_id" => Array(
        "column_name" => "content_id",
        "crud_name" => "ID",
        ),
        "content_name" => Array(
            "crud_name" => "Название",
        ),
        "content_desc" => Array(
            "crud_name" => "Описание",
            "custom_table_cell_view" => "admin/pages/crud/demo_custom_cell",
        ),
        "content_img" => Array(
            "crud_name" => "Картинка",
        ),
        "controls" => Array(
            "crud_name" => "Действия",
            "custom_table_cell_view" => "admin/pages/crud/demo_control_cell",
        ),
    );

    public function get_data() {

        $res = $this->db->query("SELECT users.id,
                                        users.email as login,
                                        users.active,
                                        users.email as full_name,
                                        users.company as position,
                                        users.email,
                                        users.phone,
                                        users.phone as skype,
                                        users.phone as birthday,
                                        users.img as photo

										FROM users

										ORDER BY email ASC
										")->result_array();

        return $res;

    }

    public function get_main() {

        $res = $this->db->query("SELECT *
										FROM it_content
										WHERE content_invisible = 0
										ORDER BY content_name ASC
										")->result_array();

        return $res;

    }

}