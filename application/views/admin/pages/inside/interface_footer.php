<link rel="stylesheet" href="/files/inside/css/ui.multiselect.css">
<link rel="stylesheet" href="/files/inside/css/ui.combobox.css">
<!--chosen-->
<link rel="stylesheet" href="/files/jquery_chosen/chosen.min.css">

<script src="/files/inside/js/jquery.dialog.extra.js"></script>


<script src="/files/inside/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/files/inside/js/scrollTo/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="/files/inside/js/ui.multiselect.js"></script>
<script type="text/javascript" src="/files/inside/js/ui.combobox.js"></script>
<script type="text/javascript" src="/files/inside/js/advanced.js"></script>
<!--chosen-->
<script type="text/javascript" src="/files/jquery_chosen/chosen.jquery.min.js"></script>

<script src="/files/inside/js/jquery.stickytableheaders.min.js" type="text/javascript"></script>

<script>

    // JavaScript for Inside System + PowerDataGrid v. 2.1.
    // Swith off async AJAX
    $.ajaxSetup({async: false});

    var test_settings = {'geo': true};

    var global_pdg_table = $('#pdg_table').val();

    $(document).ready(function () {

        // Show main tab
        $('.nav-tabs li:eq(1) a').tab('show');

        $('.pdg_mass_functions').on('click', function () {
            console.log(inside_make_selected_string());
        });

        //open edit dialog from site
        if(Number(getUrlParameter('site_open')) > 0) {
            open_edit_dialog(getUrlParameter('site_open'), global_pdg_table);
        }

        // изначально эта переменная была здесь!!!
        //var pdg_table = $('#pdg_table').val();

        // Send First Control Form
        inside_send_control_form();

        // --------------------------------------------------------- CONTROL FORM actions --------------------
        // Send Button Click
        $("#pdg_send").on('click', inside_send_control_form);
        // Order Column Click
        $("#inside_terminal").on('click', '.pdg_column_header', function () {
            $("#pdg_order").val($(this).attr('column'));
            if ($("#pdg_asc").val() == 'asc') $("#pdg_asc").val('desc');
            else {
                if ($("#pdg_asc").val() == 'desc') $("#pdg_asc").val('asc');
            }
            inside_send_control_form();
        });
        // Fast Search
        $("#pdg_fsearch").on("keydown", function () {
            if (pdg_timer[this.id] !== undefined) clearTimeout(pdg_timer[this.id]);
            pdg_timer[this.id] = setTimeout("inside_send_control_form()", 700);
        });
        // Select Limit
        $("#pdg_limit").on("keydown", function () {
            if (pdg_timer[this.id] !== undefined) clearTimeout(pdg_timer[this.id]);
            pdg_timer[this.id] = setTimeout("inside_send_control_form()", 700);
        });

        // Page Prev
        $("#pdg_page_prev").on("click", function () {
            if ($('#pdg_page').val() > 1) {
                var tmp_page = parseInt($('#pdg_page').val()) - 1;
                $('#pdg_page').val(tmp_page);
                $('#pdg_page_text').html(tmp_page);
                inside_send_control_form();
            }
        });

        // Page Next
        $("#pdg_page_next").on("click", function () {
            if (1) {
                var tmp_page = parseInt($('#pdg_page').val()) + 1;
                $('#pdg_page').val(tmp_page);
                $('#pdg_page_text').html(tmp_page);
                inside_send_control_form();
            }
        });

        // --------------------------------------------------------- TERMINAL table actions --------------------


        // Click on Line
        $("#inside_terminal").on('click', 'tr.table_row', function () {
            var line = $(this);
            if (!line.hasClass('hover_line')) {
                line.addClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', true);
            }
            else {
                line.removeClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', false);
            }
        });
        $("#inside_terminal").on('click', '.pdg_column_checkbox', function (e) {
            // Stop more Events
            e.stopPropagation();
        });

        // Add Button
        $(".add_btn").on('click', function () {
            open_add_dialog(global_pdg_table)
        });

        // Copy Button
        $(".pdg_bcopy").on('click', function () {
            $('input:checkbox:checked.pdg_column_checkbox').each(function () {
                open_copy_dialog(this.value, global_pdg_table);
            });
        });
        $('#inside_terminal').on('click', '.mobile_copy_btn', function () {
            open_copy_dialog($(this).attr('line_id'), global_pdg_table);
        });

        // Mobile delete
        $('#inside_terminal').on('click', '.mobile_del_btn', function (e) {

            var mob_line_id = $(this).attr('line_id');

            var input = '<input type="hidden" name="del_ids[]" value="' + mob_line_id + '" />';
            var text = "Selected cell ID: <br />" + mob_line_id;
            var button = '<br /><br /><div class="del_btn_div"><input type="button" class="btn btn-danger cell_tab_submit" tabindex="-1" dialog_id="' + dialog_id + '" value="Delete" /></div>';

            // Make Dialog
            $("<div cell_id='" + mob_line_id + "'><form method='post' action='/inside2/del_request/" + global_pdg_table + "/' dialog_id=" + dialog_id + ">" + text + input + button + "</form></div>").dialog({
                autoOpen: true,
                title: 'Delete fields',
                width: 300,
                height: 200,
                canMinimize: true,
                canMaximize: true,
                position: {
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
            // Dialog Shift
            dialog_shift();
        });

        // Delete Elements
        $(".pdg_bdel").on('click', function () {

            var del_ids = "";
            var input = "";

            $('input:checkbox:checked.pdg_column_checkbox').each(function () {
                del_ids = del_ids + this.value + ', ';
                input += '<input type="hidden" name="del_ids[]" value="' + this.value + '" />';
            });

            var text = "Selected cells IDs: <br />" + del_ids.slice(0, -2);
            var button = '<br /><br /><div class="del_btn_div"><input type="button" class="btn btn-danger cell_tab_submit" tabindex="-1" dialog_id="' + dialog_id + '" value="Delete" /></div>';

            // Make Dialog
            $("<div cell_id='" + this.value + "'><form method='post' action='/inside2/del_request/" + global_pdg_table + "/' dialog_id=" + dialog_id + ">" + text + input + button + "</form></div>").dialog({
                autoOpen: true,
                title: 'Delete fields',
                width: 300,
                height: 200,
                canMinimize: true,
                canMaximize: true,
                position: {
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
            // Dialog Shift
            dialog_shift();

        });

        // ------------------------------------  CRUD Edit, Delete Dialogs Load ---------------------------------

        // Dbl Clink on Line
        $("#inside_terminal").on('dblclick', '.pdg_column_cell', function () {
            open_edit_dialog($(this).attr('line_id'), global_pdg_table);
        });

        // Edit Button
        $("#inside_terminal").on('click', '.pdg_button_edit', function () {
            open_edit_dialog($(this).attr('line_id'), global_pdg_table);
        });

        // Update Edit Dialog
        $("body").on('click', '.edit_dialog_update', function () {
            update_edit_dialog($(this).attr('line_id'), $(this).attr('dialog_id'), $(this).attr('table'))
        });

        // ------------------------------------  Edit, Delete Dialogs Requsts Answers ----------------------------


        $("body").on('click', '.cell_tab_submit', function () {

            $(this).attr('disabled', 'disabled');

            // Update HTML Editor if it created
            for (var instanceName in CKEDITOR.instances)
                CKEDITOR.instances[instanceName].updateElement();
            // Send Form data for Update or Add
            //var inside_temporary_dialog_message = 'Error';
            var inside_temporary_dialog_message;
            that = $(this);
            $(this).parent().parent().ajaxSubmit({
                error: function () {
                    inside_temporary_dialog_message = 'Error';
                    inside_temporary_dialog(inside_temporary_dialog_message);
                },
                success: function (data) {
                    if (!data) {
                        inside_temporary_dialog_message = 'Access Denied';
                    } else {
                        if($('<div />').html(data).find('.activity').length > 0) {
                            var activity = $(data).filter('.activity');
                            $(".activity_comments_holder").prepend(activity);
                        }
                        inside_temporary_dialog_message = 'Data Saved!';
                    }
                    inside_temporary_dialog(inside_temporary_dialog_message);
                    setTimeout(function () {
                        that.removeAttr('disabled');
                    }, 1500);
                }
            });

            // Add activity
            /*var mess_holder = $(".ui-dialog .activity_comments_holder");
             $('form[tab_id="activities"]').ajaxSubmit({
             success: function(data) {
             mess_holder.prepend(data);
             //Delete message 'OK!' on the end
             $('.activity_comments_holder font').remove();
             }
             });*/

            //inside_temporary_dialog(inside_temporary_dialog_message);
        });

        // Chat Add Comment
        $("body").on('click', ".add_chat_comment .add_comment", function () {

            var mess_holder = $(this).parent().children(".comments_holder");

            $(this).parent().ajaxSubmit({
                success: function (data) {
                    mess_holder.prepend(data);
                }
            });
            inside_temporary_dialog('Data Saved!');
        });

        // Access Edit Data
        $("body").on('click', ".edit_access", function () {

            var table = $(this).parent().children("table");

            $(this).parent().ajaxSubmit({
                success: function (data) {
                    table.prepend(data);
                }
            });
            inside_temporary_dialog('Data Saved!');
        });

        // Access Add Rule
        $("body").on('click', ".add_edit_rule", function () {

            var tr_copy = $(this).parent().children("table").children("tbody").children("tr").eq(1).clone();
            $(this).parent().children("table").children("tbody").append(tr_copy);
            // alert (tr_copy.html());

        });

        // Access Del Rule
        $("body").on('click', ".del_edit_rule", function () {
            if (typeof ($(this).parent().parent().parent().children("tr").eq(2).html()) !== 'undefined') {
                $(this).parent().parent().remove();
            }
        });

        // Click ALL
        $('#inside_terminal').on('click', 'input#box0', function () {

            var check_all = this;
            var line = $(this);

            if (check_all.checked) {
                $('.pdg_column_checkbox').prop("checked", true);
                $("#inside_terminal tr.table_row").addClass('hover_line');
            } else {
                $('.pdg_column_checkbox').prop("checked", false);
                $("#inside_terminal tr.table_row").removeClass('hover_line');
            }
        });

        $('#inside_terminal').on('click', '.pdg_column_checkbox_label', function (e) {
            e.stopPropagation();
            $(this).prev().trigger('click');
        });


        $('#inside_terminal').on('click', '.pdg_column_cell', function (e) {
            $(this).find('.crud_edit_btn').trigger('click');
        });

        $('#inside_terminal').on('click', '.crud_edit_btn', function (e) {
            var table_text = $(this).next();
            var new_value = prompt('', table_text.html());
            if (new_value !== null) {
                $.post('/inside2/fast_edit/', {
                    table: '<?=$table_name?>',
                    column: $(this).attr('column'),
                    key_id: $(this).attr('key_id'),
                    line_id: $(this).attr('line_id'),
                    value: new_value
                }, function () {
                    table_text.html(new_value);
                });
            }
            e.stopPropagation();
        });


        $(".dropdown-menu").on('mouseover', function () {
            var items = inside_make_selected_array().length;
            if(items < 1) {
                $(this).find('#change_mass_status').prop('disabled',true);
                $(this).find('#change_mass_status').attr('title','Выберите элементы для смены статуса!');
                $(this).find('#change_mass_access').prop('disabled',true);
                $(this).find('#change_mass_access').attr('title','Выберите элементы для смены прав доступа!');
            } else if(items > 0) {
                $(this).find('#change_mass_status').prop('disabled',false);
                $(this).find('#change_mass_status').removeAttr('title');
                $(this).find('#change_mass_access').prop('disabled',false);
                $(this).find('#change_mass_access').removeAttr('title');
            }
        });

        // Mass change access
        $("body").on('change','#change_mass_access', function () {
            var ids = inside_make_selected_array();
            var value = parseInt($(this).val());
            if(ids.length > 0) {
                $.post('/admin/inside2_ajax/change_mass_access', {
                    ids: ids,
                    access_value: value,
                    table: global_pdg_table
                }).done(function (data) {
                    if(data) {
                        var obj = JSON.parse(data);
                        inside_temporary_dialog_with_time(obj.message, 2500);
                    }
                }).fail(function() {
                    inside_temporary_dialog('Ошибка');
                })
            }
            // Reset select value
            $('option',this).prop('selected', function() {
                return this.defaultSelected;
            });
        });

        // Mass change status
        $("body").on('change','#change_mass_status', function () {
            var ids = inside_make_selected_array();
            var status = parseInt($(this).val());
            var color = $('option:selected', this).attr('color');
            var div_color = $('option:selected', this).attr('div-color');
            if(ids.length > 0) {
                $.post('/admin/inside2_ajax/change_mass_status', {
                    ids: ids,
                    status_value: status,
                    table: global_pdg_table
                }).done(function (data) {
                    if(data) {
                        var obj = JSON.parse(data);
                        if (obj.update) {
                            if ($(window).width() > 1007) {
                                $.each(obj.update, function (index, value) {
                                    $('.status_select[line_id=' + value + ']').find('select').val(status);
                                    $('.status_select[line_id=' + value + ']').closest('.table_cell').closest('tr').children('td').css('background-color', color);
                                    $('.status_select[line_id=' + value + ']').children('.status_line').css('background-color', div_color);
                                });
                            } else {
                                $.each(obj.update, function (index, value) {
                                    $('.status_select[line_id=' + value + ']').find('select').val(status);
                                    $('.status_select[line_id=' + value + ']').closest('.table_cell').css('background-color', color);
                                    $('.status_select[line_id=' + value + ']').children('.status_line').css('background-color', div_color);
                                });
                            }
                        }
                        inside_temporary_dialog_with_time(obj.message, 2500);
                    }
                }).fail(function() {
                    inside_temporary_dialog('Ошибка');
                })
            }
            // Reset select value
            $('option',this).prop('selected', function() {
                return this.defaultSelected;
            });
        });


// End of Ready.Document Functions
    });

    //=============================================================================
    // -------------------------------------     FUNCTIONS    -------------------------------------------------------------
    // Open ADD tabs Forms in Dialog ---------------------------------------------------------------------------------
    function open_add_dialog(pdg_table) {
        var dialog_height;
        var screen_width = $(document).width();
        if (screen_width > 800) screen_width = 800;
        if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

        $("<div dialog_id='" + dialog_id + "'></div>").dialog({
            autoOpen: true,
            title: 'Добавить запись',
            width: screen_width,
            height: dialog_height,
            canMinimize: true,
            canMaximize: true,
            position: {
                my: "top",
                at: "top",
                of: document,
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // AJAX load information
        var array = {pdg_table: pdg_table, dialog_id: dialog_id};
        $.post('/inside2/add_dialog/', array, function (data) {
            // Add new AJAX Data
            $('div[dialog_id=' + dialog_id + ']').html(data);
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
        // Dialog Shift
        dialog_shift();
    }

    // Open COPY tabs Forms in Dialog ---------------------------------------------------------------------------------
    function open_copy_dialog(tmp_line_id, pdg_table) {
        var dialog_height;
        var screen_width = $(document).width();
        if (screen_width > 800) screen_width = 800;
        if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

        $("<div dialog_id='" + dialog_id + "'></div>").dialog({
            autoOpen: true,
            title: 'Копировать #' + tmp_line_id,
            width: screen_width,
            height: dialog_height,
            canMinimize: true,
            canMaximize: true,
            position: {
                my: "top",
                at: "top",
                of: document,
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // AJAX load information
        var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};
        $.post('/inside2/add_dialog/' + tmp_line_id, array, function (data) {
            // Add new AJAX Data
            $('div[dialog_id=' + dialog_id + ']').html(data);
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
        // Dialog Shift
        dialog_shift();
    }

    // Open Edit tabs Forms in Dialog ---------------------------------------------------------------------------------
    function open_edit_dialog(tmp_line_id, pdg_table) {

        if ($('.dialog_edit[edit_id=' + tmp_line_id + ']').length > 0 && global_pdg_table == pdg_table) {
            alert('Dialog already Opened!');
        }
        else {

            var dialog_height;
            var screen_width = $(document).width();
            if (screen_width > 800) screen_width = 800;
            if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

            $("<div dialog_id='" + dialog_id + "'></div>").dialog({
                autoOpen: true,
                title: 'Редактировать #' + tmp_line_id,
                width: screen_width,
                height: dialog_height,
                canMinimize: true,
                canMaximize: true,
                position: {
                    my: "top",
                    at: "top",
                    of: document,
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });

            // AJAX load information
            var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};

            update_edit_dialog(tmp_line_id, dialog_id, pdg_table);

            dialog_shift();
        }
    }

    // Update Edit tabs Forms in Dialog ---------------------------------------------------------------------------------
    function update_edit_dialog(tmp_line_id, dialog_id, pdg_table) {
        //dump_alert(pdg_table);
        $('div[dialog_id=' + dialog_id + ']').html('...');
        // AJAX load information
        var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};
        $.post('/inside2/edit_dialog/', array, function (data) {
            $('div[dialog_id=' + dialog_id + ']').html(data);
            $('div[dialog_id=' + dialog_id + ']').show();
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
    }

    // Temporary Dialog message
    function inside_temporary_dialog($message) {
        $("<div class='success_info' dialog_id=" + dialog_id + "><b>" + $message + "</b></div>").dialog({
            autoOpen: true,
            title: 'Сообщение',
            width: 200,
            height: 90,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        setTimeout("$('.success_info[dialog_id=" + dialog_id + "]').fadeIn('slow', function(){$(this).remove()})", 1200);
        dialog_id++;
    }

    function inside_temporary_dialog_with_time($message, $time) {
        $("<div class='success_info' dialog_id=" + dialog_id + "><b>" + $message + "</b></div>").dialog({
            autoOpen: true,
            title: 'Сообщение',
            width: 230,
            height: 110,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        setTimeout("$('.success_info[dialog_id=" + dialog_id + "]').fadeIn('slow', function(){$(this).remove()})", $time);
        dialog_id++;
    }
    //=====================================================================

    // Get CRUD by AJAX
    function inside_send_control_form() {
        $('#inside_terminal').animate(
            {
                opacity: 0.1,
            }, 200, function () {

                var options = {
                    target: "#inside_terminal",
                    url: "/inside2/scope/",
                    success: function () {

                        // Resizable
                        $(".pdg_column").resizable({handles: 'e'});

                        // Add fixed table-head
                        $(".stickytable").stickyTableHeaders();
                    }
                };
                // передаем опции в  ajaxSubmit
                $("#control_form").ajaxSubmit(options);

                $('#inside_terminal').animate({opacity: 1}, 500);
            });
    };

    function refresh_control_form() {

        $('#control_form')[0].reset();

        $('#control_form').find('.selectpicker').each(function () {

            $(this).val('').selectpicker('refresh');

        });

    }

    // INSIDE FUNCTIONS
    function inside_make_selected_array() {
        var ids = [];

        $('input:checkbox:checked.pdg_column_checkbox').each(function () {
            ids.push(this.value);
        });

        return ids;
    }

    function inside_make_selected_string() {
        var ids = "";

        $('input:checkbox:checked.pdg_column_checkbox').each(function () {
            ids += this.value + ', ';
        });

        return $.trim(ids).replace(/^,|,$/g,''); //обрезает запятые  с начала и конца
    }

    function form_dialog(html, width, height, title, div_class) {
        // Make Dialog
        $('<div class="' + div_class + '" >' + html + '</div>').dialog({
            autoOpen: true,
            title: title,
            width: width,
            height: height,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // Dialog Shift
        dialog_shift();
    }


    // GET PARAMETERS
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    // Prevent double click
    /*var timer;
     var status = 1;

     function singleClick(event,that) {
     status = 1;
     timer = setTimeout(function() {
     if (status == 1) {
     // Update HTML Editor if it created
     for (var instanceName in CKEDITOR.instances)
     CKEDITOR.instances[instanceName].updateElement();
     // Send Form data for Update or Add
     //var inside_temporary_dialog_message = 'Error';
     var inside_temporary_dialog_message;
     $(that).parent().parent().ajaxSubmit({
     error: function () {
     inside_temporary_dialog_message = 'Error';
     },
     success: function (data) {
     if (!data) {
     inside_temporary_dialog_message = 'Access Denied';
     } else {
     inside_temporary_dialog_message = 'Data Saved!';
     $(".activity_comments_holder").prepend(data);
     //Delete message 'OK!' on the end
     $('.activity_comments_holder font').remove();
     }
     }
     });

     // Add activity
     /!*var mess_holder = $(".ui-dialog .activity_comments_holder");
     $('form[tab_id="activities"]').ajaxSubmit({
     success: function(data) {
     mess_holder.prepend(data);
     //Delete message 'OK!' on the end
     $('.activity_comments_holder font').remove();
     }
     });*!/
     inside_temporary_dialog(inside_temporary_dialog_message);
     }
     }, 500);

     }

     function doubleClick(event) {
     clearTimeout(timer);
     status = 0;
     inside_temporary_dialog('Please, save in one click!!!');
     }*/


    /*if($(document).width() <= 800) {
        $('body').on('mouseover','.ui-dialog', function () {
            console.log('over');
           //$(this).css('overflow', 'auto');
           $('body').css('overflow', 'auto');
        });
        $('body').on('mouseout','.ui-dialog', function () {
            console.log('out');
            //$(this).css('overflow', 'hidden');
            $('body').css('overflow', 'hidden');
        });
    }*/
</script>
		