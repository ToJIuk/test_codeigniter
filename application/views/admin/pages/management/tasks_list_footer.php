<script>

    
    $(function(){

        $('.add_btn').on('click', function(){

            var that = $(this);
            that.hide();

            var add_form = $(this).parent().parent().parent();
            add_form.find('.msg').html('loading...');
            var options = {
                url: "/m_tasks/add_request/",
                success: function(data) {
                    add_form.find('.msg').html(data);
                    that.next().show();;
                }
            };
            add_form.ajaxSubmit(options);

        });

        $('.edit_btn').on('click', function(){

            var that = $(this);
            var row_line = that.parent().parent();


            $.get('<?=$lang_link_prefix?>/m_tasks/edit_form/'+row_line.attr('row_id'), function(data){
                row_line.next().children().children().html(data);
            });

        });

        $('.all_list').on('click', '.cancel_btn', function(){
            $(this).parent().parent().parent().html('');
        });

        $('.all_list').on('click', '.edit_request_btn', function(){

            var edit_form = $(this).parent().parent().parent();
            edit_form.find('.msg').html('loading...');
            var options = {
                url: "/m_tasks/edit_request/"+edit_form.attr('row_id'),
                success: function(data) {
                    edit_form.find('.msg').html(data);
                    edit_form.parent().find('.edit_btn').click();
                }
            };
            edit_form.ajaxSubmit(options);
        });

        $('.all_list').on('click', '.del_btn', function(){
            var edit_form = $(this).parent().parent().parent();
            if (confirm('Are you sure ???')) {
                edit_form.find('.msg').html('loading...');
                $.get("/m_tasks/del_request/"+edit_form.attr('row_id'), function(data){
                    // edit_form.prev().prev().remove();
                    edit_form.parent().remove();
                });
            }

        });

        $('.go_filter').on('click', function(){
            document.getElementById('filter_form').submit();
        });

        $('.o_cells').on('dblclick', function(){
            if ($(this).parent().next().next().html() == '') {

                $(this).parent().find('.edit_btn').click();

            } else {
                $(this).parent().next().next().find('.cancel_btn').click();
            }

        });

    });

</script>