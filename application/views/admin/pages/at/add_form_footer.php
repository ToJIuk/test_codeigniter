
<script type="text/javascript" src="/files/inside/js/ui.multiselect.js"></script>

<link rel="stylesheet" type="text/css" href="/files/inside/css/ui.multiselect.css" />

<link rel="stylesheet" type="text/css" href="/files/outside/css/core.css" />

<script>

    // Add Send Form
    $(".add_btn").on('click', function(){
        var btn = $(this);
        btn.hide();
        btn.after('<div>loading...</div>');
        $(".add_form").ajaxSubmit({
            url: '/<?=$controller_name?>/table/add_request/<?=$table?>',
            type: 'post',
            success: function(data) {
                btn.next().html('saved!');
                setTimeout(function(){
                    btn.next().remove();
                    btn.show();
                }, 900);
            },
            error: function(xhr, status, error) {
                btn.next().html(xhr.responseText);
                btn.show();
            }
        });

    });

    $(function(){

        $('.pdg_mselect').multiselect();

    });

</script>