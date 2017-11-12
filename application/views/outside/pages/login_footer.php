<script src="/files/outside/js/auth.js"></script>

<script>

    // Login register tabs
    $(".tab_btn").on("click", function(){
        var target = $(this).attr("data-target");

        $(".tab_btn").removeClass("active");
        $(this).addClass("active");

        $(".tab").hide();
        $(".tab." + target).fadeIn("fast");
    });

    $(function(){
        <?php if (isset($_GET['reg'])) { ?>

        var cookie_req_user_type = $.cookie('req_user_type');

        setTimeout ( function(){
            if (typeof cookie_req_user_type !== 'undefined')
            {
                $.removeCookie('req_user_type', { path: '/' });
                $.cookie('req_user_type', <?php echo intval($_GET['reg']); ?>, { expires: 1, path: '/' });
            }
            else {
                $.cookie('req_user_type', <?php echo intval($_GET['reg']); ?>, { expires: 1, path: '/' });
            }
        });


        <?php } ?>
    });

</script>