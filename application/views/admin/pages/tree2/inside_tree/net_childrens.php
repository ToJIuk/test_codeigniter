<?php $this->load->view('admin/pages/tree2/inside_tree/tree_table'); ?>


<div style="height: 3px; background: #aaa;"></div>
<script>
    $(function () {

        $(".sortable").sortable({
                update: function (event, ui) {


                    /*var ar = [];
                     var that = ui.item;
                     while (that.prev().children().attr('line_id') !== undefined) {
                     ar.push(that.prev().children().attr('line_id'));
                     that = that.prev();
                     }
                     console.log(ar);*/

                    var ar_prev = [];
                    var ar_next = [];
                    var that;
                    ui.item.prevAll().each(function () {
                        ar_prev.push($(this).children().attr('line_id'));
                    });

                    ui.item.nextAll().each(function () {
                        ar_next.push($(this).children().attr('line_id'));
                    });

                   if(ar_prev[0] !== undefined && ar_next[0] !== undefined) {

                       that = {
                           'id_self': ui.item.children().attr('line_id'),
                           'id_next': ui.item.next().children().attr('line_id'),
                           'id_prev': ui.item.prev().children().attr('line_id'),
                           'ar_prev': ar_prev,
                           'ar_next': ar_next
                       };

                    } else if (ar_prev[0] !== undefined && ar_next[0] === undefined) {

                       that = {
                           'id_self': ui.item.children().attr('line_id'),
                           'id_prev': ui.item.prev().children().attr('line_id')
                       };

                    } else if (ar_prev[0] === undefined && ar_next[0] !== undefined) {
                       that = {
                           'id_self': ui.item.children().attr('line_id'),
                           'id_next': ui.item.next().children().attr('line_id')
                       };
                    }

                    // ajax
                    $.ajax({
                        type: "POST",
                        url: '/inside_tree/change_priority/' + global_pdg_table,
                        data: {that: that}
                    });

                }
            }
        );

    });
</script>
