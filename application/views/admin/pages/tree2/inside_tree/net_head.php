<style>
    .tree_line {

        border: 1px solid silver;
        margin: 2px;
        cursor: pointer;
        background-color: #ffffff;
    }
    .child_tree {
        /*
        border: 1px solid silver;
        */
        margin-left: 3px;
        padding-left: 1px;
        border-left: 1px solid silver;
    }

    .tree_line:hover {
        background: #efe;
    }

    .tree_line > div {
        display: inline-block;
        border-right: 1px solid silver;
        padding: 3px;
    }
    .parent_net_element {
        background: #eee;
        font-weight: bold;
    }
    .tree_line a {
        color: #333;
    }
    .tree_line a.glyphicon {
        color: #337ab7;;
    }
    .tree_line a.btn-success {
        color: #fff;;
    }
    a.show_children:hover, a.special_add:hover, a.hide_children:hover {
        text-decoration: underline;
    }
</style>