
<input type="hidden" id="pdg_table" name="pdg_table" value="<?php echo $table_name;?>" />
<input type="hidden" id="pdg_order" name="pdg_order" value="" />
<input type="hidden" id="pdg_asc" name="pdg_asc" value="desc" />
<input type="hidden" id="pdg_page" name="pdg_page" value="1" />


<div class="subheading">
    <div class="container">
        <div class="row">
            <div class="col-md-4 left_side">
                <div class="left_side_holder">

                    <button type="button" class="btn btn-info filters_button"><i class="fa fa-filter" aria-hidden="true"></i></button>

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
                    <button class="btn btn-primary" type="button" id="pdg_send" onclick="$('.edit_panel_tree input:checkbox').prop('checked', false); $('.edit_panel_tree a').css('box-shadow', 'none'); $('.edit_tree').removeClass('active');"><i class="fa fa-refresh" aria-hidden="true"></i></button>


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

                    <!--<button type="button" class="btn btn-info pdg_bcopy">КОПИРОВАТЬ</button>
                    <button type="button" class="btn btn-danger pdg_bdel">УДАЛИТЬ</button>
                    <a href="/inside/pdg_add/table_name" OnClick="return false;" class="btn btn-success add_btn">ДОБАВИТЬ</a>-->

                    <div style="margin-bottom: 10px;" class="edit_panel_tree">
                        <input style="display: none;" class="fast_edit_check" type="checkbox">
                        <a class="btn btn-danger fast_edit_btn" onclick="if ($('.fast_edit_check').is(':checked')) {$('.fast_edit_check').prop('checked', false); $(this).css('box-shadow', 'none');} else {$('.fast_edit_check').prop('checked', true); $(this).css('box-shadow', '0px 0px 7px 1px rgba(204,76,57,1)'); }">Fast Mode</a>

                        <input style="display: none;" class="tree_edit_check" type="checkbox">
                        <a class="btn btn-warning edit_tree" onclick="if ($('.tree_edit_check').is(':checked')) {$('.tree_edit_check').prop('checked', false); $(this).css('box-shadow', 'none');} else {$('.tree_edit_check').prop('checked', true); $(this).css('box-shadow', '0px 0px 7px 1px rgba(213,133,18,1)'); }">Edit Tree</a>
                        <!--<input type="checkbox" onclick="if (!$(this).is(':checked')) $('.net_header').hide(); else $('.net_header').show();"> <a onclick="$(this).prev().click();">Show Headers</a>-->
                        <input style="display: none;" type="checkbox" onclick="if (!$(this).is(':checked')) { $('.net_header').css('display', 'none'); $('.show_headers_btn').css('box-shadow', 'none');} else {$('.net_header').css('display', 'flex'); $('.show_headers_btn').css('box-shadow', '0px 0px 7px 1px rgba(11,125,137,1)');}"> <a class="btn btn-info show_headers_btn" onclick="$(this).prev().click();">Show Headers</a>
                    </div>

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