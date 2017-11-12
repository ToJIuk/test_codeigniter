<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/files/jquery_lib/jquery.form.js"></script>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/files/crud/css/core.css', '');
?>

<script>

    // Edit Send Form
    $(".edit_btn").on('click', function(){
        var btn = $(this);
        var edit_id = $(this).attr('edit_id');
        var edit_form = $(this).parent().parent().parent();
        btn.hide();
        btn.after('<div>loading...</div>');
        edit_form.ajaxSubmit({
            url: '<?=Yii::app()->request->baseUrl;?>/<?=$controller_name?>/edit/'+edit_id,
            type: 'post',
            success: function(data) {
                btn.next().html('saved!');
                setTimeout(function(){
                    btn.next().remove();
                    btn.show();
                }, 900);
            }
        });

    });

</script>