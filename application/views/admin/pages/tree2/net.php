<div class="comments_block_container article_pattern">

    <div class="article_content wbgs1">
        <div>
            <a class="btn btn-xs btn-warning edit_tree">Edit Tree</a>
            <input type="checkbox" onclick="if (!$(this).is(':checked')) $('.net_header').hide(); else $('.net_header').show();"> <a onclick="$(this).prev().click();">Show Headers</a>
        </div>

        <b class="f18 ">
            <?=$page_row['name']?>
        </b>

        <div class="tree_holder">



            <?php $this->load->view('admin/pages/tree2/tree_table'); ?>

        <br />
        <a href="javascript:history.back()">&lt;&lt; Back to Base View</a>
    </div>
</div>

