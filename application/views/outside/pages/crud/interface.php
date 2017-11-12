

<div class="crud2_header">

    <?php if (isset($filter_form)) { ?>
    <a class="filter_toggle btn btn-info btn-xs" onclick="$('.filters_form').toggle();">Filter</a>
    <?php } ?>

    <a class="btn btn-success btn-xs" href="/crud/addform">Add</a>

    <?php if (isset($help_info)) { ?>
        <a class="help_toggle btn btn-warning btn-xs" onclick="$('.help_info').toggle();">Help!</a>
    <?php } ?>

    <?php if (isset($filter_form)) { ?>
    <form class="filters_form" action="" method="GET" style="display:none;">
        <?=$filter_form?>
    </form>
    <?php } ?>

    <?php if (isset($help_info)) { ?>
        <div class="help_info" style="display:none;">
            <?=$help_info?>
        </div>
    <?php } ?>


</div>

<div class="crud2_table"></div>

<div class="crud2_footer">
    <?=$pagination?>
</div>
