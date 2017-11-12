<div class="subheading">
  <div class="container">
    <div class="row">
      <div class="col-md-4 left_side">
        <div class="left_side_holder">

          <button type="button" class="btn btn-info filters_button"><i class="fa fa-filter" aria-hidden="true"></i></button>
          &nbsp;
          <button class="btn btn-primary" type="button" id="pdg_send" onclick="$('.filter_search_btn').trigger('click');"><i class="fa fa-refresh" aria-hidden="true"></i></button>

          <button class="btn btn-warning" type="button" id="pdg_help" onclick="$('.help_info').toggle();"><i class="fa fa-info" aria-hidden="true"></i></button>

        </div>
      </div>
      <div class="col-md-8 right_side">
        <div class="top_pagination pager">
          <a id="pdg_page_prev" class="previous">&lt;&lt;</a>
          <span>Page: <b id="pdg_page_text" class="crud_page_cnt">1</b></span>
          <a id="pdg_page_next" class="next">&gt;&gt;</a>
        </div>

        <div class="buttons_holder">

          <!--
          <button type="button" class="btn btn-info pdg_bcopy">КОПИРОВАТЬ</button>
          <button type="button" class="btn btn-danger pdg_bdel">УДАЛИТЬ</button>
          -->
          <a onclick="$('.add_form_holder').toggle();" class="btn btn-success add_btn">ДОБАВИТЬ</a>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="add_form_holder" style="display:none;">
  <?php $this->load->view('admin/pages/crud/add_form')?>
</div>

<div class="help_info" style="display:none;">
  <?php $this->load->view('admin/pages/crud/help_info')?>
</div>


<div class="advanced_filters">
  <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
  <div class="corner"></div>
  <div class="container">
  <form class="filters_form" id="crud_filters_form" action="" method="GET">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" data-toggle="tab">Search/Go</a></li>
    <li role="presentation" ><a href="#profile" data-toggle="tab">inputText/textarea</a></li>
    <li role="presentation" ><a href="#messages" data-toggle="tab">checkbox/datetimepicker</a></li>
    <li role="presentation" ><a href="#settings" data-toggle="tab">select/multiSelect</a></li>
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

    <div class="bottom_buttons">
      <button type="button" class="btn btn-warning filters_button">ОТМЕНА</button>
      <button type="button" class="btn btn-primary" onclick="refresh_control_form();">СБРОСИТЬ</button>
      <button type="button" class="btn btn-info filter_search_btn">ПРИМЕНИТЬ</button>
    </div>

  </form>
  </div>
</div>