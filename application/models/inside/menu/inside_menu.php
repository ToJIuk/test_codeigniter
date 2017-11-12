<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Description of inside_model
 *
 * @author Alex Torrison
 */
class Inside_Menu extends CI_Model
{


//>>// Get Inside TOP-Menu Parent_id Array for TreeView ---------------------------------------------------
	public function get_top_menu_arr()
	{
		$user_id = intval($this->session->userdata('user_id'));
		//$query = $this->db->query('SELECT group_id FROM users_groups WHERE user_id');

		// ================================   NEW Access REQUEST   ========================
		$res = $this->db->query("

		  		SELECT

            	inside_top_menu.*

				FROM inside_top_menu

				LEFT JOIN groups_access ON groups_access.module_id = top_menu_id
				LEFT JOIN users_groups ON users_groups.group_id = groups_access.group_id

				WHERE

				users_groups.user_id = ".intval($user_id)."

				AND module_init = 1

				AND top_menu_invisible = 0

				GROUP BY top_menu_id

				ORDER BY top_menu_parent_id, top_menu_priority, top_menu_name ASC

	")->result_array();

		$i=0;
		$tmp_id_arr = Array();

		if ( ! isset($res[0])) return false;

		foreach ($res as $row)
		{
			// SELECT Unique IDs
			if (!in_array($row['top_menu_id'], $tmp_id_arr))
			{
				$tmp_id_arr[] = $row['top_menu_id'];
				$db_array[$i]['id'] = $row['top_menu_id'];
				$db_array[$i]['parent_id'] = $row['top_menu_parent_id'];
				$db_array[$i]['haschild'] = $row['top_menu_haschild'];
				$db_array[$i]['name'] = $row['top_menu_name'];
				$db_array[$i]['url'] = $row['top_menu_url'];
				$db_array[$i]['invisible'] = $row['top_menu_invisible'];
				$db_array[$i]['priority'] = $row['top_menu_priority'];
				$db_array[$i]['width'] = $row['top_menu_width'];
				$db_array[$i]['width_child'] = $row['top_menu_widthchild'];
				$db_array[$i]['row'] = $row;
				$i++;
			}

		}

		// Need Extension: Access System !!! MUST BE FIXED !!!

		// Reset $i
		$i=0;
		// Parent shift (nesting level)
		$parent_shift = 0;
		// Parent elements work array
		$parent_now = array();
		// Start Parent ID
		$parent_now[$parent_shift] = 0;
		// Temporary var for while
		$stop = false;
		while ($stop != true)
		{
			// Filtering by Parent and non-added, where we located now
			if ( (!isset($db_array[$i]['added'])) && ($db_array[$i]['parent_id'] == $parent_now[$parent_shift]) )
			{
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
					$i=0;
				}
				else
				{
					// Save row to output Array
					$ready_arr[] = $db_array[$i];
					// Add Added sign to row
					$db_array[$i]['added'] = true;
				}

			}

			//$ready_arr[] = $db_array[$i];

			$i++;
			// When id-s ended, we must restart  cicle
			if (!isset($db_array[$i]['id']))
			{
				// if we are in the parent, we return to top level
				if ($parent_shift > 0) {$parent_shift--; $i=0;$ready_arr[] = array("shift" => true, "action" => "close");}
				// or ended cicle
				else $stop = true;
			}
		}

		return $ready_arr;
	}
}	