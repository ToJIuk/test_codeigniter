<h3>РЕДАКТИРОВАНИЕ ID #<?=$row[$table_id_column]?> : <?=$table?></h3>
<div class="advanced_filters" style="display: block;">
    <div class="corner"></div>
    <div class="container">


    <form action="" class="edit_form filter_form" method="POST">
    <input type="hidden" name="table" value="<?=$table?>">
    <div class="tab-content text-left">

        <?php if (isset($AT_obj->tabs)) { ?>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <?php $tmp_1 = true; foreach ($AT_obj->tabs as $tab_id => $tab_name) { ?>
                    <li <?php if ($tmp_1) { ?>class="active"<?php } ?>><a href="#<?=$tab_id?>" data-toggle="tab"><?=$tab_name?></a></li>
                    <?php $tmp_1 = false; } ?>
            </ul>
        <?php } else $AT_obj->tabs = Array('main' => 'MAIN'); ?>

        <?php $tmp_1 = true; foreach ($AT_obj->tabs as $tab_id => $tab_name) { ?>
        <div class="tab-pane <?php if ($tmp_1) echo 'active'; ?>" id="<?=$tab_id?>">

            <div class="row top10">
                <?php for ($i=1; $i<=4; $i++) { ?>
                <div class="col-md-3">

<?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>

<?php
    // Defaults
    if ( ! isset($table_column_row['form_column'])) $table_column_row['form_column'] = 1;
    if ( ! isset($table_column_row['tab'])) $table_column_row['tab'] = 'main';
?>

    <?php if (isset($table_column_row['input_type']) AND $table_column_row['form_column'] == $i AND $table_column_row['tab'] == $tab_id) { ?>
        <div class="crud2_edit_input edit_<?=$table_column?>">
            <a onclick="$(this).next().toggle();"><b><?=$table_column_row['crud_name']?></b></a>
            <div style="display: none;" class="column_help"><?php if (isset($table_column_row['help'])) echo $table_column_row['help']; ?></div>
            <?php
            if (isset($table_columns_arr[$table_column]['input_type'])) {
                $input_class = $this->inside_lib->at_get_input_class($table_columns_arr[$table_column]['input_type']);
                if (method_exists($input_class, 'input_form')) {
                    $input_data = $table_column_row;
                    if (!isset($input_data['width'])) $input_data['width'] = '';
                    $input_data['value'] = $row[$table_column];
                    $input_data['name'] = $table_column;
                    $input_data['row'] = $row;
                    $input_data['AT_obj'] = $AT_obj;

                    echo $input_class->input_form($input_data);
                }
            }
            ?>
        </div>
    <?php } ?>

<?php } ?>

                </div>
                <?php } ?>
            </div>
        </div>
        <?php $tmp_1 = false; } ?>
    </div>

        <div class="bottom_buttons">
            <a type="button" class="btn btn-warning" href="/at/table/view/<?=$table?>">&lt;&lt;</a>
            <button type="button" class="btn btn-success edit_btn" edit_id="<?=$row[$table_id_column]?>">СОХРАНИТЬ</button>
        </div>

    </form>
    </div>
</div>