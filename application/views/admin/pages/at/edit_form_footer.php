<script type="text/javascript" src="/files/inside/js/jquery.form.js"></script>
<script type="text/javascript" src="/files/inside/js/ui.multiselect.js"></script>


<link rel="stylesheet" type="text/css" href="/files/inside/css/ui.multiselect.css" />

<link rel="stylesheet" type="text/css" href="/files/outside/css/core.css" />

<script>

    // Edit Send Form
    $(".edit_btn").on('click', function(){
        var btn = $(this);
        var edit_id = $(this).attr('edit_id');
        var edit_form = $('.edit_form');
        btn.hide();
        btn.after('<div>loading...</div>');
        edit_form.ajaxSubmit({
            url: '/at/table/edit_request/<?=$table?>/'+edit_id,
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