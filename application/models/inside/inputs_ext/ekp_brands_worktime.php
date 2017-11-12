<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ekp_Brands_WorkTime {


	public function input_form ($input_array)
	{
				
		$CI =& get_instance();
		if ($input_array['make_type'] == 'edit')
		{			 
			ob_start();
?>
	
		<script>
			$(function() {
				var input_week_time_map_auto_start;
				var input_week_time_map_auto_end;
				
				$(".input_week_time_map input").on("mousedown", function() {
					input_week_time_map_auto_start = parseInt($(this).attr('count'));
				});
				
				$(".input_week_time_map input").on("mouseup", function(e) {
					input_week_time_map_auto_end = parseInt($(this).attr('count'));
					$(this).parent().parent().children("td").each(function() {
						if ( (parseInt($(this).children("input").attr('count')) >= input_week_time_map_auto_start) && (parseInt($(this).children("input").attr('count')) <= input_week_time_map_auto_end) )
						{
							if (e.which > 1)
							{
							$(this).children("input").prop('checked', false);
							}
							else
							$(this).children("input").prop('checked', true);
						}

					});
				});
				
			});
		</script>
		<style>
		.input_week_time_map td{padding: 2px}
		.input_week_time_map td{text-align:center;}
		</style>

<?php		
		$timemap_arr = unserialize($input_array['cell_row']['brands_timemap']);
		
		// Array Type: $timemap_arr['mon']['1'] = true;
		echo '<table class="input_week_time_map table table-bordered"><tr><td></td>';
		for ($i=0; $i<24; $i++) {echo "<td>".$i."</td>";}		
		
		echo "</tr><tr><td>Monday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['mon'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="mon-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Tuesday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['tue'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="tue-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Wednesday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['wed'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="wed-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Thursday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['thu'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="thu-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Friday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['fri'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="fri-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Saturday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['sat'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="sat-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}
		
		echo "</tr><tr><td>Sunday:</td>";
		for ($i=0; $i<24; $i++) {$ch=''; if (isset($timemap_arr['sun'][$i])) $ch=' CHECKED'; echo '<td><input type="checkbox" value="sun-'.$i.'" count="'.$i.'" name="brands_timemap[]"'.$ch.' /></td>';}

		echo '</tr></table>';
?>

		<input type="checkbox" value="1" name="brands_closed_on_last_hour" style="margin: 0;"<?php if ($input_array['cell_row']['brands_closed_on_last_hour'] == 1) echo " CHECKED";?> />
		Не принимает заказы последний час работы
		<br /><br />
		<a class="btn" OnClick="$(this).next().slideDown('slow');$(this).slideUp('fast');">Установить интервалы времени</a>
		<table style="display:none;">
		<tr><td>Время работы (пн-пт)</td><td align="left">
		с 
		<?=$this->_worktime_select('brands_wworktimestart', $input_array['cell_row']['brands_wworktimestart'])?> 
		по 
		<?=$this->_worktime_select('brands_wworktimeend', $input_array['cell_row']['brands_wworktimeend'])?>
		</td>
		</tr>
		<tr>
		<td>Время работы (сб-вс)</td><td align="left">
		с 
		<?=$this->_worktime_select('brands_hworktimestart', $input_array['cell_row']['brands_hworktimestart'])?> 
		по 
		<?=$this->_worktime_select('brands_hworktimeend', $input_array['cell_row']['brands_hworktimeend'])?>
		</td>
		</tr>
		<tr><td>Время работы (пн-пт)</td><td align="left">
		с 
		<?=$this->_worktime_select('brands_wordertimestart', $input_array['cell_row']['brands_wordertimestart'])?> 
		по 
		<?=$this->_worktime_select('brands_wordertimeend', $input_array['cell_row']['brands_wordertimeend'])?>
		</td>
		</tr>
		<tr>
		<td>Время работы (сб-вс)</td><td align="left">
		с 
		<?=$this->_worktime_select('brands_hordertimestart', $input_array['cell_row']['brands_hordertimestart'])?> 
		по 
		<?=$this->_worktime_select('brands_hordertimeend', $input_array['cell_row']['brands_hordertimeend'])?>
		</td>
		</tr>
		</table>
<?php		
			$data = ob_get_clean();
			return $data;
		}
		else return "This Data can change only in Edit!";
	}
	public function db_save($input_array)
	{
		$CI =& get_instance();
		
		$array['brands_wworktimestart'] = intval($_POST['brands_wworktimestart']);
		$array['brands_wworktimeend'] = intval($_POST['brands_wworktimeend']);
		$array['brands_hworktimestart'] = intval($_POST['brands_hworktimestart']);
		$array['brands_hworktimeend'] = intval($_POST['brands_hworktimeend']);
		$array['brands_wordertimestart'] = intval($_POST['brands_wordertimestart']);
		$array['brands_wordertimeend'] = intval($_POST['brands_wordertimeend']);
		$array['brands_hordertimestart'] = intval($_POST['brands_hordertimestart']);
		$array['brands_hordertimeend'] = intval($_POST['brands_hordertimeend']);
		if (isset($_POST['brands_closed_on_last_hour'])) $array['brands_closed_on_last_hour'] = 1;
		else $array['brands_closed_on_last_hour'] = 0;
		
		$brands_timemap_arr = Array();
		if (isset($_POST['brands_timemap']) && is_array($_POST['brands_timemap']))
			{
				foreach ($_POST['brands_timemap'] as $work_hour)
				{
				$pieces = explode("-", $work_hour);
				$day = $CI->inside_lib->defend_filter('4', $pieces[0]);
				$hour = intval ($pieces[1]);
				$brands_timemap_arr[$day][$hour] = true;
				}
			}
				
		$array['brands_timemap'] = serialize($brands_timemap_arr);		
		// print_r ($brands_timemap_arr);		
		return $array;
	}
	
	protected function _worktime_select($name, $value)
	{
		ob_start();
?>
		<select name="<?=$name?>">
			<?php 
			for ($i=0;$i<24;$i++) { 
			$selected = '';
			if ($value == $i) $selected = " selected"; 
			?>
			<option value="<?=$i?>"<?=$selected?>><?=$i?>:00</option>
			<?php 
			}
			$selected = '';
			if ($value == "-1") $selected = " selected"; 

			?>
			<option value="-1"<?=$selected?>>До последнего клиента</option>
		</select>

<?php		
		return ob_get_clean();
	}

}

?>
	