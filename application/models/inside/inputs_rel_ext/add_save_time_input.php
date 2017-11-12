<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_save_time_input
{
    public function input_form($input_array)
    {
        ob_start();
        ?>
        <input type="hidden" name="add_save_time_<?= $input_array['name'] ?>_input">

        <?php
        $data = ob_get_clean();
        return $data;
    }

   public function db_save($input_array, $cell_id)
    {
        if (isset($_POST['add_save_time_' . $input_array['name'] . '_input'])) {
            $data = array(
                $input_array['save_value_column'] => time(),
            );
            $CI =& get_instance();
            $CI->db->where($input_array['id_column'], $cell_id);
            $CI->db->update($input_array['table_name'], $data);
        }
    }

    public function db_add($input_array, $cell_id)
    {
        if (isset($_POST['add_save_time_' . $input_array['name'] . '_input'])) {
            $data = array(
                $input_array['add_value_column'] => time(),
            );
            $CI =& get_instance();
            //$CI->db->insert($input_array['table_name'], $data);
            $CI->db->where($input_array['id_column'], $cell_id);
            $CI->db->update($input_array['table_name'], $data);
        }
    }

    // Пример конфига
     /*Array(
        'name' => 'add_save_time_input',
        'input_type' => 'add_save_time_input',
        'table_name' => 'm_tasks', //имя таблицы, куда сохраняется значение
        'id_column' => 'tasks_id', //название колонки (айди строки в бд)
        'save_value_column' => 'tasks_time_edit', //колонка куда сохранять время редактирования
        'add_value_column' => 'tasks_time_add', //колонка куда сохранять время добавления
        'text' => '',
        'tab' => 'main',
    ),*/

}
