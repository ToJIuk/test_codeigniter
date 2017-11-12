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
        <div class="btns">
            <a class="btn btn-danger btn-xs hide_edit_btn" onclick="window.history.back();">&lt;&lt; Back</a>
            <a class="btn btn-success btn-xs edit_btn" edit_id="<?=$row['content_id']?>">Update</a>
        </div>
    </div>
</form>