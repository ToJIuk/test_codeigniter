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

    <div class="btns">
        <a class="btn btn-danger btn-xs hide_edit_btn" onclick="window.history.back();">&lt;&lt; Back</a>
        <a class="btn btn-success btn-xs add_btn">Add</a>
    </div>

</form>