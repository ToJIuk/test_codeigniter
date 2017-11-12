<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/files/jquery_lib/jquery.form.js"></script>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/files/crud/css/core.css', '');
?>

<script>

    // Add Send Form
    $(".add_btn").on('click', function(){
        var btn = $(this);
        btn.hide();
        btn.after('<div>loading...</div>');
        $(".add_form").ajaxSubmit({
            url: '<?=Yii::app()->request->baseUrl;?>/<?=$controller_name?>/add/',
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