<?php

// inside_top_menu CONFIG

$i = 0;
$table_columns[$i]['name'] = 'vocabulary_id';
$table_columns[$i]['text'] = 'ID';
$table_columns[$i]['column_width'] = '100';
$table_columns[$i]['in_crud'] = true;
$i++;

$table_columns[$i]['name'] = 'vocabulary_lang';
$table_columns[$i]['text'] = 'Language Alias';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'select_from_table_chosen';

$table_columns[$i]['select_index'] = 'lang_alias';
$table_columns[$i]['select_field'] = 'lang_alias';
$table_columns[$i]['select_table'] = 'wm_lang';
$table_columns[$i]['filter'] = true;
$table_columns[$i]['in_crud'] = true;
$table_columns[$i]['help'] = 'Lang Alias';
$i++;
$table_columns[$i]['name'] = 'vocabulary_name';
$table_columns[$i]['text'] = 'Translate Name';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'textarea';
$table_columns[$i]['column_width'] = '800';
$table_columns[$i]['defend_filter'] = 2;
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'vocabulary_alias';
$table_columns[$i]['text'] = 'String Alias';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['help'] = 'Use in Code';
$table_columns[$i]['in_crud'] = true;

$i++;
$table_columns[$i]['name'] = 'vocabulary_type';
$table_columns[$i]['text'] = 'vocabulary_type';
$table_columns[$i]['tab'] = 'main';
$variants = array();
$variants[0]['id'] = '0';$variants[0]['name']="Not Selected";
$variants[1]['id'] = '1';$variants[1]['name']="Main Template";
$variants[2]['id'] = '2';$variants[2]['name']="Index Page";
$variants[3]['id'] = '3';$variants[3]['name']="Login / User / Profile";
$variants[4]['id'] = '4';$variants[4]['name']="Info Tree System";
$variants[5]['id'] = '5';$variants[5]['name']="JavaScript strings";
$table_columns[$i]['variants'] = $variants;
$table_columns[$i]['input_type'] = 'select';
$table_columns[$i]['in_crud'] = true;
// $table_columns[$i]['filter'] = true;

$table_config['key'] = 'vocabulary_id';

// System names: access = Access System, Chat = Chat communication
$table_config['cell_tabs_arr'] = Array (
	'main' => 'Main',
	'chat' => 'Chat'
);