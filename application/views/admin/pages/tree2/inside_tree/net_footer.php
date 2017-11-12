<script src="/files/typeahead/bootstrap-typeahead.min.js"></script>

<script>
    $(function () {

        setTimeout(function () {
            $('.show_headers_btn').trigger('click');
        }, 200);

        var tree_busy = false;
        $('.tree_holder').on('click', '.show_children', function (e) {

            if (!tree_busy) {

                tree_busy = true;
                var that = $(this);
                var div = that.parent().parent();

                var options = {
                    url: '/inside_tree/children/' + that.attr('item_id'),
                    success: function (data) {

                        if (data != '') {

                            that.removeClass('show_children');
                            that.removeClass('glyphicon-chevron-right');

                            div.addClass('parent_net_element');

                            that.addClass('hide_children');
                            that.addClass('glyphicon-chevron-down');

                            div.after($('<div class="child_tree"></div>'));
                            var new_div = div.next();
                            new_div.append(data);

                            // expand children
                            setTimeout(function () {
                                new_div.find('.show_children').trigger('click');
                            }, 100);

                        }

                    }
                };
                // передаем опции в  ajaxSubmit
                $("#control_form").ajaxSubmit(options);

                /*$.get('/inside_tree/children/'+global_pdg_table+'/'+that.attr('item_id'), function(data){

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


                 });*/

                tree_busy = false;

            }
            e.stopPropagation();
        });

        $('.tree_holder').on('click', '.hide_children', function (e) {

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

                    if (ar_prev[0] !== undefined && ar_next[0] !== undefined) {

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
        $('.edit_tree').off('click').on('click', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $('.add_btn').hide();

                // change icons
                $('.changeable_icon_plus').css('display', 'none');
                $('.changeable_icon_file').css('display', 'block');

                /*$(".edit_field").hide();
                 $(".info_field").hide();
                 $(".del_field").hide();*/
                $(".edit_panel").css('display', 'none');
            } else {
                $(this).addClass('active');
                $('.add_btn').show();

                // change icons
                $('.changeable_icon_file').css('display', 'none');
                $('.changeable_icon_plus').css('display', 'block');

                /*$(".edit_field").show();
                 $(".info_field").show();
                 $(".del_field").show();*/
                $(".edit_panel").css('display', 'flex');
            }


        });

        $('.tree_holder').on('click', ".del_field", function (e) {
            //$(this).closest('.tree_line').remove();
            var del_id_ar = [parseInt($(this).parent().parent().parent().attr('line_id'))];

            if (confirm('Удалить?')) {
                var that = $(this);
                var those;
                $.ajax({
                    type: "POST",
                    url: '/inside_tree/del_request/' + global_pdg_table,
                    data: {del_ids: del_id_ar},
                    success: function (data) {

                        /* <//?php if(isset($table_config['agregation_field'])) { ?>

                         those = that;
                         while (those.closest('.row_item').children().attr('parent_id')) {

                         those.closest('.row_item').find('[column_name=<//?= $table_config['agregation_field']; ?>]').html('999');
                         those = those.closest('.row_item').prev();
                         }
                         <//?php } ?>*/

                        that.closest('.tree_line').remove();
                        //fix
                        //$('.tree_edit_check').prop('checked', true);
                    }
                });
            }
        });

        $('.tree_holder').on('click', ".edit_field", function (e) {
            open_edit_dialog($(this).parent().parent().parent().attr('line_id'), global_pdg_table);
            /* var new_data = prompt('Edit data');
             if (new_data) {
             $(this).prev().html(new_data);
             }
             e.stopPropagation();*/
        });

        $('.tree_holder').on('click', ".edit_column", function (e) {

            var new_data = prompt('Edit data');

            if (new_data) {
                $(this).html(new_data);
            }
            e.stopPropagation();

        });


        var timer = 0;
        var delay = 200;
        var prevent = false;
        // One click
        $('.tree_holder').on('click', '.tree_line', function () {
            timer = setTimeout(function () {
                if (!prevent) {
                    $(this).find('.hide_children, .show_children').trigger('click');
                }
                prevent = false;
            }, delay);
        })
            // One dblclick
            .on('dblclick', ".cell_content", function (e) {
                clearTimeout(timer);
                prevent = true;
                if ($('.fast_edit_check').is(':checked')) {
                    var that = $(this);
                    var new_data = prompt('Edit data', $(this).find('span').html());
                    if (new_data) {
                        $.ajax({
                            type: "POST",
                            url: '/inside_tree/fast_edit/',
                            data: {
                                key_id: $('.tree_holder').attr('config_key'),
                                line_id: that.parent().attr('line_id'),
                                table: global_pdg_table,
                                column: that.attr('column_name'),
                                value: new_data
                            },
                            success: function (data) {
                                that.find('span').html(new_data);
                            },
                            error: function (request, status, error) {
                                alert(status + ': ' + error);
                            }
                        });
                    }
                    //e.stopPropagation();
                } else {
                    open_edit_dialog($(this).parent().attr('line_id'), global_pdg_table);
                }
            });

        // add
        $('.tree_holder').on('click', '.add_btn', function () {
            var parent_id = parseInt($(this).parent().prev().attr('line_id'));
            parent_id = (parent_id > 0) ? parent_id : 0;
            //console.log(parent_id);
            open_add_dialog(global_pdg_table, parent_id);
        });

        //special add
        $('.tree_holder').on('click', '.special_add', function () {
            var parent_id = parseInt($(this).parent().parent().attr('line_id'));
            parent_id = (parent_id > 0) ? parent_id : 0;
            //console.log(parent_id);
            open_add_dialog(global_pdg_table, parent_id);
        });

        //copy
        $('.tree_holder').on('click', '.copy_field', function () {
            open_copy_dialog($(this).closest('.tree_line').attr('line_id'), global_pdg_table);
        });

        //div  click fix (Maximum call stack size exceeded)
        /*$('.tree_holder').off('click', '.action_children').on('click', '.action_children',function () {
         $(this).find('.changeable_icon_plus').click();
         });*/

        $('.tree_holder').on('click', '.checked_box', function () {
            if($(this).hasClass('default_box')) {
                if (confirm('Вы согласны?')) {
                    var element_id = $(this).closest('.tree_line').attr('line_id');
                    change_agreement_status(this,1,element_id,'default_box','success_box');
                }
            } else if($(this).hasClass('success_box')) {
                if($('.tree_holder').is('[admin]')) {
                    if (confirm('Отменить согласие?')) {
                        var element_id = $(this).closest('.tree_line').attr('line_id');
                        change_agreement_status(this, 2, element_id, 'success_box', 'danger_box');
                    }
                } else {
                    alert('У вас нет прав!')
                }
            } else if($(this).hasClass('danger_box')) {
                if (confirm('Активировать?')) {
                    var element_id = $(this).closest('.tree_line').attr('line_id');
                    change_agreement_status(this,1,element_id,'danger_box','success_box');
                }
            }
        });

        $('.tree_holder').on('click', '.remowe_users_list', function () {
            var that = $(this);
            var element_id = $(this).closest('.tree_line').attr('line_id');
            $.ajax({
                type: "POST",
                url: '/admin/inside2_ajax/get_agreed_users/'+element_id,
                data: { table: global_pdg_table},
                success: function (data){
                    if(data) {
                        console.log(data);
                        that.parent().find('.dropdown-menu').html(data);
                    }
                },
                error: function () {
                    alert('Ошибка!')
                }
            });

        });

        $('.tree_holder').on('click', '.control_user_status', function (e) {
            var that = $(this);
            var element_id = $(this).closest('.tree_line').attr('line_id');
            var user_id = $(this).parent().attr('user_id');
            if($(this).hasClass('fa-times')) {
                var status = 2;
            } else {
                var status = 1;
            }
            $.ajax({
                type: "POST",
                url: '/admin/inside2_ajax/control_user_status/'+element_id+'/'+user_id,
                data: {table: global_pdg_table, status: status},
                success: function (data){
                    var obj = jQuery.parseJSON(data);
                    if(obj.status == 2) {
                        that.removeClass("fa-times").addClass("fa-check");
                        that.css('color','#5cb85c');
                        if($('.tree_holder').is('[admin]')) {
                            that.closest('.agreement_panel_content').find('.checked_box').removeClass("success_box").addClass("danger_box");
                        }
                    } else if(obj.status == 1) {
                        that.removeClass("fa-check").addClass("fa-times");
                        that.css('color','crimson');
                        if($('.tree_holder').is('[admin]')) {
                            that.closest('.agreement_panel_content').find('.checked_box').removeClass("danger_box").addClass("success_box");
                        }
                    } else {
                        alert('Ошибка при изменении!');
                    }
                },
                error: function () {
                    alert('Ошибка!')
                }
            });
            e.stopPropagation();
        });
    });

    function change_agreement_status(that, stasus_id, element_id, remove_class, add_class) {
        $.ajax({
            type: "POST",
            url: '/admin/inside2_ajax/change_agreement_statuses/'+stasus_id+'/'+element_id,
            data: { table: global_pdg_table},
            success: function (data){
                var obj = jQuery.parseJSON(data);
                if(obj.status) {
                    $(that).attr('status_id',stasus_id);
                    $(that).removeClass(remove_class);
                    $(that).addClass(add_class);
                } else {
                    alert('У вас нет прав!')
                }
            },
            error: function () {
                alert('Ошибка!')
            }
        });
    }
    // get cookie
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

</script>