<?php include('application/config/pdg_tables/' . $table_name . '.php');

$count_crud_columns = 0;
foreach ($table_columns as $t_column) {
    if (isset($t_column['in_crud'])) $count_crud_columns++;
}

$width = 100 / $count_crud_columns;

if (isset($table_config['sum_function'])) {
    $sum = array();
    foreach ($table_config['sum_function'] as $sum_field) {
        $sum[$sum_field] = 0;
    }
}

if (isset($table_config['avg_function'])) {
    $sum_avg = array();
    $qnt = array();
    foreach ($table_config['avg_function'] as $sum_field) {
        $sum_avg[$sum_field] = 0;
        $qnt[$sum_field] = 0;
    }
}

?>

<div class="tree_line net_header" style="display:none; background-color: lavender">
    <div style="width: 21px; padding-left: 2px; border-right: none; display: flex; justify-content: center; flex-direction: column; text-align: center;">
        <i class="glyphicon glyphicon-cog"></i>
    </div>
    <div style="width: 40px; padding-left: 2px; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;">
        <i class="glyphicon glyphicon-tag"></i>
    </div>
    <!--TOP NAMES-->
    <?php
    foreach ($table_columns as $config_row) {
        if (isset($config_row['in_crud'])) {
            echo "<div title='{$config_row['text']}' style='overflow: hidden; width: {$width}%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'><b>{$config_row['text']}</b></div>";
        }
    }
    ?>
    <?php if (isset($table_config['agreement_field'])) { ?>
        <div class="agreement_panel_head"
             style="width: <?= $width ?>%;border-right: none; border-left: 1px solid silver; justify-content: center; flex-direction: column; text-align: center;">
            <b>Согласие</b>
        </div>
    <?php } ?>
    <div class="edit_panel"
         style="width: <?= $width ?>%;border-right: none; border-left: 1px solid silver; display: none; justify-content: center; flex-direction: column; text-align: center;">
        <b>Кнопки</b>
    </div>

</div>
<div class="sortable">
    <?php foreach ($tree_res as $info_sub_row) { ?>
        <div class="row_item" priority="<?= $info_sub_row[$table_config['priority_field']] ?>">
            <div class="tree_line" line_id="<?= $info_sub_row[$table_config['key']] ?>" style="display: flex"
                 parent_id="<?= $info_sub_row[$table_config['parent_field']] ?>">

                <?php if ($info_sub_row[$table_config['child_field']] > 0) { ?>
                    <div style="width: 20px; border-right: none; display: flex; justify-content: center; flex-direction: column; text-align: center;"
                         class="action_children">
                        <a class="icon-chevron-right glyphicon glyphicon-chevron-right show_children"
                           item_id="<?= $info_sub_row['id'] ?>"></a>
                    </div>
                <?php } else { ?>
                    <div style="width: 20px; border-right: none; display: flex; justify-content: center; flex-direction: column; text-align: center;"
                         class="action_children">
                        <a class="changeable_icon_file icon-file glyphicon glyphicon-file"></a>
                        <a class="changeable_icon_plus icon-plus glyphicon glyphicon-plus special_add"
                           style="display: none;"></a>
                    </div>
                <?php } ?>

                <div style="width: 40px; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;">
                    <a><?php if ($info_sub_row[$table_config['child_field']] > 0 AND isset($count_arr[$info_sub_row[$table_config['key']]])) echo $count_arr[$info_sub_row[$table_config['key']]]; ?></a>
                </div>

                <?php
                foreach ($table_columns as $config_row) {
                    if (isset($config_row['in_crud'])) {
                        if (isset($info_sub_row[$config_row['name']])) {

                            //instead name
                            if (isset($config_row['instead_name'])) $config_row['name'] = $config_row['instead_name'];

                            // Update Data Cells (If it Needs)
                            if (isset($config_row['input_type'])) {
                                $config_row['value'] = $info_sub_row[$config_row['name']];
                                $info_sub_row[$config_row['name']] = $this->inside_lib->make_input("crud_view", $config_row);
                            }

                            /*sum agregation*/
                            if (isset($table_config['sum_function'])) {
                                foreach ($sum as $key => $value) {
                                    if ($key == $config_row['name']) $sum[$key] += (float)$info_sub_row[$config_row['name']];
                                }
                            }
                            /*avg*/
                            if (isset($table_config['avg_function'])) {
                                foreach ($sum_avg as $key => $value) {
                                    if ($key == $config_row['name']) {
                                        $sum_avg[$key] += (float)$info_sub_row[$config_row['name']];
                                        $qnt[$key]++;
                                    }
                                }
                            }

                            if ($info_sub_row[$config_row['name']] == null)
                                $info_sub_row[$config_row['name']] = '-';

                            $color = '#000';
                            $font_weight = 200;
                            if (isset($table_config['agregation_field']) AND in_array($config_row['name'], $table_config['agregation_field']) AND $info_sub_row[$table_config['child_field']] > 0) {
                                $color = '#337ab7';
                                $font_weight = 'bold';
                            }
                            echo '<div title="' . $info_sub_row[$config_row['name']] . '" column_name="' . $config_row['name'] . '" class="cell_content" style="overflow: hidden; width:' . $width . '%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;"><span style="color:' . $color . '; font-weight:' . $font_weight . '">' . $info_sub_row[$config_row['name']] . '</span></div>';
                        }
                    }
                }

                if (isset($table_config['agreement_field'])) {
                    $box_style = 'default_box';
                    $status_id = 0;
                    if ($info_sub_row['status'] == 1) {
                        $box_style = 'success_box';
                        $status_id = 1;
                    } elseif ($info_sub_row['status'] == 2) {
                        $box_style = 'danger_box';
                        $status_id = 2;
                    }

                    ?>
                    <div class="agreement_panel_content"
                         style="width: <?= $width ?>%;border-right: none; display: flex; border-left: 1px solid silver; justify-content: center; flex-direction: column; text-align: center;">
                        <div>
                            <div class="checked_box <?= $box_style ?>" status_id="<?= $status_id ?>"></div>
                            <?php if (isset($is_admin)) { ?>
                                <br>
                                <div class="btn-group">
                                    <a class="btn btn-link btn-xs dropdown-toggle remowe_users_list"
                                       data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        Список
                                    </a>
                                    <ul style="text-align: center; width: 250px;" class="dropdown-menu pull-right"
                                        style="text-align: center">
                                    </ul>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="edit_panel"
                     style="width: <?= $width ?>%;border-right: none; border-left: 1px solid silver; display: none; justify-content: center; flex-direction: column; text-align: center;">
                    <div>
                        <a class="icon-edit glyphicon glyphicon-edit edit_field" title="Редактировать"></a>
                        <a class="icon-duplicate glyphicon glyphicon-duplicate copy_field" title="Копировать"></a>
                        <a class="icon-remove glyphicon glyphicon-remove del_field" title="Удалить"></a>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>

</div>

<?php if (isset($show_sum_footer)) { ?>
    <div class="tree_line" style="display: flex; background-color: lavender">
        <div style="width: 65px; border-right: none; display: flex; justify-content: center; flex-direction: column; text-align: center;">
            <b>Сумма</b>
        </div>
        <!--TOP NAMES-->
        <?php
        foreach ($table_columns as $config_row) {
            if (isset($config_row['in_crud'])) {
                if (isset($sum[$config_row['name']])) {
                    echo "<div style='overflow: hidden; width: {$width}%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'><b>{$sum[$config_row['name']]}</b></div>";
                } else {
                    echo "<div style='overflow: hidden; width: {$width}%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'><b></b></div>";
                }
            }
        }
        ?>
        <?php if (isset($table_config['agreement_field'])) { ?>
            <div class="agreement_panel_footer"
                 style='overflow: hidden; width: <?= $width ?>%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'>
                <b></b>
            </div>
        <?php } ?>
        <div class="edit_panel"
             style="width: <?= $width ?>%;border-right: none; border-left: 1px solid silver; display: none; justify-content: center; flex-direction: column; text-align: center;">
            <b>Сумма</b></div>
    </div>
<?php } ?>

<?php if (isset($show_avg_footer)) { ?>
    <div class="tree_line" style="display: flex; background-color: lavender">
        <div style="width: 61px; border-right: none; display: flex; justify-content: center; flex-direction: column; text-align: center;">
            <b>AVG</b>
        </div>
        <!--TOP NAMES-->
        <?php
        foreach ($table_columns as $config_row) {
            if (isset($config_row['in_crud'])) {
                if (isset($sum_avg[$config_row['name']])) {
                    echo "<div style='overflow: hidden; width: {$width}%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'><b>" . round($sum_avg[$config_row['name']] / $qnt[$config_row['name']], 2) . "</b></div>";
                } else {
                    echo "<div style='overflow: hidden; width: {$width}%; border-right: none; border-left: 1px solid silver; display: flex; justify-content: center; flex-direction: column; text-align: center;'><b></b></div>";
                }
            }
        }
        ?>
        <div class="edit_panel"
             style="width: <?= $width ?>%;border-right: none; border-left: 1px solid silver; display: none; justify-content: center; flex-direction: column; text-align: center;">
            <b>AVG</b></div>
    </div>
<?php } ?>

<div style="font-size: 11px; display: none; margin: 2px 0 2px 2px" class="add_btn">
    <a class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New</a>
</div>

<!--<div style="font-size: 11px; display: none; margin: 2px 0 2px 2px" class="add_btn">
    <a class="btn btn-xs btn-success" onclick="$(this).parent().next().show();$(this).hide();"><i class="glyphicon glyphicon-plus"></i> Add New</a>
</div>
<div class="add" style="display: none;">
    <div class="tree_line">
        <input type="text">
        <a class="btn btn-xs btn-success">ADD</a>
    </div>
</div>-->