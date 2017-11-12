<div class="tree_line net_header" style="display:none;">
            <div style="width: 20px; padding-left: 2px;">
                <i class="glyphicon glyphicon-cog"></i>
            </div>
            <div style="width: 40px;">
                ID
            </div>
            <div style="width: 500px;">
                Name (Description)
            </div>
            <div style="width: 500px;">
                Price ($)
            </div>
        </div>
        <div class="sortable">
            <?php foreach ($tree_res as $info_sub_row) { ?>
                <div class="row_item">
                    <div class="tree_line">
                        <?php if ($info_sub_row['haschild'] > 0) { ?>
                            <div style="width: 20px;">
                                <a class="icon-chevron-right glyphicon glyphicon-chevron-right show_children" item_id="<?=$info_sub_row['id']?>"></a>
                            </div>
                        <?php } else { ?>
                            <div style="width: 20px;">
                                <a class="icon-file glyphicon glyphicon-file" href="/net/id/<?=$info_sub_row['id']?>"></a>
                            </div>
                        <?php } ?>
                        <div style="width: 40px;">
                            <?=$info_sub_row['id']?>
                        </div>
                        <div style="width: 500px;">
                            <a href="#<?=$info_sub_row['id']?>">
                                <?=$info_sub_row['name']?>
                            </a>
                            <a class="icon-edit glyphicon glyphicon-edit edit_field" style="display: none;"></a>
                            <a class="icon-info glyphicon glyphicon-info-sign info_field" style="display: none;" href="/info/id/<?=$info_sub_row['id']?>"></a>
                            <a class="icon-remove glyphicon glyphicon-remove del_field" style="display: none;"></a>
                            <!-- [99]
                                                <div style="font-size: 10px; color: #888;"><?=$info_sub_row['info_desc']?></div>
                                                -->
                        </div>
                        <div style="width: 140px;">
                            <?=$info_sub_row['price']?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div style="font-size: 11px; display: none;" class="add_btn">
            <a onclick="$(this).parent().next().show();$(this).hide();"><i class="glyphicon glyphicon-plus"></i> Add New...</a>
        </div>
        <div class="add" style="display: none;">
            <div class="tree_line">
                <input type="text">
                <a class="btn btn-xs btn-success">ADD</a>
            </div>
        </div>