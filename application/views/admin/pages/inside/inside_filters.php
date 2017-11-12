<?php

    $filters_tabs = Array('Main');

    foreach ($filters as $filter) {

        if ( ( ! in_array($filter['filters_tab'], $filters_tabs)) AND $filter['filters_tab'] != 'Common' ) $filters_tabs[] = $filter['filters_tab'];

    }

?>

<ul class="nav nav-tabs" role="tablist">

    <li role="presentation" class="active"><a href="#Common" aria-controls="Common" role="tab" data-toggle="tab" aria-expanded="false">Common</a></li>
    <?php foreach($filters_tabs as $ftab) { ?>
    <li role="presentation"><a href="#<?=$ftab?>" aria-controls="<?=$ftab?>" role="tab" data-toggle="tab" onload="$(this).trigger('click')"><?=$ftab?></a></li>
    <?php } ?>

</ul>
<!-- Tab panes -->
<div class="tab-content">
    <?php foreach($filters_tabs as $ftab) { ?>
    <div role="tabpanel" class="tab-pane" id="<?=$ftab?>">
        <div class="row">
            <?php for ($tab_column=1; $tab_column<=4; $tab_column++) { ?>
            <div class="col-md-3">
                <?php if($tab_column == 1) { ?>
                    <div class="form-group">
                        <label>Text Search</label>
                        <input type="text" class="form-control" value="<?php if (isset($_GET['inside_search'])) echo $this->input->get('inside_search', true) ?>" id="pdg_fsearch" name="pdg_fsearch" placeholder="Search..." />
                    </div>
                    <?php if($status_filter_options) { ?>
                            <div class="form-group">
                                <label>Status</label>
                                <select type="text" class="form-control selectpicker" multiple name="status_filter[]" title="-">
                                    <?php
                                    //if(isset($status_filter_options)) {
                                    foreach ($status_filter_options as $status) {
                                        if(isset($status['default_filter']) && $status['default_filter']) $selected = ' SELECTED'; else $selected = '';
                                        echo "<option value='{$status['status_id']}' $selected>{$status['name']}</option>";
                                    }
                                    //}
                                    ?>
                                </select>
                            </div>
                    <?php } ?>
                <?php } ?>
                <?php foreach ($filters as $filter) { if ($filter['filters_tab'] == $ftab AND $filter['filters_column'] == $tab_column) { ?>

                <div class="form-group">
                    <label><?=$filter['text']?></label>
                    <?=$filter['input']?>
                </div>

                <?php } } ?>
            </div>
            <?php } ?>
        </div>

    </div>

    <?php } ?>

    <div role="tabpanel" class="tab-pane active" id="Common">
        <div class="row">
            <!--<div class="col-md-3">
                <div class="form-group">
                    <label>Text Search</label>
                    <input type="text" class="form-control" value="<?php /*if (isset($_GET['inside_search'])) echo $this->input->get('inside_search', true) */?>" id="pdg_fsearch" name="pdg_fsearch" placeholder="Search..." />
                </div>
            </div>-->
            <div class="col-md-3">
                <div class="form-group">
                    <label>ID Search</label>
                    <input type="text" class="form-control" value="<?php if (isset($_GET['inside_key'])) echo $this->input->get('inside_search', true) ?>" id="pdg_fkey" name="pdg_fkey" placeholder="ID..." />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Per Page</label>
                    <select class="form-control selectpicker" name="pdg_limit" id="pdg_limit" title="-">
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
        </div>
    </div>
</div>
<div class="bottom_buttons">
    <button type="button" class="btn btn-primary" onclick="refresh_control_form();">СБРОСИТЬ</button>
    <button type="button" class="btn btn-info" onclick="$('#pdg_send').trigger('click');">ПРИМЕНИТЬ</button>
</div>