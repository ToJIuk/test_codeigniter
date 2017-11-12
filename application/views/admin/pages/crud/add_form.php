<div class="advanced_filters" style="display: block;">
    <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="corner" style="right: 35px;"></div>
    <div class="container">
<form action="" class="add_form filter_form" method="POST">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">MAIN</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <div class="tab-pane active" id="home">
            <div class="in_bl">
                <b>Login</b><br>
                <input type="text" class="form-control" placeholder="Login" name="login" value="<?php if(isset($_GET['login'])) echo intval($_GET['login']);?>">
            </div>
        </div>
    </div>


    <div class="bottom_buttons">
        <button type="button" class="btn btn-warning" onclick="window.history.back();">ОТМЕНА</button>
        <button type="button" class="btn btn-primary" onclick="refresh_control_form();">СБРОСИТЬ</button>
        <button type="button" class="btn btn-success add_btn">ДОБАВИТЬ</button>
    </div>

</form>
</div>
</div>