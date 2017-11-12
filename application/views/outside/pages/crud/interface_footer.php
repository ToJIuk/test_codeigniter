<link rel="stylesheet" href="/files/crud/css/core.css" >


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


        $('.pager .previous a').on('click', function(){
            if ( parseInt( $('.crud_page_hidden').val() ) > 1) {
                $('.crud_page_hidden').val( parseInt($('.crud_page_hidden').val()) - 1 );
                $('.pager .crud_page_cnt span').html( $('.crud_page_hidden').val() );
                crud2_get_table();
            }
        });

        $('.pager .next a').on('click', function(){
            $('.crud_page_hidden').val( parseInt($('.crud_page_hidden').val()) + 1 );
            $('.pager .crud_page_cnt span').html( $('.crud_page_hidden').val() );
            crud2_get_table();
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
