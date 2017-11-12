<div id="cell_tabs_<?php echo $dialog_id; ?>">
    <ul class="nav nav-tabs" role="tablist">
            <li style="float: right; width: 50px; height: 44px;"></li>
        <?php $first_tab = true; foreach ($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <?php if(in_array($key, $unaccess_tabs)) continue; // TABS ACCESS ?>
            <li role="presentation"<?php if ($first_tab) echo ' class="active"';?>><a href="#<?=$key?>" aria-controls="<?=$key?>" role="tab" data-toggle="tab"><?=$value?></a></li>
            <?php $first_tab = false; } ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <form method="post" enctype="multipart/form-data" action="/inside2/add_request/<?=$table_name?>/" class="add_tab_form">

            <div class="top_controls">
                <input type="button" style="" class="btn btn-info cell_tab_submit" tab_id="<?=$key?>" value="Save"/>
            </div>
        <?php foreach($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <?php if(in_array($key, $unaccess_tabs)) continue; // TABS ACCESS ?>
            <div role="tabpanel" class="tab-pane active" id="<?=$key?>">
                <div class="row">

                <?php for ($tab_column=1; $tab_column<=4; $tab_column++) { ?>
                    <div style="max-width: 700px; width: 100%; display: inline-block;">

                        <!--FIX FOR ADV PRIORITY BlOCK STARTS-->
                        <?php
                        // For Relations Inputs
                        if (isset($adv_rel_inputs)) { foreach ($adv_rel_inputs as $config_row) {
                            if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS

                            //FIX FOR SHOW ABOVE
                            if (isset($config_row['adv_priority']) AND $config_row['adv_priority'] === true) {

                                if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                if (( (isset($config_row['tab'])) && ($config_row['tab'] == $key) ) AND $config_row['tab_column'] == $tab_column) { ?>

                                    <div class="form-group">
                                        <label data-toggle="tooltip" data-placement="right" class="color-tooltip" title="<?php if (isset($config_row['help'])) echo $config_row['help'];?>"><?=$config_row['text']?></label>
                                        <?=$gen_inputs_arr[$config_row['name']]?>
                                    </div>

                                <?php } } } } } ?>
                        <!--FIX FOR ADV PRIORITY BlOCK ENDS-->


                        <?php
                        // For Columns Inputs
                        foreach ($table_columns as $config_row) {
                        if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS
                            if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                            if (( (isset($config_row['tab'])) && ($config_row['tab'] == $key) ) AND $config_row['tab_column'] == $tab_column) { ?>

                                <div class="form-group">
                                    <label data-toggle="tooltip" data-placement="right" class="color-tooltip" title="<?php if (isset($config_row['help'])) echo $config_row['help'];?>"><?=$config_row['text']?></label>
                                    <?=$gen_inputs_arr[$config_row['name']]?>
                                </div>

                            <?php } } }?>


                        <?php
                        // For Relations Inputs
                        if (isset($adv_rel_inputs)) { foreach ($adv_rel_inputs as $config_row) {

                            if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS
                            //FIX FOR SHOW ABOVE
                            if (!isset($config_row['adv_priority']) OR $config_row['adv_priority'] !== true) {

                                if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                if (( (isset($config_row['tab'])) && ($config_row['tab'] == $key) ) AND $config_row['tab_column'] == $tab_column) { ?>

                                    <div class="form-group">
                                        <label data-toggle="tooltip" data-placement="right" class="color-tooltip" title="<?php if (isset($config_row['help'])) echo $config_row['help'];?>"><?=$config_row['text']?></label>
                                        <?=$gen_inputs_arr[$config_row['name']]?>
                                    </div>

                                <?php } } } } }?>

                    </div>
                <?php } ?>


                </div>
            </div>
            <div class="dialog_controls">
                <?php if($key !== 'activities') { ?>
                <input type="button" style="position: absolute;right: 5px;bottom: 15px;" class="btn btn-info cell_tab_submit" tab_id="<?=$key?>" value="Save"/>
                <?php } ?>
            </div>

        <?php } ?>
        </form>
    </div>
</div>
<script>
    // Add tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectpicker').selectpicker();
    });
</script>