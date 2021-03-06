<?php

// inside_top_menu CONFIG

$i = 0;
$table_columns[$i]['name'] = 'content_id';
$table_columns[$i]['text'] = 'ID';
$table_columns[$i]['column_width'] = '100';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'content_name';
$table_columns[$i]['text'] = 'Content Title';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;
$translate_columns[] = $table_columns[$i];

$i++;
$table_columns[$i]['name'] = 'content_alias';
$table_columns[$i]['text'] = 'URL Alias';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['help'] = 'For SEO URL (optional)';
$table_columns[$i]['in_crud'] = true;

$i++;
$table_columns[$i]['name'] = 'content_create_date';
$table_columns[$i]['text'] = 'Create Date';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'date';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'content_type';
$table_columns[$i]['text'] = 'Type';
$table_columns[$i]['tab'] = 'main';
$variants = array();
  	$variants[0]['id'] = '1';$variants[0]['name']="Blog";
	$variants[1]['id'] = '2';$variants[1]['name']="Landing Page";
$table_columns[$i]['variants'] = $variants;
$table_columns[$i]['input_type'] = 'select';
$table_columns[$i]['in_crud'] = true;

$i++;
$table_columns[$i]['name'] = 'content_order';
$table_columns[$i]['text'] = 'Order Button';
$table_columns[$i]['tab'] = 'rel';
$table_columns[$i]['input_type'] = 'select-checkbox';


$i++;
$table_columns[$i]['name'] = 'content_price';
$table_columns[$i]['text'] = 'Item Price ($)';
$table_columns[$i]['tab'] = 'rel';
$table_columns[$i]['input_type'] = 'text';


$i++;
$table_columns[$i]['name'] = 'content_time';
$table_columns[$i]['text'] = 'Item Time (h)';
$table_columns[$i]['tab'] = 'rel';
$table_columns[$i]['input_type'] = 'text';


$i++;
$table_columns[$i]['name'] = 'content_desc';
$table_columns[$i]['text'] = 'Description';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'html';
$table_columns[$i]['help'] = 'Short text, for preview.';
$table_columns[$i]['defend_filter'] = 2;
$translate_columns[] = $table_columns[$i];

$i++;
$table_columns[$i]['name'] = 'content_html';
$table_columns[$i]['text'] = 'HTML';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'html';
$table_columns[$i]['defend_filter'] = "A";
$translate_columns[] = $table_columns[$i];

$i++;
$table_columns[$i]['name'] = 'content_img';
$table_columns[$i]['text'] = 'Image (Resize to 600x400)';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'image';
$table_columns[$i]['folder'] = 'content_img';
$table_columns[$i]['in_crud'] = true;

$table_columns[$i]['resize'] = true;
$table_columns[$i]['crop_center'] = true;
$table_columns[$i]['new_width'] = 600;
$table_columns[$i]['new_height'] = 400;


$i++;
$table_columns[$i]['name'] = 'content_priority';
$table_columns[$i]['text'] = 'Priority';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;

$i++;
$table_columns[$i]['name'] = 'content_invisible';
$table_columns[$i]['text'] = 'Invisible';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'select-checkbox';
$table_columns[$i]['in_crud'] = true;


$i++;
$table_columns[$i]['name'] = 'content_seo_title';
$table_columns[$i]['text'] = 'SEO Title';
$table_columns[$i]['tab'] = 'seo';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'content_seo_description';
$table_columns[$i]['text'] = 'SEO Description';
$table_columns[$i]['tab'] = 'seo';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'content_seo_keywords';
$table_columns[$i]['text'] = 'SEO KeyWords';
$table_columns[$i]['tab'] = 'seo';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;

$i++;
$table_columns[$i]['name'] = 'content_user_id';
$table_columns[$i]['text'] = 'User Author ID';
$table_columns[$i]['tab'] = 'rel';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;



$table_config['key'] = 'content_id';

// System names: access = Access System, Chat = Chat communication
$table_config['cell_tabs_arr'] = Array (
	'main' => 'Main',
    'seo' => 'SEO',
	'rel' => 'Advanced',
	/* 'opt' => 'Options', */
    'translate' => 'Translate',
    'chat' => 'Chat'
);

$i=0;
$adv_rel_inputs[$i]['name'] = 'rel_content_categories';
$adv_rel_inputs[$i]['input_type'] = 'many2many';
$adv_rel_inputs[$i]['text'] = 'Categories';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['table'] = 'it_categories';
$adv_rel_inputs[$i]['rel_table'] = 'it_rel_content_categories';
$adv_rel_inputs[$i]['this_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_join'] = 'category_id';
$adv_rel_inputs[$i]['join_key'] = 'categories_id';
$adv_rel_inputs[$i]['join_name'] = 'categories_name';
$adv_rel_inputs[$i]['tab'] = 'rel';
$i++;
$adv_rel_inputs[$i]['name'] = 'rel_content_tags';
$adv_rel_inputs[$i]['input_type'] = 'many2many';
$adv_rel_inputs[$i]['text'] = 'Tags';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['table'] = 'it_tags';
$adv_rel_inputs[$i]['rel_table'] = 'it_rel_content_tags';
$adv_rel_inputs[$i]['this_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_join'] = 'tags_id';
$adv_rel_inputs[$i]['join_key'] = 'tags_id';
$adv_rel_inputs[$i]['join_name'] = 'tags_name';
$adv_rel_inputs[$i]['tab'] = 'rel';

$i++;
$adv_rel_inputs[$i]['name'] = 'content_options_ext';
$adv_rel_inputs[$i]['input_type'] = 'content_options_ext';
$adv_rel_inputs[$i]['text'] = 'Доп. опции';
$adv_rel_inputs[$i]['help'] = 'Все опции по услуге';
$adv_rel_inputs[$i]['tab'] = 'opt';

$i++;
$adv_rel_inputs[$i]['name'] = 'rel_content_similar';
$adv_rel_inputs[$i]['input_type'] = 'many2many';
$adv_rel_inputs[$i]['text'] = 'Similar Content';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['table'] = 'it_content';
$adv_rel_inputs[$i]['rel_table'] = 'it_rel_content_similar';
$adv_rel_inputs[$i]['this_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_key'] = 'content_id';
$adv_rel_inputs[$i]['rel_join'] = 'content_similar_id';
$adv_rel_inputs[$i]['join_key'] = 'content_id';
$adv_rel_inputs[$i]['join_name'] = 'content_name';
$adv_rel_inputs[$i]['tab'] = 'rel';

$i++;
$adv_rel_inputs[$i]['name'] = 'content_translate';
$adv_rel_inputs[$i]['input_type'] = 'translate_form';
$adv_rel_inputs[$i]['text'] = 'Translate';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['table'] = 'it_content_translate';
$adv_rel_inputs[$i]['id_column'] = 'content_id';
$adv_rel_inputs[$i]['lang_alias_column'] = 'content_lang_alias';
$adv_rel_inputs[$i]['columns'] = $translate_columns;
$adv_rel_inputs[$i]['tab'] = 'translate';
