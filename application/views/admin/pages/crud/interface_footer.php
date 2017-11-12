
<script type="text/javascript">


    $(function(){

        // Load Table OnLoad
        crud2_get_table();

        // Update Table Filters Button
        $(".filter_search_btn").on('click', function(){

            crud2_get_table();

        });

        // Show Edit Form
        $('.crud2_table').on('dblclick', '.row_tr_line', function(){
            location.href = $(this).find('.edit_a_btn').attr('href');
        });

        // Delete Action
        $('.crud2_table').on('click', '.del_row', function(){

            var row_line = $(this).parent().parent();
            var row_id = row_line.attr('row_id');

            if (confirm('Are you sure?')) {
                $.get('/<?=$controller_name?>/delete/'+row_id, function(data){
                    obj = $.parseJSON(data);
                    if (obj.status == 'success') {
                        row_line.next().remove();
                        row_line.remove();
                    } else alert(obj.error);

                });
            }

        });

        $('.crud2_table').on('click', '.crud2_column_h', function(){
            if ($(this).attr('column') == $('.order_by_hidden').val()) {
                if ($('.order_by_type_hidden').val() == '') $('.order_by_type_hidden').val(1);
                else $('.order_by_type_hidden').val('');
            } else {
                $('.order_by_hidden').val($(this).attr('column'));
            }

            crud2_get_table();
        });


        $('.pager .previous').on('click', function(){
            if ( parseInt( $('.crud_page_hidden').val() ) > 1) {
                $('.crud_page_hidden').val( parseInt($('.crud_page_hidden').val()) - 1 );
                $('.pager .crud_page_cnt').html( $('.crud_page_hidden').val() );
                crud2_get_table();
            }
        });

        $('.pager .next').on('click', function(){
            $('.crud_page_hidden').val( parseInt($('.crud_page_hidden').val()) + 1 );
            $('.pager .crud_page_cnt').html( $('.crud_page_hidden').val() );
            crud2_get_table();
        });



        // Click on Line
        $(".crud2_table").on('click', 'tr.table_row' ,function() {
            var line = $(this);
            if ( ! line.hasClass('hover_line'))
            {
                line.addClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', true) ;
            }
            else
            {
                line.removeClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', false) ;
            }
        });
        $(".crud2_table").on('click', '.pdg_column_checkbox' ,function (e) {
            // Stop more Events
            e.stopPropagation();
        });
        // Click ALL
        $('.crud2_table').on('click', 'input#box0', function(e){

            var check_all = this;
            var line = $(this);

            if (check_all.checked) {
                $('.pdg_column_checkbox').prop( "checked", true );
                $("#inside_terminal tr.table_row").addClass('hover_line');
            } else {
                $('.pdg_column_checkbox').prop( "checked", false );
                $("#inside_terminal tr.table_row").removeClass('hover_line');
            }
            e.stopPropagation();
        });

        $('.crud2_table').on('click', '.pdg_column_checkbox_label', function(e){
            e.stopPropagation();
            $(this).prev().trigger('click');
        });


    });

// ---------------------------------------------------------------- Functions ------------------------- // ---

    function crud2_get_table() {

        $(".filters_form").ajaxSubmit({
            url: '/<?=$controller_name?>/table/',
            type: 'get',
            success: function(data) {
                $('.crud2_table').html(data);
            }
        });

    }

</script>
