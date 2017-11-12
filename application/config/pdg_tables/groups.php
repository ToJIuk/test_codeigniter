<?php

// inside_top_menu CONFIG

$i = 0;
$table_columns[$i]['name'] = 'id';
$table_columns[$i]['text'] = 'ID';
$table_columns[$i]['column_width'] = '100';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'name';
$table_columns[$i]['text'] = 'Group Name';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['help'] = 'System group name';
$table_columns[$i]['in_crud'] = true;
$i++;
$table_columns[$i]['name'] = 'description';
$table_columns[$i]['text'] = 'Description';
$table_columns[$i]['tab'] = 'main';
$table_columns[$i]['input_type'] = 'text';
$table_columns[$i]['in_crud'] = true;

$table_config['key'] = 'id';
// System names: access = Access System, Chat = Chat communication
$table_config['cell_tabs_arr'] = Array (
    'main' => 'Main',
    'users' => 'Users',
    'access_new' => 'Access'
);

$i=0;
$adv_rel_inputs[$i]['name'] = 'rel_users_groups';
$adv_rel_inputs[$i]['input_type'] = 'many2many';
$adv_rel_inputs[$i]['text'] = 'Users in Group';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['table'] = 'users';
$adv_rel_inputs[$i]['rel_table'] = 'users_groups';
$adv_rel_inputs[$i]['rel_key'] = 'group_id';
$adv_rel_inputs[$i]['rel_join'] = 'user_id';
$adv_rel_inputs[$i]['join_key'] = 'id';
$adv_rel_inputs[$i]['join_name'] = 'email';
$adv_rel_inputs[$i]['tab'] = 'users';
$i++;
$adv_rel_inputs[$i]['name'] = 'group_new_access';
$adv_rel_inputs[$i]['input_type'] = 'group_new_access';
$adv_rel_inputs[$i]['text'] = 'Access Rules';
$adv_rel_inputs[$i]['help'] = '';
$adv_rel_inputs[$i]['tab'] = 'access_new';