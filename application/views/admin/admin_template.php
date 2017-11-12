<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Inside 3</title>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">

    <!-- Font awesone -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- bootstrap css -->
    <link rel='stylesheet' href="/files/admin/js/bootstrap-3.3.7/css/bootstrap.css"/>

    <!-- bootstrap select -->
    <link rel='stylesheet' href="/files/admin/js/bootstrap-select-1.12.2/bootstrap-select.css"/>

    <!-- jquery ui css -->
    <link rel="stylesheet" href="/files/admin/js/jquery-ui-1.12.1/jquery-ui.css">

    <!-- Checkboxes -->
    <link rel='stylesheet' type='text/css' href="/files/admin/checkboxes.css"/>

    <!-- Theme css -->
    <link rel='stylesheet' type='text/css' href="/files/admin/style.css"/>

    <!-- Theme customization -->
    <link rel='stylesheet' type='text/css' href="/files/admin/ui.css"/>


    <link rel='stylesheet' type='text/css'
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.css"/>
    <link rel='stylesheet' type='text/css'
          href="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.css"/>

    <?php
    if (@file_exists(APPPATH . "/views/admin/pages/" . $page_center . "_head.php")) {
        $this->load->view('admin/pages/' . $page_center . "_head");
    }
    ?>

    <style>
        .tooltip.right .tooltip-arrow {
            border-right: 5px solid #0b7d89;
        }

        .tooltip.top .tooltip-arrow {
            border-top: 5px solid #0b7d89;
        }

        .color-tooltip + .tooltip > .tooltip-inner {
            background-color: #0b7d89;
        }
    </style>

</head>
<body>
<div class="page-container sidebar-collapsed">
    <div class="content">
        <header class="top_header">

            <?php

            if (isset($table_name)) $seo_title = $table_name;
            if (!isset($seo_title)) $seo_title = 'TКN-CRM';
            if (isset($table_config['table_title'])) $seo_title = $table_config['table_title'];

            ?>

            <h3 class="page_name"><?= $seo_title ?></h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 left_side">
                        <h1 class="top_logo"><?= $seo_title ?></h1>
                        <div class="form-group top_search_holder">
                            <input type="text" class="form-control top_search" placeholder="Поиск">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-md-6 right_side">
                        <ul class="top_nav">
                            <li><a class="settings_btn"
                                   onclick="$.get('/admin/ajax/user_data/',function(data){alert(data)})"><i
                                            class="fa fa-cogs" aria-hidden="true"></i></a></li>
                            <li><a><i class="fa fa-bell-o" aria-hidden="true"></i></a></li>
                            <li><a href="/auth/profile"><i class="fa fa-user"
                                                           aria-hidden="true"></i>&nbsp;<?= $user->email ?></a><span
                                        class="nav_divider">|</span></li>
                            <li><a href="/auth/logout">Выход</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="dropdown mob_dropdown_box">

                <!-- INCLUDE CONFIG -->
                <?php include('application/config/pdg_tables/' . $table_name . '.php'); ?>

                <!-- MASS EMAILING STARTS -->
                <?php if (isset($mass_emailing) AND $this->ion_auth->in_group([1, 8, 9])) { ?>
                    <div style="display: inline-block">
                        <button class="mob_dropdown_btn" id="mobMass" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </button>
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
                <?php if ($this->ion_auth->in_group([1, 8, 9]) AND (isset($table_config['status_rel_name']) OR isset($table_config['access_system']))) {?>
                    <div style="display: inline-block;">
                        <button class="mob_dropdown_btn" id="mobMass" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-exchange" aria-hidden="true"></i>
                        </button>
                        <ul onclick="event.stopPropagation();" class="dropdown-menu" aria-labelledby="mobMass">

                            <?php
                            //===MASS FUNCTIONS STATUSES
                            if (isset($table_config['status_rel_name'])) { ?>
                                <li>
                                    <a>
                                        <select id="change_mass_status" style="width: 100%; color:#000">
                                            <option selected disabled>Смена статусов</option>
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
                                        <select id="change_mass_access" style="width: 100%; color:#000">
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

                <button class="mob_dropdown_btn" id="mobDrop" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </button>
                <ul onclick="event.stopPropagation();" class="dropdown-menu" aria-labelledby="mobDrop">
                    <li class="mob_filrer_btn"><a>Фильтр</a></li>
                    <li><a class="add_btn">Добавить запись</a></li>
                    <li><a class="del_btn pdg_bdel">Удалить записи</a></li>
                    <li role="separator" class="divider"></li>
                    <li class=""><a onclick="$('.settings_btn').trigger('click');">Настройки</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="logout_link"><a href="/auth/logout">Logout</a></li>
                </ul>
            </div>


        </header>
        <div class="table_section">
            <div class="container">

                <?php $this->load->view('admin/pages/' . $page_center); ?>


            </div>
        </div>
    </div>
    <!--/sidebar-menu-->
    <div class="sidebar-menu">
        <header class="logo1">
            <span class="mobile_logo">Inside 3.1</span>
            <button type="button" class="sidebar-icon"><span class="fa fa-bars"></span></button>
        </header>
        <div class="menu">

            <ul id="menu">
                <li class="search_box_li">
                    <form>
                        <div class="search_box">
                            <input type="text" class="menu_search form-control" placeholder="Поиск">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </form>
                </li>
                <div class="inside_menu_search">
                </div>
                <div class="inside_menu">
                    <?php echo $top_menu; ?>
                </div>

            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<footer class="footer">

</footer>

<?php $this->load->view('admin/admin_footer'); ?>

<?php
if (@file_exists(APPPATH . "/views/admin/pages/" . $page_center . "_footer.php")) {
    $this->load->view('admin/pages/' . $page_center . "_footer");
}
?>
</body>
</html>