<table class="table table-striped table-condensed table-hover table-responsive crud2_ajax_table"<?php if (isset($AT_obj->table_style)) echo ' style="'.$AT_obj->table_style.'""'; ?>>
    <thead>
    <tr>
    <?php foreach ($table_columns_arr as $table_column => $table_column_row) { if ( ! isset($table_column_row['not_in_crud'])) { ?>
        <th class="text-center crud2_th_cell"<?php if (isset($table_column_row['th_style'])) echo " style=\"".$table_column_row['th_style']."\""; ?>>
            <span class="crud2_column_h" column="<?=$table_column?>"><?=$table_column_row['crud_name']?></span>
        </th>
    <?php } } ?>
        <th class="text-center crud2_th_cell">
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($crud_data_arr as $crud_row) { $GLOBALS['crud_row'] = $crud_row; ?>
    <tr class="text-center row_tr_line" row_id="<?=$crud_row[$table_id_column]?>"<?php if (isset($AT_obj->tr_style_modifyer_arr)) echo ' style=" '.$AT_obj->tr_style_modifyer_arr[$crud_row[$AT_obj->tr_style_modifyer_field]].' "';?>>
        <?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>

        <?php if (isset($table_column_row['custom_table_cell_view'])) { ?>

        <?php $this->load->view('outside/pages/at/'.$table_column_row['custom_table_cell_view']);?>

        <?php } elseif ( ! isset($table_column_row['not_in_crud'])) { ?>
        <td class="row_td_cell"<?php if (isset($table_column_row['td_style'])) echo " style=\"".$table_column_row['td_style']."\""; ?>>
            <div class="crud2_column_td"<?php if (isset($table_column_row['holder_style'])) echo " style=\"".$table_column_row['holder_style']."\""; ?>>
            <?php
            $value = $crud_row[$table_column];
            // Replace value for JOIN situations
            if (isset($table_columns_arr[$table_column]['crud_column'])) $value = $crud_row[$table_columns_arr[$table_column]['crud_column']];

            if (isset($table_columns_arr[$table_column]['input_type'])) {
                $input_class = $this->inside_lib->at_get_input_class($table_columns_arr[$table_column]['input_type']);
                if (method_exists($input_class, 'crud_view')) {
                    $input_data = Array('value' => $value, 'column_array' => $table_columns_arr[$table_column]);
                    echo $input_class->crud_view($input_data);
                } else echo $value;
            } else echo $value;
            ?>
            </div>
        </td>

        <?php } ?>

        <?php } ?>

        <?php $this->load->view('admin/pages/at/control_cell');?>

    </tr>
    <!--
    <tr>
        <td colspan="100" class="edit_td">
            <form role="form" method="POST"></form>
        </td>
    </tr>
    -->
    <?php } ?>
    </tbody>
</table>

<script>
    $("table").stickyTableHeaders();
</script>