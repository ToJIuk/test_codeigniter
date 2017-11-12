<!DOCTYPE html>
<html>
<head>
	<title><?=$seo_title?></title>
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<meta name="description" content="<?=$seo_description?>">


    <meta charset="utf-8">
    <meta name="author" content="IT.iKiev.biz">

	<!-- bootstrap css -->
	<link rel='stylesheet' href="/files/admin/js/bootstrap-3.3.7/css/bootstrap.css" />

	<link href="/files/outside/css/core.css" rel="stylesheet">
	<link href="/files/outside/css/style.css" rel="stylesheet">

	<link rel="icon" href="favicon.ico">
  
<?php		
if (@file_exists(APPPATH."/views/outside/pages/" . $page_center."_head.php"))
{
   $this->load->view('outside/pages/' . $page_center."_head");
}
?>
  
</head>

<body>

	<script>
	// Place for Google Analytics Code
	</script>

	<div class="header">
		<div class="container">
			<a href="<?=$lang_link_prefix?>/" class="logo_holder" title="<?=$sitename?>">
				<img src="/files/outside/img/tree-icon.png" class="logo_img" alt="<?=$sitename?>">
				<?=$sitename?>
			</a>
			<a href="<?=$lang_link_prefix?>/content/plist" class="header_right menu_btn"  title="Blog">
				<i class="glyphicon glyphicon-th"></i> <span class="menu_text">BLOG</span>
			</a>
			<?php if ($user) { ?>
			<a href="<?=$lang_link_prefix?>/auth/profile" class="header_right register_btn">
				<i class="glyphicon glyphicon-user"></i> <span class="menu_text"><?=$this->text->get('my_profile');?></span>
			</a>
			<?php } else { ?>
			<a href="<?=$lang_link_prefix?>/auth/login" class="header_right register_btn" title="<?=$this->text->get('login_reg_top');?>L">
				<i class="glyphicon glyphicon-user"></i> <span class="menu_text"><?=$this->text->get('login_reg_top');?></span>
			</a>
			<?php } ?>
		</div>
	</div>

	<div class="content">
	<?php $this->load->view('outside/pages/' . $page_center); ?>
	</div>


	<div class="footer">
		<?=$sitename?>
	</div>

    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/files/inside/js/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="/files/inside/js/jquery.form.js"></script>
	<script src="/files/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
	<script src="/files/outside/js/custom.js"></script>

	
<?php
if (@file_exists(APPPATH."/views/outside/pages/" . $page_center."_footer.php"))
{
   $this->load->view('outside/pages/' . $page_center."_footer");
}
?>

</body>
</html>