<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_file {


    public function input_form($input_array)
    {
        if ($input_array['make_type'] == 'copy') $input_array['value'] = '';
        return $this->input_file_pdf ($input_array['name'], $input_array['value'],$input_array['folder']);
    }

    // OLD Stable Function
    public function input_file_pdf($name, $row_pdf = NULL, $pdf_folder = NULL){
        $data='';
        if (isset($row_pdf)&&($row_pdf != ""))
        {  	if (isset($pdf_folder)) $link_folder = $pdf_folder."/";

            if ($row_pdf == "error_file") $data .= "<font color=\"darkred\">pdf/".$link_folder.$row_pdf."</font>";
            else $data .= "<a href=\"/files/uploads/".$link_folder.$row_pdf."\" target=\"_blank\">files/pdf/".$link_folder.$row_pdf."</a>";
            $data .= "
			<input name=\"del_pdf_".$name."\" type=\"checkbox\" value=\"1\">Del?
			<input name=\"".$name."\" type=\"hidden\" value=\"".$row_pdf."\">
			";

            if (isset($pdf_folder)) $data .= "<input name=\"".$name."_folder\" type=\"hidden\" value=\"".$pdf_folder."\">";
        }
        else
        {  	$data = "
		<input type=\"file\" name=\"".$name."\" id=\"".$name."\" class=\"input\" style=\"width:350px;\" value=\"".$row_pdf."\">
		";
            if (isset($pdf_folder)) $data .= "<input name=\"".$name."_folder\" type=\"hidden\" value=\"".$pdf_folder."\">";
        }
        return $data;
    }
    public function db_save($input_array)
    {
        $CI =& get_instance();
        $tmp_name = $input_array['name'];

        // echo $_FILES[$tmp_name]['name'];

        // Check folder change
        if (isset ($input_array['folder'])) $folder = $input_array['folder']."/";
        else $folder = "";
        // Update File System!
        if (isset($_POST['del_pdf_'.$tmp_name]))
        {
            $CI->inside_lib->c7_delete_image($_POST[$tmp_name], $folder);
            return '';
        }
        else if (isset($_FILES[$tmp_name]['name']))
        {
            $_FILES[$tmp_name]['name'] = $CI->inside_lib->C7_fs_file_upload ($_FILES[$tmp_name]['tmp_name'], $_FILES[$tmp_name]['name'], "/files/uploads/".$folder);

            return $_FILES[$tmp_name]['name'];

        }
        else return $input_array['value'];
    }

}

?>
