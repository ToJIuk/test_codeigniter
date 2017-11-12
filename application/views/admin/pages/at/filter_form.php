<div class="subheading">
    <div class="container">
        <div class="row">
            <div class="col-md-4 left_side">
                <div class="left_side_holder">

                    <button type="button" class="btn btn-info filters_button"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    &nbsp;
                    <button class="btn btn-primary" type="button" id="pdg_send" onclick="$('.filter_search_btn').trigger('click');"><i class="fa fa-refresh" aria-hidden="true"></i></button>

                    <button class="btn btn-warning" type="button" id="pdg_help" onclick="$('.help_info').toggle();"><i class="fa fa-info" aria-hidden="true"></i></button>

                </div>
            </div>
            <div class="col-md-8 right_side">
                <div class="top_pagination pager">
                    <a id="pdg_page_prev" class="previous">&lt;&lt;</a>
                    <span>Page: <b id="pdg_page_text" class="crud_page_cnt">1</b></span>
                    <a id="pdg_page_next" class="next">&gt;&gt;</a>
                </div>

                <div class="buttons_holder">

                    <!--
                    <button type="button" class="btn btn-info pdg_bcopy">КОПИРОВАТЬ</button>
                    <button type="button" class="btn btn-danger pdg_bdel">УДАЛИТЬ</button>
                    -->
                    <a href="/at/table/add/<?=$table_interface?>" class="btn btn-success add_btn">ДОБАВИТЬ</a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="help_info" style="display:none;">
    <?php $this->load->view('admin/pages/at/help_info')?>
</div>


<div class="advanced_filters">
    <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="corner"></div>
    <div class="container">

<form class="filters_form" id="crud_filters_form" action="" method="GET">


    <input type="hidden" name="page" class="crud_page_hidden" value="<?php if(isset($_GET['page'])) echo intval($_GET['page']);?>">
    <input type="hidden" name="per_page" value="<?php if(isset($_GET['per_page'])) echo intval($_GET['per_page']);?>">

    <input type="hidden" name="table" value="<?php if(isset($_GET['table'])) echo $_GET['table'];?>">

    <input type="hidden" name="order_by" class="order_by_hidden" value="<?php if(isset($_GET['order_by'])) echo $_GET['order_by'];?>">
    <input type="hidden" name="order_by_desc" class="order_by_type_hidden" value="<?php if(isset($_GET['order_by_desc'])) echo $_GET['order_by_desc'];?>">


    <input type="hidden" name="debug" value="<?php if(isset($_GET['debug'])) echo 1;?>">

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#Common" aria-controls="Common" role="tab" data-toggle="tab" aria-expanded="false">Common</a></li>
        <?php if (isset($table_columns_arr['tabs'][0])) { foreach($table_columns_arr['tabs'] as $ftab) { ?>
        <li role="presentation"><a href="#<?=$ftab?>" aria-controls="<?=$ftab?>" role="tab" data-toggle="tab"><?=$ftab?></a></li>
        <?php } } ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div class="row top10">
                <?php for ($i=1; $i<=4; $i++) { ?>
                <div class="col-md-3">

            <?php foreach ($table_columns_arr as $table_column => $table_column_row) { ?>

<?php
    // Defaults
    if ( ! isset($table_column_row['filter_column'])) $table_column_row['filter_column'] = 1;
?>

                <?php if (isset($table_column_row['custom_filter_form'])) { ?>

                    <?php $this->renderPartial($table_column_row['custom_filter_form']);?>

                <?php } elseif ( isset($table_column_row['input_type']) AND isset($table_column_row['filter'])  AND $table_column_row['filter_column'] == $i ) { ?>
                    <div class="crud2_add_input add_<?=$table_column?>">
                        <b><?=$table_column_row['crud_name']?></b><br />
                        <?php
                        if (isset($table_columns_arr[$table_column]['input_type'])) {
                            $input_class = $this->inside_lib->at_get_input_class($table_columns_arr[$table_column]['input_type']);
                            if (method_exists($input_class, 'input_form')) {
                                $input_data = $table_column_row;
                                if (!isset($input_data['width'])) $input_data['width'] = '';
                                $input_data['value'] = '';
                                $input_data['name'] = $table_column;

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
        <div role="tabpanel" class="tab-pane active" id="Common">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Text Search</label>
                        <input type="text" class="form-control" value="<?php if (isset($_GET['inside_search'])) echo $this->input->get('inside_search', true) ?>" id="pdg_fsearch" name="pdg_fsearch" placeholder="Search..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ID Search</label>
                        <input type="text" class="form-control" value="<?php if (isset($_GET['inside_key'])) echo $this->input->get('inside_search', true) ?>" id="pdg_fkey" name="pdg_fkey" placeholder="ID..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Per Page</label>
                        <select class="form-control selectpicker" title="-">
                            <option value="10">10 per Page</option>
                            <option value="20">20 per Page</option>
                            <option value="50" selected>50 per Page</option>
                            <option value="100">100 per Page</option>
                            <option value="250">250 per Page</option>
                            <option value="500">500 per Page</option>
                            <option value="1000">1000 per Page</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">

                </div>
            </div>
        </div>
    </div>

    <div class="bottom_buttons">
        <button type="button" class="btn btn-warning filters_button">ОТМЕНА</button>
        <button type="button" class="btn btn-primary" onclick="refresh_control_form();">СБРОСИТЬ</button>
        <button type="button" class="btn btn-info filter_search_btn">ПРИМЕНИТЬ</button>
    </div>

</form>
    </div>
</div>