<table class="table table-striped table-condensed table-hover table-responsive crud2_ajax_table">
    <thead>
    <tr>
    <?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>
        <th class="text-center crud2_th_cell">
            <a class="crud2_column_h" column="<?=$table_column?>"><?=$table_column_row['crud_name']?>
            </a>
        </th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($crud_data_arr as $crud_row) { ?>
    <tr class="text-center row_tr_line" row_id="<?=$crud_row[$table_id_column]?>">
        <?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>

        <?php if (isset($table_column_row['custom_table_cell_view'])) { ?>

        <?php $this->load->view($table_column_row['custom_table_cell_view'], Array('crud_row' => $crud_row)); ?>

        <?php } else { ?>
        <td class="row_td_cell">
            <div class="crud2_column_td"><?php if (isset($crud_row[$table_column])) echo $crud_row[$table_column]; ?></div>
        </td>

        <?php } ?>

        <?php } ?>
    </tr>
    <tr>
        <td colspan="100" class="edit_td">
            <form role="form" method="POST"></form>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
