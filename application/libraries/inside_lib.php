<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Inside library
 *
 * @author Alex Torrison
 */
class Inside_lib
{

    /**
     * Constructor
     */
    public function __construct($config = array())
    {
        log_message('debug', "Inside_lib Class Initialized");
    }

    // Input Model Loader
    public function make_input($part, $input_array)
    {
        if (isset($input_array['input_type'])) {
            if (!isset($input_array['width'])) $input_array['width'] = 400;
            $type = $input_array['input_type'];
            $type = str_replace("-", "_", $type); // Fix Minus to C++ style
            $model_name = "make_input_" . $type;
            $CI =& get_instance();

            if (file_exists(APPPATH . 'models/inside/inputs/' . $type . '.php')) {
                $CI->load->model('inside/inputs/' . $type, $model_name);

                if (method_exists($CI->$model_name, $part)) {
                    return $CI->$model_name->$part($input_array);
                } else if ($part == "input_filter") {
                    $input_array['width'] = 100;
                    return $CI->$model_name->input_form($input_array) . "<br />\n"; // Default input for form
                } else if ($part == "db_save") {
                    return $input_array['value']; // Default value without changes
                } else if ($part == "crud_view") {
                    return $input_array['value']; // Default value without changes
                }
            } elseif (file_exists(APPPATH . 'models/inside/inputs_ext/' . $type . '.php')) {
                $CI->load->model('inside/inputs_ext/' . $type, $model_name);
                if (method_exists($CI->$model_name, $part))
                    return $CI->$model_name->$part($input_array);
                else if ($part == "input_filter") {
                    $input_array['width'] = 100;
                    return $CI->$model_name->input_form($input_array) . "<br />\n"; // Default input for form
                } else if ($part == "db_save") {
                    return $input_array['value']; // Default value without changes
                } else if ($part == "crud_view") {
                    return $input_array['value']; // Default value without changes
                }
            } else return "File not found: " . APPPATH . 'models/inside/inputs/' . $type . '.php';
        }
    }

    // Input Model Loader
    public function make_rel_input($part, $input_array, $cell_id)
    {
        if (isset($input_array['input_type'])) {
            if (!isset($input_array['width'])) $input_array['width'] = 500;
            $type = $input_array['input_type'];
            $type = str_replace("-", "_", $type); // Fix Minus to C++ style
            $model_name = "make_rel_input_" . $type;

            $CI =& get_instance();

            if (file_exists(APPPATH . 'models/inside/inputs_rel/' . $type . '.php')) {
                $CI->load->model('inside/inputs_rel/' . $type, $model_name);
                // Fix for activities
                if (method_exists($CI->$model_name, $part)) {
                    return $CI->$model_name->$part($input_array, $cell_id);
                }
            } elseif (file_exists(APPPATH . 'models/inside/inputs_rel_ext/' . $type . '.php')) {
                $CI->load->model('inside/inputs_rel_ext/' . $type, $model_name);
                // Fix for activities
                if (method_exists($CI->$model_name, $part)) {
                    return $CI->$model_name->$part($input_array, $cell_id);
                }
            } else return "File not found: " . APPPATH . 'models/inside/inputs_rel/' . $type . '.php';
        }
    }

    // ------------------------------------------------------------------------------ Defent Filter -------------
    public function defend_filter($defendtype, $data)
    {

        if ($defendtype == "1") {   // For Guest
            $data = str_replace("&", "&amp;", $data);
            $data = str_replace("'", "&#8217;", $data);
            $data = str_replace("<", "&lt;", $data);
            $data = str_replace(">", "&gt;", $data);
            $data = str_replace("\"", "&quot;", $data);
            $data = str_replace(">", "&gt;", $data);
            //$data = mysql_escape_string($data);
            //$data = str_replace ("\\\"","&quot;",$data);
        }


        if ($defendtype == "2") {   // For Admin
            $data = str_replace("'", "&#8217;", $data);
            //$data = mysql_escape_string($data);
        }

        if ($defendtype == "3") {   // For Forms
            $data = str_replace("&", "", $data);
            $data = str_replace("<", "", $data);
            $data = str_replace(">", "", $data);
            $data = str_replace("\"", "", $data);
            $data = str_replace("'", "", $data);
        }

        if ($defendtype == "4") {   // For string, which works in filesystem functions
            $data = preg_replace("/[^a-z0-9_.]/i", "1", $data);
        }

        if ($defendtype == "5") {   // For integer
            $data = intval($data);
        }

        if ($defendtype == "6") {   // For Files
            $data = str_replace("<", "", $data);
            $data = str_replace(">", "", $data);
            $data = str_replace("\"", "", $data);
            $data = str_replace("\\", "", $data);
            $data = str_replace("/", "", $data);
            $data = str_replace("'", "", $data);

        }

        if ($defendtype == "7") {   // For Developers
            $data = str_replace("'", "''", $data);
        }

        if ($defendtype == "8") {   // For Guest Chat
            $data = str_replace("&", "&amp;", $data);
            $data = str_replace("'", "&#8217;", $data);
            $data = str_replace("<", "&lt;", $data);
            $data = str_replace(">", "&gt;", $data);
            $data = str_replace("\n", "<br />", $data);
            $data = mysql_escape_string($data);
        }

        if ($defendtype == "9") {   // For Integer
            $data = intval($data);
        }

        if ($defendtype == "A") {   // No Filter
            $data = $data;
        }


        return $data;
    }

    // Defent Array [] {} etc. to string
    public function C7_defend_array($defendtype, $array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $array[$i] = $this->defend_filter($defendtype, $array[$i]);
        }
        return $array;
    }

    //------------------------------------------------------------------------------  File System Functions ---------------------

    public function C7_fs_file_upload($filetmp, $filename, $path)
    {
        if ($filetmp != "") {
            #DEBUG echo  "<script>alert('".$_FILES[$input_name]["name"]." ready!')</script>\n";
            $new_file_name = $this->C7_fs_is_exists_file($filename, $path);
            #DEBUG echo  "<script>alert('".$new_file_name." �����!')</script>\n";
            move_uploaded_file($filetmp, $_SERVER["DOCUMENT_ROOT"] . $path . $new_file_name);
            // if ($GLOBALS['debug_mode'] == true) echo  "<script>alert('".$_SERVER["DOCUMENT_ROOT"].$path.$new_file_name." saved!')</script>\n";
            #DEBUG echo  "<script>alert('".$_SERVER["DOCUMENT_ROOT"].$path.$new_file_name." saved!')</script>\n";
            #DEBUG echo  "<script>alert('".$_FILES[$input_name]["tmp_name"]." saved!')</script>\n";
            if ($this->C7_fs_file_check($new_file_name, $path)) return $new_file_name;
            else {
                rename($_SERVER["DOCUMENT_ROOT"] . $path . $new_file_name, $_SERVER["DOCUMENT_ROOT"] . $path . "error_file");
                return "error_file";
            }
        }
    }

    //Check file if exists and give new name if it is copy.
    public function C7_fs_is_exists_file($filename, $path)
    {
        $i = 0;
        $new_file_name = $filename;
        $unique_name_find = false;
        while ($unique_name_find != true) {
            if (file_exists($_SERVER["DOCUMENT_ROOT"] . $path . $new_file_name)) {
                $new_file_name = "copy" . $i . "_" . $filename;
            } else {
                $unique_name_find = true;
            }
            $i++;
        }
        return $new_file_name;
    }

    // Fast Write data to file
    public function write_in_file($filename, $data)
    {
        $filename = $this->C7_fs_stripfilename($filename);
        if (is_writeable($filename)) :
            $fh = fopen($filename, "a+");
            fwrite($fh, $data);
            fclose($fh);
        else :
            print "Could not open $filename for writing";
        endif;
        return true;
    }

    // Files Defend Filter
    public function C7_fs_file_check($new_file_name, $path)
    {
        $file_ok = false;
        if (preg_match("/.png/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.jpg/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.jpeg/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.bmp/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.gif/i", $new_file_name)) $file_ok = true;

        if (($file_ok == true) && ($this->C7_fs_verify_image($_SERVER["DOCUMENT_ROOT"] . $path . $new_file_name))) $file_ok = true;

        if (preg_match("/.doc/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.xls/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.txt/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.docx/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.xlsx/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.psd/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.ppt/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.pptx/i", $new_file_name)) $file_ok = true;
        if (preg_match("/.pdf/i", $new_file_name)) $file_ok = true;

        if ($file_ok == true) return true;
        else return false;
    }

    // Scan image files for malicious code
    public function C7_fs_verify_image($file)
    {
        $txt = file_get_contents($file);
        $image_safe = true;
        if (preg_match('#&(quot|lt|gt|nbsp|<?php);#i', $txt)) {
            $image_safe = false;
        } elseif (preg_match("#&\#x([0-9a-f]+);#i", $txt)) {
            $image_safe = false;
        } elseif (preg_match('#&\#([0-9]+);#i', $txt)) {
            $image_safe = false;
        } elseif (preg_match("#([a-z]*)=([\`\'\"]*)script:#iU", $txt)) {
            $image_safe = false;
        } elseif (preg_match("#([a-z]*)=([\`\'\"]*)javascript:#iU", $txt)) {
            $image_safe = false;
        } elseif (preg_match("#([a-z]*)=([\'\"]*)vbscript:#iU", $txt)) {
            $image_safe = false;
        } elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU", $txt)) {
            $image_safe = false;
        } elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU", $txt)) {
            $image_safe = false;
        } elseif (preg_match("#</*(applet|link|style|script|iframe|frame|frameset)[^>]*>#i", $txt)) {
            $image_safe = false;
        }
        return $image_safe;
    }

    // Strip file name
    public function C7_fs_stripfilename($filename)
    {
        $filename = strtolower(str_replace(" ", "_", $filename));
        $filename = preg_replace("/^\W/", "", $filename);
        $filename = preg_replace('/([_-])\1+/', '$1', $filename);
        $filename = str_replace("//", "_", $filename);
        if ($filename == "") {
            $filename = "emptyfile";
        }

        return $filename;
    }

    // Delete File
    public function c7_delete_image($name, $folder = "", $access = true)
    {
        $name = $this->C7_defend_array("6", $name);
        if ($access) {
            if (isset($name)) {
                unlink($_SERVER["DOCUMENT_ROOT"] . "/files/uploads/" . $folder . $name);
            }
        }
        //echo "<script>alert('".$_SERVER["DOCUMENT_ROOT"]."/files/uploads/".$folder.$name."111')</script>";
    }


    // Advanced: Get User Data
    public function get_user_info($user_id)
    {
        $CI =& get_instance();
        $array['id'] = $user_id;

        // Find User Name
        $query = $CI->db->query("SELECT * FROM users WHERE id = " . $user_id);
        $res = $query->result_array();
        foreach ($res as $row) {
            $array['users'] = $row;
        }

        // Find Groups
        $query = $CI->db->query("SELECT * FROM users_groups LEFT JOIN groups ON users_groups.group_id = groups.id" . " WHERE user_id = " . $user_id);
        $array['groups'] = $query->result_array();
        return $array;
    }

    // Advanced: Get User Data
    public function make_tree_view($res, $columns = false, $lang_prefix = '', $ul_attr = '')
    {
        if (!$columns) {
            $id_column = 'categories_id';
            $pid_column = 'categories_pid';
            $name_column = 'categories_name';
            $haschild_column = 'categories_haschild';
            $invisible_column = 'categories_invisible';
            $url_column = 'categories_alias';
            $url_prefix = $lang_prefix . '/content/category_list/';
            $data_prefix = "- ";
        } else {
            $id_column = $columns['id_column'];
            $pid_column = $columns['pid_column'];
            $name_column = $columns['name_column'];
            $haschild_column = $columns['haschild_column'];
            $invisible_column = $columns['invisible_column'];
            $url_column = $columns['url_column'];
            $url_prefix = $lang_prefix . $columns['url_prefix'];
            $data_prefix = $columns['data_prefix'];
        }


        $prefix_count = 0;

        $data = "\n<div class=\"tree_container\"><ul" . $ul_attr . ">\n";

        $catalog_tree = $res;
        $count = count($catalog_tree);
        $i = 0;                      // Reset $i
        #$limit = 0;			   // Defend counter for Debuging
        $parent_step = 0;          // Start in parent_id = 0
        $parent[$parent_step] = 0; // Parent to Child Step Array
        $now_output = array();     // Array for ouput printing data
        while ($i <= $count) {
            #$data .= "{".$catalog_tree[$i]['parent_id']."<< = >>".$parent[$parent_step]."}"; #Debuging echo
            $now_output_signal = false; #reset now output signal

            if (@$catalog_tree[$i][$invisible_column] == 1) {
                array_push($now_output, $catalog_tree[$i][$id_column]);
                $i++;
            } else {

                for ($j = 0; $j < count($now_output); $j++) {
                    if (@$catalog_tree[$i][$id_column] == $now_output[$j]) {
                        $now_output_signal = true;
                        break;
                    } #Check for ouput printing data
                }

                if ((@$catalog_tree[$i][$pid_column] == $parent[$parent_step]) && (@$catalog_tree[$i][$id_column] > 0)) #if id has parent_id in current parent level (start in 0)
                {
                    if ($catalog_tree[$i][$haschild_column] == 1) #For HasChild Line
                    {
                        if ($now_output_signal == false) #if id has not printed
                        {
                            $parent_step++;
                            $parent[$parent_step] = $catalog_tree[$i][$id_column];

                            if ($catalog_tree[$i][$haschild_column] == 1) {
                                $catalog_tree[$i][$id_column] = $catalog_tree[$i][$id_column] . "p";
                            }
                            $data .= "<li>" . str_repeat($data_prefix, $prefix_count) . "<a href=\"" . $url_prefix . $catalog_tree[$i][$url_column] . "\" title=\"" . $catalog_tree[$i][$name_column] . "\">" . $catalog_tree[$i][$name_column] . "</a><ul>\n";

                            array_push($now_output, $catalog_tree[$i][$id_column]);
                            $i = 0; #parent step+1, new parent has added, if not empty, data printed, prefix+1 "->" , array push printed id!. Start again.
                            $prefix_count++;
                        }
                    } else {
                        if ($now_output_signal == false) #if id has not printed
                        {
                            $data .= "<li>" . str_repeat($data_prefix, $prefix_count) . "<a href=\"" . $url_prefix . $catalog_tree[$i][$url_column] . "\" title=\"" . $catalog_tree[$i][$name_column] . "\">" . $catalog_tree[$i][$name_column] . "</a>\n</li>";
                            array_push($now_output, $catalog_tree[$i][$id_column]);
                        }
                    }
                }
                if ($i == $count) {
                    $i = 0;
                    $parent_step--;
                    $prefix_count--;
                    $data .= "</ul></li>";
                } #step left in prefix way in the end of data
                $i++;
                #$limit++; if ($limit == 260) $i = $tree_i+5; # Defend system for ulimited while
                if (!isset($parent[$parent_step])) $i = $count + 5; #The End Of While, Bacause Step = -1
            }
        }

        $data = substr($data, 0, strlen($data) - 10);
        $data .= "</ul></div>\n";
        return $data;
    }


    public function GetUserGroups($user_id)
    {

        $CI =& get_instance();
        $sql = "
            SELECT groups.name
                    FROM groups
                    LEFT JOIN users_groups ON users_groups.group_id = groups.id
                    WHERE users_groups.user_id = " . intval($user_id) . "
        ";
        $groups_arr = $CI->db->query($sql)->result_array();
        $user_groups = Array();
        foreach ($groups_arr as $group_row) $user_groups[] = $group_row['name'];

        return $user_groups;

    }

    public function AdminTreeMenu()
    {

        $CI =& get_instance();
        if (isset($CI->ion_auth->user()->row()->id))
            $user_id = $CI->ion_auth->user()->row()->id;
        else {
            echo "Auth Error!";
            exit();
        }

        $user_groups = $this->GetUserGroups($user_id);
        $sql = "
            SELECT groups_access.module_id
                    FROM groups_access
                    LEFT JOIN inside_top_menu ON inside_top_menu.top_menu_id = groups_access.module_id
                    LEFT JOIN users_groups ON users_groups.group_id = groups_access.group_id
                    WHERE
                    users_groups.user_id = " . intval($user_id) . " AND
                    groups_access.module_init = 1
                    GROUP BY groups_access.module_id
        ";
        $menu_access_arr = $CI->db->query($sql)->result_array();
        $in_menu_fast_arr = Array();
        foreach ($menu_access_arr as $tmp_row) $in_menu_fast_arr[$tmp_row['module_id']] = true;
        // print_r($menu_access_arr);


        $sql = 'SELECT * FROM inside_top_menu
	                                WHERE top_menu_invisible = 0 ORDER BY top_menu_parent_id, top_menu_priority, top_menu_name ASC';

        $res = $CI->db->query($sql)->result_array();

        $i = 0;
        $tmp_id_arr = Array();
        foreach ($res as $row) {
            // Access
            if (isset($in_menu_fast_arr[$row['top_menu_id']]) || in_array('admin', $user_groups)) {
                $tmp_id_arr[] = $row['top_menu_id'];
                $db_array[$i]['id'] = $row['top_menu_id'];
                $db_array[$i]['parent_id'] = $row['top_menu_parent_id'];
                $db_array[$i]['haschild'] = $row['top_menu_haschild'];
                $db_array[$i]['name'] = $row['top_menu_name'];

                $db_array[$i]['name_ru'] = $row['top_menu_name'];
                $db_array[$i]['name_ua'] = $row['top_menu_name'];
                $db_array[$i]['name_en'] = $row['top_menu_name'];
                $db_array[$i]['name_de'] = $row['top_menu_name'];

                $db_array[$i]['url'] = $row['top_menu_url'];
                $db_array[$i]['invisible'] = $row['top_menu_invisible'];
                $db_array[$i]['priority'] = $row['top_menu_priority'];
                $db_array[$i]['width'] = $row['top_menu_width'];
                $db_array[$i]['width_child'] = $row['top_menu_widthchild'];
                $i++;
            }

        }

        // Need Extension: Access System !!! MUST BE FIXED !!!

        // Reset $i
        $i = 0;
        // Parent shift (nesting level)
        $parent_shift = 0;
        // Parent elements work array
        $parent_now = array();
        // Start Parent ID
        $parent_now[$parent_shift] = 0;
        // Temporary var for while
        $stop = false;
        while ($stop != true) {
            // Filtering by Parent and non-added, where we located now
            if ((!isset($db_array[$i]['added'])) && ($db_array[$i]['parent_id'] == $parent_now[$parent_shift])) {
                // If we have found parent
                if ($db_array[$i]['haschild'] == 1) #For HasChild Line
                {
                    // Do Shift inside the parent
                    $parent_shift++;
                    // Add ID of parent_now array
                    $parent_now[$parent_shift] = $db_array[$i]['id'];
                    // Save row to output Array
                    $ready_arr[] = $db_array[$i];
                    // Add system element
                    $ready_arr[] = array("shift" => true, "action" => "open");
                    // Add Added sign to row
                    $db_array[$i]['added'] = true;
                    // Restart cicle
                    $i = 0;
                } else {
                    // Save row to output Array
                    $ready_arr[] = $db_array[$i];
                    // Add Added sign to row
                    $db_array[$i]['added'] = true;
                }

            }

            //$ready_arr[] = $db_array[$i];

            $i++;
            // When id-s ended, we must restart  cicle
            if (!isset($db_array[$i]['id'])) {
                // if we are in the parent, we return to top level
                if ($parent_shift > 0) {
                    $parent_shift--;
                    $i = 0;
                    $ready_arr[] = array("shift" => true, "action" => "close");
                } // or ended cicle
                else $stop = true;
            }
        }

        return $ready_arr;

    }

    public function menu_search()
    {

        $CI =& get_instance();
        $sql = "
            SELECT

            	top_menu_name as name,
            	top_menu_url as url

				FROM inside_top_menu

				LEFT JOIN groups_access ON groups_access.module_id = top_menu_id
				LEFT JOIN users_groups ON users_groups.group_id = groups_access.group_id

				WHERE

				users_groups.user_id = " . intval($CI->ion_auth->get_user_id()) . "

				AND module_init = 1

				AND inside_top_menu.top_menu_name LIKE " . $CI->db->escape('%' . $CI->input->get('query') . '%') . "

				AND top_menu_url != ''

				AND top_menu_invisible = 0

				GROUP BY top_menu_id

				ORDER BY inside_top_menu.top_menu_name

        ";
        $res = $CI->db->query($sql)->result_array();

        return $res;

    }

    public function autocomplete_search($table_name, $join_key, $join_name, $custom_sql, $limit = '')
    {
        $CI =& get_instance();

        // Fix for phone +
        if(strpos(urlencode($CI->input->get('q')),'+') === 0) $query = '+'.trim($CI->input->get('q'));
        else $query = $CI->input->get('q');

        // LIMIT
        if($limit == '') $limit = '';
        else $limit = ' LIMIT ' . $limit;

        if($custom_sql) {
            $sql = $custom_sql;
        }
        else {
            $sql = "
                SELECT 
                {$join_key},
                {$join_name}
				FROM {$table_name}
				WHERE 
				LOWER({$join_name}) LIKE LOWER(" . $CI->db->escape('%' . $query . '%') . ")
                $limit";
        }

        $res = $CI->db->query($sql)->result_array();

        return $res;
    }

    public function autocomplete_specified_search($table_name, $join_key, $join_name, $join_table, $join_table_field, $join_table_key, $join_key_for_join_table, $adv_field, $adv_field_unix, $limit = '')
    {
        $CI =& get_instance();

        // LIMIT
        if($limit == '') $limit = '';
        else $limit = ' LIMIT ' . $limit;

            $sql = "
                SELECT 
                " . $table_name . '.' . $join_key .",
                " . $table_name . '.' . $join_name .",
                " . $table_name . '.' . $adv_field .",
                FROM_UNIXTIME(" . $table_name . '.' . $adv_field_unix .") as {$adv_field_unix},
                " . $join_table . '.' . $join_table_field ." 
				FROM {$table_name}
				LEFT JOIN $join_table ON " . $join_table . '.' . $join_table_key ."  = " . $table_name . '.' . $join_key_for_join_table ." 
				WHERE 
				LOWER({$join_name}) LIKE LOWER(" . $CI->db->escape('%' . $CI->input->get('q') . '%') . ")
                $limit";

        $res = $CI->db->query($sql)->result_array();

        /*//============status: from id to name
        if (include('application/config/pdg_tables/' . $table_name . '.php')) {
            $statuses = array();
            if (isset($table_config['status_rel_name'])) {
                foreach ($adv_rel_inputs as $item) {
                    if ($item['name'] == $table_config['status_rel_name']) {
                        if ($item['status_id_field'] == $adv_field) {
                            $statuses = $item['status_options'];
                            break;
                        }
                    }
                }
                foreach ($res as &$result_arr) {
                    foreach ($statuses as $status) {
                        if ($result_arr[$adv_field] == $status['status_id'])
                            $result_arr[$adv_field] = $status['name'];
                    }
                }
            }
            unset($result_arr);
            unset($statuses);
        }
        //============status: from id to name*/
        //============status: from id to name
        if (include('application/config/pdg_tables/' . $table_name . '.php')) {
            $statuses = array();
            $arr = array();
            // if status system
            if (isset($table_config['status_rel_name'])) {
                foreach ($adv_rel_inputs as $item) {
                    if ($item['name'] == $table_config['status_rel_name']) {
                        if ($item['status_id_field'] == $adv_field) {
                            $statuses = $item['status_options'];
                            break;
                        }
                    }
                }
                foreach ($res as &$result_arr) {
                    foreach ($statuses as $status) {
                        if ($result_arr[$adv_field] == $status['status_id'])
                            $result_arr[$adv_field] = $status['name'];
                    }
                }
            } else { // if inputs
                foreach ($table_columns as $item) {
                    if ($item['name'] == $adv_field) {
                        if ($item['input_type'] == 'select') {
                            $arr = $item['variants'];
                        }
                    }
                }
                foreach ($res as &$result_arr) {
                    foreach ($arr as $value) {
                        if ($result_arr[$adv_field] == $value['id'])
                            $result_arr[$adv_field] = $value['name'];
                    }
                }
            }

            unset($result_arr);
            unset($arr);
            unset($statuses);
        }
        //============status: from id to name

        return $res;
    }

    public function autocomplete_specified_table($table_name, $join_key, $join_name, $adv_field, $adv_field_2, $adv_field_unix, $limit = '')
    {
        $CI =& get_instance();

        // LIMIT
        if($limit == '') $limit = '';
        else $limit = ' LIMIT ' . $limit;

        $sql = "
                SELECT 
                {$join_key},
                {$join_name},
                {$adv_field},
                {$adv_field_2},
                FROM_UNIXTIME({$adv_field_unix}) as {$adv_field_unix}
				FROM {$table_name}
				WHERE 
				LOWER({$join_name}) LIKE LOWER(" . $CI->db->escape('%' . $CI->input->get('q') . '%') . ")
                $limit";

        $res = $CI->db->query($sql)->result_array();

        //============status: from id to name
        if (include('application/config/pdg_tables/' . $table_name . '.php')) {
            $variants_1 = array();
            $variants_2 = array();
            $statuses = array();

            // if status system
            if (isset($table_config['status_rel_name'])) {
                foreach ($adv_rel_inputs as $item) {
                    if ($item['name'] == $table_config['status_rel_name']) {
                        if ($item['status_id_field'] == $adv_field) {
                            $statuses = $item['status_options'];
                            break;
                        }
                    }
                }
                foreach ($res as &$result_arr) {
                    foreach ($statuses as $status) {
                        if ($result_arr[$adv_field] == $status['status_id'])
                            $result_arr[$adv_field] = $status['name'];
                    }
                }
            }
            //if inputs
            foreach ($table_columns as $item) {
                if ($item['name'] == $adv_field) {
                    if ($item['input_type'] == 'select') {
                        $variants_1 = $item['variants'];
                    }
                }
                if ($item['name'] == $adv_field_2) {
                    if ($item['input_type'] == 'select') {
                        $variants_2 = $item['variants'];
                        break;
                    }
                }
            }
            foreach ($res as &$result_arr) {
                foreach ($variants_1 as $value_1) {
                    if ($result_arr[$adv_field] == $value_1['id'])
                        $result_arr[$adv_field] = $value_1['name'];
                }
                foreach ($variants_2 as $value_2) {
                    if ($result_arr[$adv_field_2] == $value_2['id'])
                        $result_arr[$adv_field_2] = $value_2['name'];
                }
            }
            unset($result_arr);
            unset($statuses);
            unset($variants_1);
            unset($variants_2);
            unset($value_1);
            unset($value_2);
        }
        //============status: from id to name

        return $res;
    }

    public function check_access($module_name, $type)
    {

        $CI =& get_instance();
        $user_id = $CI->ion_auth->get_user_id();

        $type_clear = '';
        if ($type == 'init') $type_clear = 'init';
        if ($type == 'view') $type_clear = 'view';
        if ($type == 'edit') $type_clear = 'edit';
        $sql = "
            SELECT
            	top_menu_url as url

				FROM inside_top_menu

				LEFT JOIN groups_access ON groups_access.module_id = top_menu_id
				LEFT JOIN users_groups ON users_groups.group_id = groups_access.group_id

				WHERE

				users_groups.user_id = " . intval($user_id) . "

				AND module_" . $type_clear . " = 1

				AND top_menu_module_name = " . $CI->db->escape($module_name) . "

				GROUP BY top_menu_id

				ORDER BY inside_top_menu.top_menu_name

        ";
        $res = $CI->db->query($sql)->result_array();

        // print_r($module_name);

        if (isset($res[0]) OR $CI->ion_auth->is_admin()) return true;
        else {
            echo "Access Denied!";
            die();
        }
    }

    public function random_password()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function attr_text($text)
    {

        $text = str_replace("\n", " ", strip_tags($text));
        $text = str_replace("\"", " ", $text);
        return $text;
    }

    public function ru2en_img($string)
    {
        $string = (string)$string; // преобразуем в строковое значение
        //$string = strip_tags($string); // убираем HTML-теги
        //$string = str_replace(array("\n", "\r"), " ", $string); // убираем перевод каретки
        $string = preg_replace("/\s+/", ' ', $string); // удаляем повторяющие пробелы
        $string = trim($string); // убираем пробелы в начале и конце строки
        $string = function_exists('mb_strtolower') ? mb_strtolower($string) : strtolower($string); // переводим строку в нижний регистр (иногда надо задать локаль)
        $string = strtr($string, array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'j',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ы' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ъ' => '',
            'ь' => ''
        ));
        //$string = preg_replace("/[^0-9a-z-_ ]/i", "", $string); // очищаем строку от недопустимых символов
        $string = str_replace(" ", "_", $string); // заменяем пробелы знаком минус
        return $string; // возвращаем результат
    }

    public function set_history_objects($object_id)
    {

        $CI =& get_instance();
        // History
        if ($CI->ion_auth->logged_in()) {
            $object_id = intval($object_id);
            $objects = array();

            if (isset($_COOKIE["user_{$CI->ion_auth->get_user_id()}"])) {
                $objects = json_decode($_COOKIE["user_{$CI->ion_auth->get_user_id()}"]);
            }

            if (!in_array($object_id, $objects)) {
                $objects[] = $object_id;
            }

            setcookie("user_{$CI->ion_auth->get_user_id()}", json_encode($objects), time() + 3600, '/');
        }
    }

    /*public function get_history_objects_ids()
    {
        $CI =& get_instance();
        // История
        if (isset($_COOKIE["user_{$CI->ion_auth->get_user_id()}"])) {
            $ids = json_decode($_COOKIE["user_{$CI->ion_auth->get_user_id()}"]);
            return $ids = implode(',', $ids);
        }
        return false;
    }*/

    public function get_history_objects()
    {
        $CI =& get_instance();

        if ($CI->ion_auth->logged_in()) {
            if (isset($_COOKIE["user_{$CI->ion_auth->get_user_id()}"])) {
                $ids = implode(',', json_decode($_COOKIE["user_{$CI->ion_auth->get_user_id()}"]));
                return $CI->db->query("
                SELECT id, main_img, offer_type, price, price_rent, square, h1 
                FROM realty_base 
                WHERE id IN ({$ids}) 
                ORDER BY id ASC
                ")->result_array();
            }
        }
        return null;
    }

    public function set_favorites_objects($object_id)
    {
        $CI =& get_instance();
        if ($CI->ion_auth->logged_in()) {
            $object_id = intval($object_id);
            $data = array('user_id' => $CI->ion_auth->get_user_id(), 'object_id' => $object_id);
            $CI->db->insert('users_favorites', $data);
        }
    }

    public function delete_favorites_objects($favorite_row_id)
    {
        $CI =& get_instance();
        if ($CI->ion_auth->logged_in()) {
            $favorite_row_id = intval($favorite_row_id);
            $CI->db->where('id', $favorite_row_id);
            $CI->db->delete('users_favorites');
            redirect('/auth/profile');
        }
    }

    public function get_favorites_objects()
    {
        $CI =& get_instance();
        if ($CI->ion_auth->logged_in()) {
            return $CI->db->query("
            SELECT users_favorites.id, users_favorites.object_id, realty_base.main_img, 
            realty_base.offer_type, realty_base.price, realty_base.price_rent, realty_base.square, realty_base.h1 
            FROM users_favorites 
            LEFT JOIN realty_base ON users_favorites.object_id = realty_base.id 
            WHERE users_favorites.user_id = {$CI->ion_auth->get_user_id()} 
            ORDER BY users_favorites.id DESC
            ")->result_array();
        }
        return null;
    }

    public function recount_by_currency(&$data, $fields)
    {
        $CI =& get_instance();
        $currency_alias = get_cookie('currency');
        $rate = $CI->db->query("SELECT currency_rate FROM currencies WHERE alias='{$currency_alias}'")->row_array();

        foreach ($data as $fields_1 => &$value_1) {
            if(is_array($value_1)){
                foreach ($value_1 as $fields_2 => &$value_2) {
                    if (in_array($fields_2, $fields)) {
                        $value_2 =  round($value_2/$rate['currency_rate'], 2);
                    }
                }
            } else {
                if (in_array($fields_1, $fields)) {
                    $value_1 = round($value_1/$rate['currency_rate'], 2);
                }
            }
        }

        if(isset($value_2)) unset($value_1, $value_2);
        else unset($value_1);
    }

    public function get_currency_rate() {
        $CI =& get_instance();

        $currency_alias = get_cookie('currency') ? get_cookie('currency') : 'uah';
        $rate = $CI->db->query("SELECT currency_rate FROM currencies WHERE alias='{$currency_alias}'")->row_array();
        return $rate['currency_rate'];
    }
}
