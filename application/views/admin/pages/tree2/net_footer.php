<script src="/files/typeahead/bootstrap-typeahead.min.js"></script>

<script>
    $(function(){

        setTimeout(function(){
            $('.show_children').trigger('click');
        }, 800);

        var tree_busy = false;
        $('.tree_holder').on('click', '.show_children',  function (e) {

            if (!tree_busy) {

                tree_busy = true;
                var that = $(this);
                var div = that.parent().parent();

                $.get('/crud/tree2/children/'+that.attr('item_id'), function(data){

                    if (data != '') {

                        that.removeClass('show_children');
                        that.removeClass('glyphicon-chevron-right');

                        div.addClass('parent_net_element');

                        that.addClass('hide_children');
                        that.addClass('glyphicon-chevron-down');

                        div.after($('<div class="child_tree"></div>'));
                        var new_div = div.next();
                        new_div.append(data);
                    }


                });

                tree_busy = false;

            }
            e.stopPropagation();
        });

        $('.tree_holder').on('click', '.hide_children',  function (e) {

            if (!tree_busy) {

                tree_busy = true;

                var to_hide = $(this).parent().parent().next();
                if (to_hide.hasClass('child_tree')) to_hide.remove();

                $(this).addClass('show_children');
                $(this).addClass('glyphicon-chevron-right');

                $(this).removeClass('hide_children');
                $(this).removeClass('glyphicon-chevron-down');
                e.stopPropagation();
                tree_busy = false;
            }

        });

        $('.tree_holder').on('click', '.tree_line',  function () {

            $(this).find('.hide_children, .show_children').trigger('click');

        });

        $( ".sortable" ).sortable();
        $('.edit_tree').on('click', function(){

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('.add_btn').hide();
                $(".edit_field").hide();
                $(".info_field").hide();
                $(".del_field").hide();
            } else {
                $(this).addClass('active');
                $('.add_btn').show();
                $(".edit_field").show();
                $(".info_field").show();
                $(".del_field").show();
            }


        });

        $('.tree_holder').on('click', ".edit_field", function(e){

            var new_data = prompt('Edit data');

            if (new_data) {
                $(this).prev().html(new_data);
            }
            e.stopPropagation();

        });

        $('.tree_holder').on('click', ".edit_column", function(e){

            var new_data = prompt('Edit data');

            if (new_data) {
                $(this).html(new_data);
            }
            e.stopPropagation();

        });



    });

</script>