<div class="advanced_filters" style="display: block;">
    <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="corner"></div>
    <div class="container">
    <form action="" class="edit_form filter_form" method="POST">
    <div class="tab-content text-left">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#main" data-toggle="tab">Основное / MAIN</a></li>
            <li><a href="#add" data-toggle="tab">Дополнительное</a></li>
            <li><a href="#permissions" data-toggle="tab">Права доступа</a></li>
            <li><a href="#system_settings" data-toggle="tab">Системные настройки</a></li>
        </ul>

        <div class="tab-pane active" id="main">
            <div class="row1">
                <div class="col-md-3">
                    <b>Content Name</b><br>
                    <input type="text" class="form-control" placeholder="Enter name" name="content_name" value="<?=$row['content_name']?>">
                </div>
            </div>
        </div>

        <div class="tab-pane" id="add">
            <div class="row1">

            </div>
        </div>
        <div class="tab-pane" id="permissions">
            <div class="row1">

            </div>
        </div>
        <div class="tab-pane" id="system_settings">
            <div class="row1">

            </div>
        </div>
        <div class="bottom_buttons">
            <button type="button" class="btn btn-warning" onclick="window.history.back();">ОТМЕНА</button>
            <button type="button" class="btn btn-primary" onclick="refresh_control_form();">СБРОСИТЬ</button>
            <button type="button" class="btn btn-success edit_btn">СОХРАНИТЬ</button>
        </div>
    </div>
    </form>
    </div>
</div>