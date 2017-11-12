<script type="text/javascript" src="/files/inside/js/jquery.stickytableheaders.min.js"></script>

<script>
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


        // Delete Action
        $('.crud2_table').on('click', '.del_row', function(){

            var row_line = $(this).parent().parent();
            var row_id = row_line.attr('row_id');

            if (confirm('Are you sure?')) {
                $.get('/at/table/del_request/<?=$this->input->get('table', true);?>/'+row_id, function(data){
                    obj = $.parseJSON(data);
                    if (obj.status == 'success') {
                        // row_line.next().remove();
                        row_line.remove();
                    } else alert(obj.error);

                });
            }

        });


    });

// ---------------------------------------------------------------- Functions ------------------------- // ---

    function crud2_get_table() {

        $(".filters_form").ajaxSubmit({
                url: '/at/table/data',
                type: 'get',
                success: function(data) {
                    $('.crud2_table').html(data);
                },
                error: function(xhr, status, error) {
                    $('.crud2_table').html(xhr.responseText);
                }
        });

    }

</script>