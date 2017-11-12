<div id="cell_tabs_<?php echo $dialog_id; ?>">
    <div class="dialog_edit" edit_id="<?= $cell_id ?>" hidden></div>
    <ul class="nav nav-tabs" role="tablist">
        <li style="float: right; width: 117px; height: 44px;"></li>
        <?php $first_tab = true;
        foreach ($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <?php if(in_array($key, $unaccess_tabs)) continue; // TABS ACCESS ?>
            <li role="presentation"<?php if ($first_tab) echo ' class="active"'; ?>><a href="#<?= $key ?>"
                                                                                       aria-controls="<?= $key ?>"
                                                                                       role="tab"
                                                                                       data-toggle="tab"><?= $value ?></a>
            </li>
            <?php $first_tab = false;
        } ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach ($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <?php if(in_array($key, $unaccess_tabs)) continue; // TABS ACCESS ?>
            <div role="tabpanel" class="tab-pane active" id="<?= $key ?>">
                <?php

                // ================================================= Custom View For Chat ===================
                if ($key == "chat" AND $cell_id != 0) {
                    ob_start();
                    ?>
                    <form method="post"
                          action="/inside2/add_chat_comment/<?php echo $table_name; ?>/<?php echo $edit_cell_arr[$key_field]; ?>/"
                          class="add_chat_comment">
                        <textarea style="width:610px; height: 60px; margin-right: 20px;" name="comment"></textarea>
                        <a class="btn btn-success white add_comment">Send</a>
                        <div class="comments_holder">
                            <?php
                            foreach ($chat_messages as $row) { ?>
                                <div style="padding: 10px; margin-top: 10px; border-top: 1px dotted #777;">
                                    <b><?php echo $row['row_chat_user_name']; ?></b> <i
                                            class="gray">[<?php echo $row['row_chat_datetime']; ?>
                                        ]</i>: <?php echo $row['row_chat_content']; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                    <?php
                    $form = ob_get_clean();;
                    echo '<div id="' . $key . '">' . $form . '</div>';
                } // ---------------------------------------------------- ALL EDIT TABS ----------------------
                else {
                    ?>
                    <div class="row">
                        <form method="post" enctype="multipart/form-data"
                              action="/inside2/edit_request/<?= $table_name ?>/<?= $key ?>/<?= $edit_cell_arr[$key_field] ?>/"
                              class="edit_tab_form" tab_id="<?= $key ?>">
                            <div class="top_controls">

                                <?php if (isset($table_config['edit_controls_off']) AND in_array($key, $table_config['edit_controls_off'])) { ?>
                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?= $table_name ?>" line_id="<?= $cell_id ?>"
                                       dialog_id="<?= $dialog_id ?>" tab_id="<?= $key ?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                <?php } else { ?>
                                    <input type="button" style="" class="btn btn-info cell_tab_submit"
                                           tab_id="<?= $key ?>"value="Save"/><!--onclick="singleClick(event,this)"
                                           ondblclick="doubleClick(event)"-->
                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?= $table_name ?>" line_id="<?= $cell_id ?>"
                                       dialog_id="<?= $dialog_id ?>" tab_id="<?= $key ?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                <?php } ?>


                                <?php /*if (!isset($table_config['edit_controls_off'])) { */?><!--
                                    <input type="button" style="" class="btn btn-info cell_tab_submit"
                                           tab_id="<?/*= $key */?>" value="Save"/>
                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?/*= $table_name */?>" line_id="<?/*= $cell_id */?>"
                                       dialog_id="<?/*= $dialog_id */?>" tab_id="<?/*= $key */?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                <?php /*} elseif (!in_array($key, $table_config['edit_controls_off'])) { */?>
                                    <input type="button" style="" class="btn btn-info cell_tab_submit"
                                           tab_id="<?/*= $key */?>"value="Save"/>
                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?/*= $table_name */?>" line_id="<?/*= $cell_id */?>"
                                       dialog_id="<?/*= $dialog_id */?>" tab_id="<?/*= $key */?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                --><?php /*} */?>

                                <!--
                            <input type="reset" style="position: absolute;right: 135px;top: 10px;" class="btn btn-primary cell_tab_reset" tab_id="<?= $key ?>" value="Clear"/>
                            -->
                            </div>
                            <?php for ($tab_column = 1; $tab_column <= 4; $tab_column++) { ?>
                                <div style="max-width: 700px; width: 100%; display: inline-block;">

                                    <!--FIX FOR ADV PRIORITY BlOCK STARTS-->
                                    <?php
                                    // For Relations Inputs
                                    if (isset($adv_rel_inputs)) {
                                        foreach ($adv_rel_inputs as $config_row) {
                                            if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS

                                                //FIX FOR SHOW ABOVE
                                                if (isset($config_row['adv_priority']) AND $config_row['adv_priority'] === true) {

                                                    if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                                    if (((isset($config_row['tab'])) && ($config_row['tab'] == $key)) AND $config_row['tab_column'] == $tab_column) { ?>

                                                        <div class="form-group">
                                                            <label data-toggle="tooltip" data-placement="right"
                                                                   class="color-tooltip"
                                                                   title="<?php if (isset($config_row['help'])) echo $config_row['help']; ?>"><?= $config_row['text'] ?></label>
                                                            <?= $gen_inputs_arr[$config_row['name']] ?>
                                                        </div>

                                                    <?php }
                                                }
                                            }
                                        }
                                    } ?>
                                    <!--FIX FOR ADV PRIORITY BlOCK ENDS-->

                                    <?php
                                    // For Columns Inputs
                                    foreach ($table_columns as $config_row) {
                                        if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS
                                            if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                            if (((isset($config_row['tab'])) && ($config_row['tab'] == $key)) AND $config_row['tab_column'] == $tab_column) { ?>

                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="right"
                                                           class="color-tooltip"
                                                           title="<?php if (isset($config_row['help'])) echo $config_row['help']; ?>"><?= $config_row['text'] ?></label>
                                                    <?= $gen_inputs_arr[$config_row['name']] ?>
                                                </div>

                                            <?php }
                                        }
                                    } ?>

                                    <?php
                                    // For Relations Inputs
                                    if (isset($adv_rel_inputs)) {
                                        foreach ($adv_rel_inputs as $config_row) {

                                            if (isset($gen_inputs_arr[$config_row['name']])) { // INPUT CHECK ACCESS
                                                //FIX FOR SHOW ABOVE
                                                if (!isset($config_row['adv_priority']) OR $config_row['adv_priority'] !== true) {

                                                    if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                                    if (((isset($config_row['tab'])) && ($config_row['tab'] == $key)) AND $config_row['tab_column'] == $tab_column) { ?>

                                                        <div class="form-group">
                                                            <label data-toggle="tooltip" data-placement="right"
                                                                   class="color-tooltip"
                                                                   title="<?php if (isset($config_row['help'])) echo $config_row['help']; ?>"><?= $config_row['text'] ?></label>
                                                            <?= $gen_inputs_arr[$config_row['name']] ?>
                                                        </div>

                                                    <?php }
                                                }
                                            }
                                        }
                                    } ?>

                                </div>
                            <?php } ?>
                            <div class="dialog_controls">

                                <?php if (!isset($table_config['edit_controls_off'])) { ?>
                                    <input type="button" style="position: absolute;right: 5px;bottom: 15px;"
                                           class="btn btn-info cell_tab_submit" tab_id="<?= $key ?>" value="Save"/>
                                <?php } elseif (!in_array($key, $table_config['edit_controls_off'])) { ?>
                                    <input type="button" style="position: absolute;right: 5px;bottom: 15px;"
                                           class="btn btn-info cell_tab_submit" tab_id="<?= $key ?>" value="Save"/>
                                <?php } ?>

                                <!--
                        <a style="position: absolute;right: 80px;bottom: 15px; color:white; " class="btn btn-info btn-success edit_dialog_update" line_id="<?= $cell_id ?>" dialog_id="<?= $dialog_id ?>" tab_id="<?= $key ?>"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        -->
                            </div>
                        </form>
                    </div>


                <?php } ?>

            </div>

        <?php } ?>
    </div>
</div>
<script>
    // Add tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectpicker').selectpicker();
    });
</script>