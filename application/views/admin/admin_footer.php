
<!-- Scripts Libraries-->
<script src="/files/admin/js/jquery-3.1.1/jquery-3.1.1.min.js"></script>
<script src="/files/admin/js/jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="/files/admin/js/bootstrap-3.3.7/js/bootstrap.js"></script>
<script src="/files/admin/js/bootstrap-select-1.12.2/bootstrap-select.js"></script>

<script src="/files/inside/js/bootstrap-typeahead.min.js"></script>

<!-- Add timepicker -->
<script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-sliderAccess.js"></script>

<!-- Geo complete -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCujX_HHmvBXud51cZPZjtfSXZELyZY9kQ&libraries=places&language=ru&region=RU" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

<script src="/files/inside/js/jquery.form.js"></script>
<script src="/files/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="/files/inside/js/inside_framework.js"></script>

<!-- Code highliter -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ext-language_tools.js"></script>

<script src="/files/inside/js/autosize/autosize.js" type="text/javascript"></script>

<!-- Custom Scripts files -->
<script src="/files/admin/js/scripts.js" type="text/javascript"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.js"></script>
-->
<script>
    $( document ).ready(function() {

        // Sidebar Menu
        var toggle = true;
        $(".sidebar-icon").on( "click", function() {
            $(".sidebar-icon .fa").toggleClass("fa fa-times fa fa-bars");
            if (toggle){
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                $("#menu span").css({"position":"relative"});
                $(".submenu_icon").removeClass("fa-angle-up").addClass("fa-angle-down");
            }else{
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $(".submenu").slideUp();
                $(".submenu_icon").removeClass("fa-angle-up").addClass("fa-angle-down");
                setTimeout(function() {
                    $("#menu span").css({"position":"absolute"});
                }, 400);
            }
            toggle = !toggle;
        });

        $(".submenu_toggle").on( "click", function() {
            $(this).parent().next().slideToggle();
            $(this).parent().find(".submenu_icon").toggleClass("fa-angle-up fa-angle-down");

        });

        // Advanced filters
        $(".filters_button").on( "click", function() {
            $(".advanced_filters").slideToggle("fast").toggleClass("overflow_hide");
        });

        $(".advanced_filters .cloce_btn").on( "click", function() {
            $(".advanced_filters").slideUp("fast");
            $('body').removeClass('overflow_hide');
        });

        $(".mob_filrer_btn").on( "click", function() {
            $(".advanced_filters").slideDown("fast");
            $('body').addClass('overflow_hide');
        });

        // Datepicker
        $(".has_datepicker").datepicker();

        $("#menu input.menu_search").on("keydown", function(){
            var id = 'menu_search';
            var query = $(this).val();
            if (pdg_timer[id] !== undefined) clearTimeout(pdg_timer[id]);
            pdg_timer[id]=setTimeout(function(){

                $.get("/admin/ajax/menu_search/?query="+encodeURI(query), function(data){

                    var obj = $.parseJSON(data);

                    // alert(obj.html);
                    if (obj.html !== '') {
                        $('.inside_menu_search').html(obj.html);
                        $('.inside_menu').hide();
                    } else {
                        $('.inside_menu_search').html('');
                        $('.inside_menu').show();
                    }
                })

            },700);
        });

        $('header input.top_search').typeahead({
            ajax: '/admin/ajax/menu_search_type/',
            displayField: 'name',
            valueField: 'url',
            onSelect: function(data){
                // dump_alert(data);
                location.href = data.value;

            }
        });

    });
</script>

<script>

    // Debug Function
    function dump_alert(obj) {
        var out = "";
        if(obj && typeof(obj) == "object"){
            for (var i in obj) {
                out += i + ": " + obj[i] + "\n";
            }
        } else {
            out = obj;
        }
        alert(out);
    };

</script>