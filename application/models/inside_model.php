<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of inside_model
 *
 * @author Alex Torrison
 */
class Inside_Model extends CI_Model
{

    var $user;

    public function __construct() {

        parent::__construct();

        $ci =& get_instance();
        $ci->load->library('ion_auth');
        if ($this->ion_auth->logged_in())
        {
            $this->user = $this->ion_auth->user()->row();
        }
        else $this->user = false;


    }
    // generate word document
    public function generate_docx($id)
    {
        require 'vendor/autoload.php';

        $query = $this->db->get_where('it_mytest', array('id' => $id));
        $data = $query->row_array();

        // работа с php Word
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $document = new \PhpOffice\PhpWord\TemplateProcessor('files/arr_docs_templates/template.docx');
        $document->setValue(['doc_number', 'company_name', 'client_name'], [$data['doc_number'], $data['company_name'], $data['client_name']]);
        $document->saveAs('files/arr_docs_generated/'.$data['id'].'_doc_gen.docx');
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' .$data['id'].'_doc_gen.docx' . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        /*    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter('files/arr_docs_generated/'.$data['id'].'_doc_gen.docx', 'Word2007');
            $xmlWriter->save("php://output");*/
        $PHPWord = \PhpOffice\PhpWord\IOFactory::load('files/arr_docs_generated/'.$data['id'].'_doc_gen.docx'); // Read the temp file
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($PHPWord);
        $xmlWriter->save("php://output");

    }

	// NEW For Tabs and Columns Filters
	public function generate_top_filters2 ($table_name)
	{
		if (@include ('application/config/pdg_tables/'.$table_name.'.php'))
		{
			$filters = '';
			// Make Filters
			$filters = Array();
			foreach ($table_columns as $config_row) {
				if (isset ($config_row['filter'])) {

					if (isset($config_row['default_filter_value']))
						$config_row['value'] = $config_row['default_filter_value'];
					else $config_row['value'] = '';

					if (isset($_GET[$config_row['name']]))
						$config_row['value'] = $this->input->get($config_row['name'], true);

					if (isset($config_row['input_type']))
					{
						if (!isset($config_row['filters_tab'])) $config_row['filters_tab'] = 'Main';
						if (!isset($config_row['filters_column'])) $config_row['filters_column'] = 1;
						$filters[] = Array(
							'text' => $config_row['text'],
							'input' => $this->inside_lib->make_input("input_filter", $config_row),
							'filters_tab' => $config_row['filters_tab'],
							'filters_column' => $config_row['filters_column'],
						);
					}

				}
			}
			return $filters;
		}
		else return false;
	}

	public function generate_top_filters ($table_name)
	{
			if (@include ('application/config/pdg_tables/'.$table_name.'.php'))	
			{				
				$filters = '';
				// Make Filters			
				$filters = '';
				foreach ($table_columns as $config_row) {		
				if (isset ($config_row['filter'])) {						
						
						if (isset($config_row['default_filter_value'])) 
							$config_row['value'] = $config_row['default_filter_value'];
						else $config_row['value'] = '';
						
						if (isset($_GET[$config_row['name']]))
							$config_row['value'] = $this->input->get($config_row['name'], true);
						
							if (isset($config_row['input_type']))
						
						$filters .= $config_row['text'].": ".$this->inside_lib->make_input("input_filter", $config_row)." ";
					}				
				}
				return $filters;
			}
			else return false;			
	}
	
//>>// Function for Get table Data from DB -------------------------------------  SELECT * by filter ----------------
	public function get_table_arr($table_name, $filter)
	{

	// Load lib
	$this->load->library('inside_lib');
	// Load Config
	include ('application/config/pdg_tables/'.$table_name.'.php');

	// Add Special vars
	$order = " ORDER BY `".$table_config['key']."` DESC";
	$where = '';
	$where_filter = '';
	$limit = ' ';
	$asc = 'ASC';	
	$columns = '';
	$join_columns = '';
	$join = '';
	
	
	// Prepare Where Filter: Form Filter + Multi Search
	foreach ($table_columns as $config_row) {
	
		if (isset ($config_row['in_crud'])) $columns .= $table_name . '.' . $config_row['name'].", "; //was ambiguous - add table_name
		if (isset ($config_row['in_crud']))	
		{
			if (isset ($config_row['filter'])) 
			{
				$tmp_name = $config_row['name'];
								
				$_POST[$tmp_name] = $this->inside_lib->defend_filter(4, @$_POST[$tmp_name]);
				if (strlen($_POST[$tmp_name]) > 0)
                    $where_filter .= " AND " . $table_name . '.' . $config_row['name']." = '".$_POST[$tmp_name]."'"; //here also was ambiguous

			}
			else 
			{
				if ( (isset($filter['fsearch'])) && (strlen($filter['fsearch']) > 1) )
				$where .= " ". $table_name . '.' . $config_row['name']." like '%".$filter['fsearch']."%' OR"; // here also was ambiguous
				
				if ( (isset($filter['fkey'])) && (intval($filter['fkey']) > 0) )
				$where .= " ". $table_name . '.' .  $table_config['key']." = '".$filter['fkey']."' OR"; //here also was ambiguous
			}
		}
	
	}
	$columns = substr($columns, 0, -2);
	$where = substr($where, 0, -3);
	
	// Prepare Order parametrs
	if ( (isset($filter['asc'])) && (strlen($filter['asc']) > 1) ) $asc = $filter['asc'];
	if ( (isset($filter['order'])) && (strlen($filter['order']) > 1) )  $order = " ORDER BY `".$filter['order']."` ".$asc;
	
	// Prepare Limit and Page parametrs
	if ( (isset($filter['page'])) && ($filter['page'] > 0) ) $filter['page']--;	
	if ( (isset($filter['limit'])) && ($filter['limit'] > 0) ) $limit = " LIMIT ".intval($filter['page'])*intval($filter['limit']).",".intval($filter['limit']);
	
	// Add Where to request
	if (strlen($where) > 2) $where = ' WHERE 1 '.$where_filter.' AND ('.$where.') ';
	else $where = ' WHERE 1 '.$where_filter.' ';

	// Make Join Columns
	if (isset ($table_join)) 
	{
		foreach ($table_join as $join_arr) {

			$join_columns_this_table = '';
			foreach ($table_columns as $config_row) {
			if ( (isset ($config_row['join'])) && ($config_row['join'] == $join_arr['table']))
				{

				// adv_columns
				$join_columns .= ", ".$join_arr['table'].".".$config_row['join_column']." ".$config_row['join_as'];
				//$join_columns_this_table .= $config_row['join_column'].", ";
				}
			}
			// join_sql
			//$join_columns_this_table = substr($join_columns_this_table, 0, -2);
			$join .= " LEFT JOIN ".$join_arr['table']." ON ".$table_name.".".$join_arr['table_key']." = ".$join_arr['table'].".".$join_arr['join_key']." ";

		}
	}


	if (isset($table_config['join_sql'])) {
		$join .= $table_config['join_sql'];
	}

	if (isset($table_config['adv_columns'])) {
		$join_columns .= ', ' . $table_config['adv_columns'];
	}


	// ================ Status filter ======================
    if (isset($table_config['status_rel_name'])) {

        foreach ($adv_rel_inputs as $rel_row) {
            if ($rel_row['name'] == $table_config['status_rel_name']) {
                $status_config = $rel_row;
            }
        }

        $where .= " AND ( FALSE ";
        if(isset($_POST['status_filter'])) {
            foreach ($_POST['status_filter'] as $status) {
                $where .= " OR " . $table_name . '.' . $status_config['status_id_field'] . " = " . intval($status) . ""; //here also was ambiguous
            }
        } else {
            foreach ($status_config['status_options'] as $status) {
                if(isset($status['default_filter']) && $status['default_filter']) {
                    $where .= " OR " . $table_name . '.' . $status_config['status_id_field'] . " = " . intval($status['status_id']) . ""; //here also was ambiguous
                }
            }
        }
        $where .= " ) ";
    }
    // ================ Status filter =======================



	// Make Request
	$query_sql = 'SELECT '.$columns.$join_columns.' FROM '.$table_name.$join.$where.$order.$limit;
	$query = $this->db->query($query_sql);	
	$return['res'] = $query->result_array();
	$return['sql'] = $query_sql;
	return $return;
	
	}
	
//>>// Function for Get TREE Data from DB -------------------------------------  SELECT * by filter ----------------
	public function get_tree_arr($table_name, $filter, $pid)
	{
	// Load lib
	$this->load->library('inside_lib');
	// Load Config
	include ('application/config/pdg_tables/'.$table_name.'.php');

	// Add Special vars
	$order = " ORDER BY ".$table_config['key']." DESC";
	$where = '';
	$where_filter = '';
	$limit = ' ';
	$asc = 'ASC';	
	$columns = '';
	$join_columns = '';
	$join = '';
	
	
	// Prepare Where Filter: Form Filter + Multi Search
	foreach ($table_columns as $config_row) {
	
		if (isset ($config_row['in_crud'])) $columns .= $config_row['name'].", "; 	
		if (isset ($config_row['in_crud']))	
		{
			if (isset ($config_row['filter'])) 
			{
				$tmp_name = $config_row['name'];
								
				$_POST[$tmp_name] = $this->inside_lib->defend_filter(4, $_POST[$tmp_name]);
				if (strlen($_POST[$tmp_name]) > 0)
				$where_filter .= " AND ".$config_row['name']." = '".$_POST[$tmp_name]."'"; 
			}
			else 
			{
				if ( (isset($filter['fsearch'])) && (strlen($filter['fsearch']) > 1) )
				$where .= " ".$config_row['name']." like '%".$filter['fsearch']."%' OR";
			}
		}
	
	}
	$columns = substr($columns, 0, -2);
	$where = substr($where, 0, -3);
	
	// Prepare Order parametrs
	if ( (isset($filter['asc'])) && (strlen($filter['asc']) > 1) ) $asc = $filter['asc'];
	if ( (isset($filter['order'])) && (strlen($filter['order']) > 1) )  $order = " ORDER BY ".mysql_real_escape_string($filter['order'])." ".$asc;
	
	// Prepare Limit and Page parametrs
	if ( (isset($filter['page'])) && ($filter['page'] > 0) ) $filter['page']--;	
	if ( (isset($filter['limit'])) && ($filter['limit'] > 0) ) $limit = " LIMIT ".intval($filter['page'])*intval($filter['limit']).",".intval($filter['limit']);
	
	// Add Where to request
	if (strlen($where) > 2) $where = ' WHERE parent_id = '.$pid.' '.$where_filter.' AND ('.$where.') ';
	else $where = ' WHERE parent_id = '.$pid.' '.$where_filter.' ';
	
	
	// Make Join Columns
	if (isset ($table_join)) 
	{
		foreach ($table_join as $join_arr) {

			$join_columns_this_table = '';
			foreach ($table_columns as $config_row) {
			if ( (isset ($config_row['join'])) && ($config_row['join'] == $join_arr['table']))
				{
				$join_columns .= ", ".$join_arr['table'].".".$config_row['join_column']." ".$config_row['join_as'];
				//$join_columns_this_table .= $config_row['join_column'].", ";
				}
			}
			//$join_columns_this_table = substr($join_columns_this_table, 0, -2);
			$join .= " LEFT JOIN ".$join_arr['table']." ON ".$table_name.".".$join_arr['table_key']." = ".$join_arr['table'].".".$join_arr['join_key']." ";
		}
	}
	
	// Make Request
	$query_sql = 'SELECT '.$columns.$join_columns.' FROM '.$table_name.$join.$where.$order.$limit;
	$query = $this->db->query($query_sql);	
	$return['res'] = $query->result_array();
	$return['sql'] = $query_sql;
	return $return;
	
	}	
	
//>>// Function for Get table Cell from DB -------------------------------------  SELECT 1 row by ID ------
	public function get_table_cell_arr($table_name, $cell_id)
	{
		// Load Config
		include ('application/config/pdg_tables/'.$table_name.'.php');
		
		// Make Request
		$query = $this->db->query("SELECT * FROM ".$table_name." WHERE ".$table_config['key']." = ".intval($cell_id)." LIMIT 1");
		$array = $query->result_array();
		// Return One Row!
		return $array[0];
	}
//>>// Save Updates in Cell Tab  ----------------------------------------  UPDATE fields by ID ------
	public function update_table_cell($table_name, $tab, $cell_id)
	{
		// Load Config
		include ('application/config/pdg_tables/'.$table_name.'.php');

		// Make Update Array by Input Fields
		$update_array = Array();

        if(!isset($_POST['not_update_table_columns'])) {
            foreach ($table_columns as $config_row) {
                if ((isset($config_row['tab'])) && ($config_row['tab'] == $tab)) {
                    $tmp_name = $config_row['name'];

                    if (!isset ($config_row['defend_filter'])) $config_row['defend_filter'] = 1;
                    $config_row['value'] = $this->inside_lib->defend_filter(intval($config_row['defend_filter']), @$_POST[@$tmp_name]);

                    $config_row['cell_id'] = $cell_id;
                    $config_row['tab'] = $tab;
                    $config_row['table'] = $table_name;
                    $config_row['post_array'] = $_POST;
                    $config_row['save_type'] = 'update';

                    $save_value = $this->inside_lib->make_input('db_save', $config_row);

                    if (!(is_bool($save_value) && !$save_value)) {
                        if (is_array($save_value)) {
                            foreach ($save_value as $key => $value) $update_array[$key] = $value;
                        } else $update_array[$tmp_name] = $save_value;
                    }

                    //============== Fix for activities =================
                    if (isset($config_row['text'])) {
                        $update_array_names[$tmp_name] = $config_row['text'];
                    }
                    //===================================================
                }
            }
        }


		// ============== Fix for activities =================
		if (isset($adv_rel_inputs))
		{
			foreach ($adv_rel_inputs as $rel_input_arr) {
                    $rel_input_arr['base_table'] = $table_name;
                    $rel_input_arr['update'] = $update_array;
                    $rel_input_arr['names'] = isset($update_array_names) ? $update_array_names: null;
                    $this->inside_lib->make_rel_input("pre_db_save", $rel_input_arr, $cell_id);
			}
		}
        // ===================================================

		$this->db->where($table_config['key'], $cell_id);
		if (count ($update_array) > 0)
		$this->db->update($table_name, $update_array);

        $this->db->insert('inside_log', Array('log_table' => $table_name, 'log_datetime' => time(), 'log_sql' => $this->db->last_query(), 'log_user_id' => $this->user->id));

		if (isset($adv_rel_inputs))
		{
			foreach ($adv_rel_inputs as $rel_input_arr) {
				if ($rel_input_arr['tab'] == $tab) {
                    $rel_input_arr['base_table'] = $table_name;
					$this->inside_lib->make_rel_input("db_save", $rel_input_arr, $cell_id);	
				}
			}
		}
		return "Ok!";
	}


	public function insert_table_cell($table_name)
	{
		// Load Config
		include ('application/config/pdg_tables/'.$table_name.'.php');

		// Make Update Array by Input Fields
		$insert_array = Array();
		foreach ($table_columns as $config_row) {
			$tmp_name = $config_row['name'];
			
			if (!isset ($config_row['defend_filter'])) $config_row['defend_filter'] = 1;
			$config_row['value'] = $this->inside_lib->defend_filter(intval($config_row['defend_filter']), @$_POST[$tmp_name]);
			
			$config_row['table'] = $table_name;
			$config_row['post_array'] = $_POST;
			$config_row['save_type'] = 'insert';
			
			$save_value = $this->inside_lib->make_input('db_save', $config_row);		
			if (! (is_bool($save_value) && !$save_value)) 
			{
				if (is_array($save_value))
				{
					foreach ($save_value as $key => $value) $insert_array[$key] = $value;
				}
				else $insert_array[$tmp_name] = $save_value;
			}		
		}
		
		if (count ($insert_array) > 0)
		$this->db->insert($table_name, $insert_array);

        $cell_id = $this->db->insert_id();

        $this->db->insert('inside_log', Array('log_table' => $table_name, 'log_datetime' => time(), 'log_sql' => $this->db->last_query(), 'log_user_id' => $this->user->id));

		//$cell_id = $this->db->insert_id();

		if (isset($adv_rel_inputs))
		{
			foreach ($adv_rel_inputs as $rel_input_arr) {
                $rel_input_arr['base_table'] = $table_name;
				$this->inside_lib->make_rel_input("db_add", $rel_input_arr, $cell_id);				
			}
		}
		return "Ok!";
	}

	public function del_table_cell($table_name)
	{
		if (isset($_POST['del_ids'])) 
			{
				// Load Config
				include ('application/config/pdg_tables/'.$table_name.'.php');
				foreach ($_POST['del_ids'] as $del_is)
				{
					echo intval ($del_is);
					$this->db->delete($table_name, array($table_config['key'] => intval($del_is)));
                    $this->db->insert('inside_log', Array('log_table' => $table_name, 'log_datetime' => time(), 'log_sql' => $this->db->last_query(), 'log_user_id' => $this->user->id));
				}
			}
	return "Ok!";
	}

}

/* End of file inside_model.php */
/* Location: ./application/models/inside_model.php */