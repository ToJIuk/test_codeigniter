<?php

foreach ($menu_arr as $row)
{
// No Shift - is row, Shift is open/close parents ul tags
if (!isset($row['shift']))
	{
	// Link or Static block
	if ($row['url'] != '') $text = '<a href="'.$row['url'].'" title="'.$row['name'].'">'.$row['name'].'</a>';
	else $text = $row['name'];
	$span_class = ($row['haschild'] > 0)  ?  ' class="submenu_toggle"'  :  '';

	$li_style='';
	if ($row['row']['top_menu_icon_url']) {
		if ($row['row']['top_menu_icon_url'] == $_SERVER['REQUEST_URI'])
		$li_style = ' class="hover"';
	}
	echo '<li'.$li_style.'>';
	if ($row['row']['top_menu_icon']) {
		echo '<a href="'.$row['row']['top_menu_icon_url'].'" class="icon_link"><i class="'.$row['row']['top_menu_icon'].'"></i></a>&nbsp;';
	}
	echo '';
	echo '<span'.$span_class.'>'.$text.'</span>';
	if ($row['haschild'] != 1) echo "</li>";
	else echo '<i class="fa fa-angle-down pull-right submenu_icon"></i></li>';
	}
else
	{
	if ($row['action'] == "open")
		{
		// Add Childs Width Style
		if ( (isset($tmp_width_child)) && ($tmp_width_child > 0) ) $width_child = "width: ".$tmp_width_child."px;";
		else $width_child = "";

		echo "\n".'<ul class="submenu">'."\n";
		$tmp_width_child = '';
		}
	if ($row['action'] == "close") echo "\n</ul></li>\n";
	}
}