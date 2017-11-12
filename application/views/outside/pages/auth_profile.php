<div class="container">

    <div class="row profile_info top10">

        <div class="col-xs-12 col-sm-6 col-md-6 finance_part">

            <div class="center wblock p10">
                <h4>
                    <nobr>[<?=$user->id;?>] <?=$user->username;?> (<?=$user->email;?>)
                    <a title="LogOut" class="glyphicon glyphicon-new-window" href="/auth/logout"></a>
                    <?php if ($this->ion_auth->is_admin()) { ?>
                        <a title="Inside" class="glyphicon glyphicon-th-list" href="/inside2"></a>
                    <?php } ?>
                    </nobr>
                </h4>
                <div class="top20">
                    <a class="btn btn-primary w_full" target="_blank" href="<?=$lang_link_prefix?>/inside2">Inside Admin Panel &gt;&gt;</a>
                    <br><br>
                </div>
                <a class="btn mbtn1 wbgs1 btn-sm" onclick="$(this).next().toggle();" ><?=$this->text->get('pass_email_change');?></a>
                <div id="user_pass" class="user_pass" style="display: none;">

                    <form method="post" id="ch_pass_form" class="style_form form-inline align_left">

                        <br />


                        <b class="add-on form-control-static"><?=$this->text->get('current_password');?></b>
                        <br />
                        <input class="wbgs0 p10 form-control" type="text" id="old_password"  name="old_password">



                        <b class="add-on form-control-static"><?=$this->text->get('new_password');?></b>
                        <br />
                        <input class="wbgs0 p10 form-control" type="text" id="new_password"  name="new_password">


                        <b class="add-on form-control-static"><?=$this->text->get('repeat_new_password');?></b>
                        <br />
                        <input class="wbgs0 p10 form-control"  type="text" id="confirm_password"  name="confirm_password">

                        <b class="add-on form-control-static">Email</b>
                        <br />
                        <input class="wbgs0 p10 form-control"  type="text" id="email"  name="email" value="<?=$user->email;?>">

                        <br/>
                        <div class="ch_pass_msg message"></div>
                        <br/>
                        <div class="clearfix"></div>
                        <a class="btn btn-success change_pass"><?=$this->text->get('save_changes');?></a>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div style="height:27px;"></div>


            </div>

        </div>

        <form action="/auth_api/edit_info/" method="post" id="update_info_form" class="style_form form-inline" enctype="multipart/form-data">

        <div class="col-xs-12 col-sm-6 col-md-6 " id="user_info">
            <div class="wblock p10">
                <div>
                    <b>NickName</b>
                    <br/>
                    <input class="wbgs0 p10 form-control" type="text" id="name" name="name" value="<?=$user->username?>" />
                </div>
                <div class="top10">
                    <b><?=$this->text->get('language');?></b>
                    <br/>
                    <select class="wbgs1 form-control lang_select" name="lang" onchange="location.href = $(this).val();">
                        <?php foreach ($all_lang_arr as $lang) {
                            $lang_prefix = "/".$lang['lang_alias'];
                            $tmp_url = substr($_SERVER['REQUEST_URI'], 3);
                            if ($lang['lang_alias'] == $default_lang) {$lang_prefix = "";};
                            if ($this->session->userdata('lang') == $default_lang) {$tmp_url = $_SERVER['REQUEST_URI'];};
                            ?>
                            <option value="<?=$lang_prefix?><?=$tmp_url?>" lang="<?=$lang['lang_alias']?>"<?php if ($lang['lang_alias'] == $this->session->userdata('lang')) echo " selected";?>>
                                <?=$this->text->get($lang['lang_name']);?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="uinfo_msg message"></div>
                <a class="btn mbtn1 btn-success update_info top10 fright"><?=$this->text->get('save_changes');?></a>
                <div class="clearfix"></div>
            </div>
        </div>
        </form>

    </div>

				


    <hr style="    border-top: 1px solid #ddd;">
    <h4 class="center top10"><?=$this->text->get('profile_search_h1');?></h4>
    <div class="center">
        <input name="info_rel_info_name" style="width: 100%;" class="info_search p10 wbgs0 form-control top10" type="text" placeholder="<?=$this->text->get('fast_search_placeholder');?>"/>
    </div>


    <div class="row top20 profile_info_blocks">
        <div class="col-xs-12 col-sm-4 col-md-3"><div class="wblock p10 center">
            <a class="glyphicon glyphicon-ok-circle grey"></a> <?=$this->text->get('profile_help_text1');?> <a class="glyphicon glyphicon-ok-circle green"></a>
        </div></div>
        <div class="col-xs-12 col-sm-4 col-md-3"><div class="wblock p10 center">
            <a class="glyphicon glyphicon-plus"></a> <?=$this->text->get('profile_help_text2');?></a>
        </div></div>
        <div class="col-xs-12 col-sm-4 col-md-3"><div class="wblock p10 center">
                <?=$this->text->get('profile_help_text3');?> <a class="glyphicon glyphicon-list-alt"></a>
        </div></div>
        <div class="col-xs-12 col-sm-4 col-md-3"><div class="wblock p10 center">
                <a class="glyphicon glyphicon-arrow-down"></a> <?=$this->text->get('profile_help_text4');?></a> <a class="glyphicon glyphicon-arrow-up"></a>
        </div></div>
    </div>

    <div class="center top20">
        <div class="top10">
            <a href="/m_tasks/all" class="btn btn-primary">New Mini-Task Tracker Demo &gt;&gt;</a>
        </div>
        <div class="top20">
            <a href="<?=$lang_link_prefix?>/info/all"><?=$this->text->get('show_last_500_info');?></a>
        </div>
    </div>

</div>