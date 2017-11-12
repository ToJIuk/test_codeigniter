<div class="filter_form">
  <a class="glyphicon glyphicon-remove top_right_remove" onclick="$(this).parent().parent().hide();"></a>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">Search/Go</a></li>
    <li><a href="#profile" data-toggle="tab">inputText/textarea</a></li>
    <li><a href="#messages" data-toggle="tab">checkbox/datetimepicker</a></li>
    <li><a href="#settings" data-toggle="tab">select/multiSelect</a></li>
  </ul>

  <input type="hidden" class="form-control crud_page_hidden" placeholder="Page" name="page" value="<?php if(isset($_GET['page'])) echo intval($_GET['page']);?>">


  <input type="hidden" name="order_by" class="order_by_hidden" value="<?php if(isset($_GET['order_by'])) echo $_GET['order_by'];?>">
  <input type="hidden" name="order_by_desc" class="order_by_type_hidden" value="<?php if(isset($_GET['order_by_desc'])) echo $_GET['order_by_desc'];?>">



  <!-- Tab panes -->
  <div class="tab-content">

    <div class="tab-pane active" id="home">
      <div class="in_bl">
        <b>Page</b><br>
        <input type="text" class="form-control" placeholder="Page" name="page" value="<?php if(isset($_GET['page'])) echo intval($_GET['page']);?>">
      </div>
      <div class="in_bl">
        <b>Per Page</b><br>
        <input type="text" class="form-control" placeholder="Per page" name="per_page" value="<?php if(isset($_GET['per_page'])) echo intval($_GET['per_page']);?>">
      </div>
      <div class="in_bl">
        <b>Login</b><br>
        <input type="text" class="form-control" placeholder="Login" name="login" value="<?php if(isset($_GET['login'])) echo intval($_GET['login']);?>">
      </div>
    </div>

    <div class="tab-pane" id="profile">
      <div class="row">
        <div class="col-md-3">
          <input type="text" class="form-control" placeholder="Text input">
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-3">
          <textarea class="form-control" rows="0"></textarea>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="messages">
      <div class="row">
        <div class='col-sm-3'>
          <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
          </label>
          <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox2" value="option2"> 2
          </label>
          <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox3" value="option3"> 3
          </label>
        </div>
      </div>
      <br>
      <div class="row">
        <div class='col-sm-3'>
          <div class="form-group">
            <div class='input-group date' id='datetimepicker1'>
              <input type='text' class="form-control" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="settings">
      <div class="row">
        <div class="col-md-3">
          <select multiple class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
          <br>
          <select class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
      </div>
    </div>
  </div>

    <div class="btns">
        <a class="btn btn-danger btn-xs hide_edit_btn" onclick="$(this).parent().parent().parent().hide();">Cancel</a>
        <a class="btn btn-success btn-xs filter_search_btn">Search</a>
    </div>

</div>