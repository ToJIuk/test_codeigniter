<h3>ДОБАВЛЕНИЕ НОВОЙ ЗАПИСИ</h3>
<div class="advanced_filters" style="display: block;">
    <div class="corner"></div>
    <div class="container">

<form action="" class="add_form filter_form" method="POST">
<input type="hidden" name="table" value="<?php if(isset($_GET['table'])) echo $_GET['table'];?>">

    <?php if (isset($AT_obj->tabs)) { ?>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php $tmp_1 = true; foreach ($AT_obj->tabs as $tab_id => $tab_name) { ?>
        <li role="presentation" <?php if ($tmp_1) { ?>class="active"<?php } ?>><a href="#<?=$tab_id?>" aria-controls="<?=$tab_name?>" role="tab" aria-expanded="false" data-toggle="tab"><?=$tab_name?></a></li>
        <?php $tmp_1 = false; } ?>
    </ul>
    <?php } else $AT_obj->tabs = Array('main' => 'MAIN'); ?>

    <!-- Tab panes -->
    <div class="tab-content">

        <?php $tmp_1 = true; foreach ($AT_obj->tabs as $tab_id => $tab_name) { ?>
        <div role="tabpanel" class="tab-pane <?php if ($tmp_1) echo 'active'; ?>" id="<?=$tab_id?>">
            <div class="row">
                <?php for ($i=1; $i<=4; $i++) { ?>
                <div class="col-md-3">

<?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>

<?php
    // Defaults
    if ( ! isset($table_column_row['form_column'])) $table_column_row['form_column'] = 1;
    if ( ! isset($table_column_row['tab'])) $table_column_row['tab'] = 'main';
?>

    <?php if (isset($table_column_row['custom_table_form'])) { ?>

        <?php $this->load->view($table_column_row['custom_table_form'])?>

    <?php } elseif (isset($table_column_row['input_type']) AND $table_column_row['form_column'] == $i AND $table_column_row['tab'] == $tab_id) { ?>
            <div class="crud2_add_input add_<?=$table_column?>">
                <a onclick="$(this).next().toggle();"><b><?=$table_column_row['crud_name']?></b></a>
                <div style="display: none;" class="column_help"><?php if (isset($table_column_row['help'])) echo $table_column_row['help']; ?></div>
                <?php
                if (isset($table_columns_arr[$table_column]['input_type'])) {
                    $input_class = $table_columns_arr[$table_column]['input_type'];

                    $table_column_row['make_type'] = 'add';
                    $table_column_row['name'] = $table_column;
                    $table_column_row['value'] = '';

                    echo $this->inside_lib->make_input("input_form", $table_column_row);
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
            <a type="button" class="btn btn-warning" href="/at/table/view/<?=$table_interface?>">&lt;&lt;</a>
            <button type="button" class="btn btn-success add_btn">ДОБАВИТЬ</button>
        </div>

        </form>
    </div>
</div>