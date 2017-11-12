<!--temp-->
<?php $this->load->view('admin/pages/tree2/inside_tree/net_head'); ?>


<div class="comments_block_container article_pattern">

    <div class="article_content wbgs1">
        <!--<div class="pull-right" style="margin-bottom: 10px;">
            <a class="btn btn-xs btn-warning edit_tree">Edit Tree</a>
            <input style="display: none;" type="checkbox" onclick="if (!$(this).is(':checked')) $('.net_header').css('display', 'none'); else $('.net_header').css('display', 'flex');"> <a class="btn btn-info" onclick="$(this).prev().click();">Show Headers</a>
        </div>
<div class="clearfix"></div>-->

        <!--<b class="f18 ">
            <? /*=$page_row['name']*/ ?>
        </b>-->

        <div class="tree_holder" config_key="<?= $table_config['key'] ?>" <?php if(isset($is_admin)) echo "admin='true'";?>>

            <?php $this->load->view('admin/pages/tree2/inside_tree/tree_table');?>

            <br/>
            <!--<a href="javascript:history.back()">&lt;&lt; Back to Base View</a>-->
            <a class="btn btn-sm btn-info" href="/inside2/table/<?= $table_name ?>">Back to Base View</a>
        </div>
    </div>

    <!--temp-->
    <div style="clear:both;"></div>
    <div style="font-size:9px; margin-top:12px;" id="debug_div">
        <?php echo "SQL:" . $sql; ?>
        <br/>
        <?php echo $debug; ?>
    </div>

    <!--temp-->
    <?php $this->load->view('admin/pages/tree2/inside_tree/net_footer'); ?>

