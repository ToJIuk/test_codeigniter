	<script src="/files/typeahead/bootstrap-typeahead.min.js"></script>
    <script src="/files/canvas/jquery.exif.js"></script>
    <script src="/files/canvas/jquery.canvasResize.js"></script>

    <script>
	
	 $(function(){

         <?php if (isset($_GET['reg'])) { ?>

         ga('send', 'event', 'Auth', 'reg_<?=$user->id?>');

		 setTimeout(function(){

			 if (!confirm('<?=$this->text->get('agreement_alert');?>')) {
				 location.href = '<?=$lang_link_prefix?>/content/al/user_agreement';
         	};

		 }, 3000);

         <?php } ?>

         $('#file_select').change(function(e) {
             // alert(111);
             var file = e.target.files[0];
             $.canvasResize(file, {
                 width: 400,
                 height: 400,
                 quality: 80,
                 callback: function(data, width, height) {
                     $("#show_img").attr('src', data);
                     $("#file_select").val('');
                     $("#img_code").val(data);
                 }
             });
         });


         $('.send_cashout').on('click', function () {

             var that = $(this);
             var text = prompt("<?=$this->text->get('withdraw_funds_alert');?>", "");

             if (text != null) {

                 $.get('/actions/add_cashout/?text='+encodeURI(text), function(data){

                     alert('<?=$this->text->get('withdraw_funds_alert_ok');?>');

                 });
             }
         });


         $('.pay_online').on('click', function () {

             window.open(
                 '<?=$lang_link_prefix?>/secure/liqpay_go/'+(parseInt($('.add_money').val()))+'/?uri=<?=urlencode($_SERVER['REQUEST_URI']);?>',
                 '_blank' // <- This is what makes it open in a new window.
             );
         });

		$('.change_pass').on('click', function(){

			var options = {
 				url: "<?=$lang_link_prefix?>/auth_api/change_password/",
 				success: function(data) {
					var obj = jQuery.parseJSON(data);



					if (obj.status == "success") {

						$('.ch_pass_msg').removeClass('red');
						$('.ch_pass_msg').addClass('green');
						$('.ch_pass_msg').html(obj.message);
						$('#old_password').removeClass('red_border');
						$('#new_password').removeClass('red_border');
						$('#confirm_password').removeClass('red_border');
						$('#email').removeClass('red_border');

					} else {

						$('#old_password').addClass('red_border');
						$('#new_password').addClass('red_border');
						$('#confirm_password').addClass('red_border');
						$('#email').addClass('red_border');
						$('.ch_pass_msg').removeClass('green');
						$('.ch_pass_msg').addClass('red');
						$('.ch_pass_msg').html(obj.message);


					}
				}
 			};

 			$("#update_info_form").ajaxSubmit(options);
		});
		
		$('.update_info').on('click', function(){

            $('.uinfo_msg').html('<?=$this->text->get('loading');?>');

			var options = { 				
 				url: "<?=$lang_link_prefix?>/auth_api/update_user_data/",
 				success: function(data) {
					var obj = jQuery.parseJSON(data);
					if (obj.status == "success") {
												
						$('.uinfo_msg').removeClass('red');
						$('.uinfo_msg').addClass('green');
						$('.uinfo_msg').html(obj.message);
						document.location.href='<?=$lang_link_prefix?>/auth/profile/';
						
					} else {
						$('.uinfo_msg').removeClass('green');
						$('.uinfo_msg').addClass('red');
						$('.uinfo_msg').html(obj.message);

					}
				}
			};
			$("#update_info_form").ajaxSubmit(options);
		});


		 $('.info_search').typeahead({
			 ajax: '/info/ajax_autocomplite/?search',
			 displayField: 'info_name',
			 valueField: 'info_id',
			 onSelect: function(data){
				 if (data.value == 0) {
					 location.href = '/info/search/'+$('.info_search').val();
				 } else {
					 location.href = '/info/id/'+data.value;
				 }

			 }
		 });

		 $('.info_search').on('keypress', function(event){
			 if(event.keyCode=='13') location.href = '/info/search/'+$('.info_search').val();
		 });

      });
	
</script>