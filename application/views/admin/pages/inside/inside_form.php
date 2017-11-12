<input type="hidden" id="pdg_table" name="pdg_table" value="<?php echo $table_name; ?>"/>
<input type="hidden" id="pdg_order" name="pdg_order" value=""/>
<input type="hidden" id="pdg_asc" name="pdg_asc" value="desc"/>
<input type="hidden" id="pdg_page" name="pdg_page" value="1"/>


<div class="subheading">
    <div class="container">
        <div class="row">
            <div class="col-md-4 left_side">
                <div class="left_side_holder">

                    <button type="button" class="btn btn-info filters_button"><i class="fa fa-filter"
                                                                                 aria-hidden="true"></i></button>

                    <!--
                    <div class="status_box">
                        <span class="light_grey">Тип:</span>
                        <span>Сторудник</span>
                        <i class="fa fa-circle" aria-hidden="true"></i>
                    </div>
                    <div class="status_box">
                        <span class="light_grey">Статус: </span>
                        <span>Деактивирован</span>
                        <i class="fa fa-circle" aria-hidden="true"></i>
                    </div>
                    -->
                    &nbsp;
                    <button class="btn btn-primary" type="button" id="pdg_send"><i class="fa fa-refresh"
                                                                                   aria-hidden="true"></i></button>


                </div>
            </div>
            <div class="col-md-8 right_side">
                <div class="top_pagination">
                    <a id="pdg_page_prev" style="margin-left: 20px;">&lt;&lt;</a>
                    <span>Page: <b id="pdg_page_text">1</b></span>
                    <a id="pdg_page_next">&gt;&gt;</a>
                </div>

                <div class="buttons_holder">

                    <!--
                    <button type="button" class="btn btn-primary">СБРОСИТЬ</button>
                    <button type="button" class="btn btn-warning">ИЗМЕНИТЬ</button>
                    -->

                    <!-- INCLUDE CONFIG -->
                    <?php include('application/config/pdg_tables/' . $table_name . '.php'); ?>

                    <!-- MASS EMAILING STARTS -->
                    <?php if (isset($mass_emailing) AND $this->ion_auth->in_group([1, 8, 9])) { ?>
                        <div style="position: relative; display: inline-block">
                            <button type="button" class="btn btn-warning pdg_mass_emailing" data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                            <ul onclick="event.stopPropagation();" class="dropdown-menu"
                                style="position: absolute; top: 100%;">
                                <?php foreach ($mass_emailing as $mass_emailing_item) { ?>
                                    <li>
                                        <a onclick="<?= $mass_emailing_item['js_onclick'] ?>"><?= $mass_emailing_item['name'] ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <!-- MASS EMAILING ENDS -->

                    <!-- MASS FUNCTIONS STARTS -->
                    <?php if ($this->ion_auth->in_group([1, 8, 9]) AND (isset($table_config['status_rel_name']) OR isset($table_config['access_system']))) { ?>
                        <div style="position: relative; display: inline-block">
                            <button type="button" class="btn btn-primary" data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"><i class="fa fa-exchange" aria-hidden="true"></i></button>
                            <ul onclick="event.stopPropagation();" class="dropdown-menu"
                                style="position: absolute; top: 100%;">
                                <?php if (isset($table_config['status_rel_name'])) { ?>
                                    <li>
                                        <a>
                                            <select id="change_mass_status" style="width: 100%;">
                                                <option selected disabled>Смена статуса</option>
                                                <?php
                                                foreach ($adv_rel_inputs as $rel_row) {
                                                    if ($rel_row['name'] == $table_config['status_rel_name']) {
                                                        if (!$rel_row['status_options']) {
                                                            echo "<option>Нет доступных статусов</option>";
                                                            break;
                                                        }
                                                        foreach ($rel_row['status_options'] as $status) {
                                                            if (isset($status['color'])) $color = $status['color']; else $color = '';
                                                            if (isset($status['div-color'])) $div_color = $status['div-color']; else $div_color = '';
                                                            echo "<option value='{$status['status_id']}' color='{$color}' div-color='{$div_color}'>{$status['name']}</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (isset($table_config['access_system'])) { ?>
                                    <li>
                                        <a>
                                            <select id="change_mass_access" style="width: 100%;">
                                                <option selected disabled>Смена прав</option>
                                                <option value="1">All View | All Edit</option>
                                                <option value="2">All View | Group Edit</option>
                                                <option value="3">All View | Creator Edit</option>
                                                <option value="4">Group View | Group Edit</option>
                                                <option value="5">Group View | Creator Edit</option>
                                                <option value="6">Creator View | Creator Edit</option>
                                            </select>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <!-- MASS FUNCTIONS ENDS -->

                    <button type="button" class="btn btn-info pdg_bcopy">КОПИРОВАТЬ</button>
                    <button type="button" class="btn btn-danger pdg_bdel">УДАЛИТЬ</button>
                    <a href="/inside/pdg_add/table_name" OnClick="return false;" class="btn btn-success add_btn">ДОБАВИТЬ</a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="advanced_filters">
    <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="corner"></div>
    <div class="container">
        <?php $this->load->view('admin/pages/inside/inside_filters'); ?>
    </div>
</div>