<?php
$attributes = array(
    "name" => "categoriesForm",
    "id" => "categoriesForm"
);
$hidden = array(
    "boxChecked" => 0,
    "status" => $status
);
$search = array(
    "name" => "search",
    "id" => "search",
    "class" => "form-control",
    "value" => $key_disp,
    "placeholder" => "Search for categories"
);
$select_limit = array();
$select_limit_selected = "";
$list_limit = array(10,25,50,100,0);
foreach ($list_limit as $val) {
    if ($val == set_value("limit", $limit)) {
        $select_limit_selected = set_value("limit", $limit);
    }
    if (!$val) {
        $select_limit["{$val}"] = "All";
    } else {
        $select_limit["{$val}"] = $val;
    }
}
?>
<div class="page-title">
    <div class="row">
        <div class="col-md-6 title">
            <h3>Blog Categories</h3>
        </div>
        <div class="col-md-6 toolbox text-right">
            <?php if ($status == "trash") { ?>
            <button onclick="if (document.categoriesForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.categoriesForm.action = '<?php echo site_url("cms/blog_categories/restore") ?>';document.categoriesForm.submit();}" class="btn btn-app">
                <i class="fa fa-check"></i>
                Restore
            </button>
            <button onclick="if (document.categoriesForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else { do_delete_multi('<?php echo site_url("cms/blog_categories/delete") ?>'); }" class="btn btn-app">
                <i class="fa fa-close"></i>
                Delete
            </button>
            <?php } else { ?>
            <a href="<?php echo site_url("cms/blog_categories/edit"); ?>" class="btn btn-app">
                <i class="fa fa-plus-circle"></i>
                New
            </a>
            <button onclick="if (document.categoriesForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.categoriesForm.action = '<?php echo site_url("cms/blog_categories/publish") ?>';document.categoriesForm.submit();}" class="btn btn-app">
                <i class="fa fa-check"></i>
                Publish
            </button>
            <button onclick="if (document.categoriesForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.categoriesForm.action = '<?php echo site_url("cms/blog_categories/unpublish") ?>';document.categoriesForm.submit();}" class="btn btn-app">
                <i class="fa fa-close"></i>
                Unpublish
            </button>
            <button onclick="if (document.categoriesForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else { do_trash_multi('<?php echo site_url("cms/blog_categories/trash") ?>'); }" class="btn btn-app">
                <i class="fa fa-trash"></i>
                Trash
            </button>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /page-title -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List blog categories</h2>
            </div>
            <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">Error</h4>
                <p class="alert-message"><?php echo $this->session->flashdata('error'); ?></p>
			</div>
            <?php } ?>
            <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">Message</h4>
                <p class="alert-message"><?php echo $this->session->flashdata('message'); ?></p>
			</div>
            <?php } ?>
            <div class="x_content">
                <?php echo form_open(site_url("cms/blog_categories/search/".$status), $attributes, $hidden); ?>
                <div class="row MB10">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Status:
                            <div class="btn-group">
                                <a href="<?php echo site_url("cms/blog_categories/search/active"); ?>" class="btn btn-sm btn-success <?php if($status != "trash") { echo "active"; } ?>">Active</a>
                                <a href="<?php echo site_url("cms/blog_categories/search/trash"); ?>" class="btn btn-sm btn-danger <?php if($status == "trash") { echo "active"; } ?>">Trash</a>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                        <div id="searchCategories" class="input-group input-group-sm">
                            <?php echo form_input($search); ?>
                            <?php echo form_error($search["name"]); ?>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /control -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table jambo_table bulk_action">
                                <colgroup>
                                    <col width="5%">
                                    <col width="30%">
                                    <col width="30%" class="hidden-xs">
                                    <col width="10%">
                                    <col width="10%" class="hidden-xs">
                                    <col width="15%">
                                </colgroup>
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>
                                        <th class="column-title">Title</th>
                                        <th class="column-title hidden-xs">Description</th>
                                        <th class="column-title text-center">Published</th>
                                        <th class="column-title text-center hidden-xs">Image</th>
                                        <th class="column-title text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($count_categories > 0) { ?>
                                    <?php foreach ($categories as $key => $category) :
                                        if ($key%2 == 0) {
                                            $pos = "even";
                                        } else {
                                            $pos = "old";
                                        }
                                    ?>
                                    <tr class="<?php echo $pos; ?> pointer">
                                    <td><?php if ((!$category["delete_flag"] && $status == "active") || ($category["delete_flag"] && $status == "trash")) { ?><input type="checkbox" class="flat" name="cat_id[]" value="<?php echo $category["id"]; ?>"><?php } ?></td>
                                        <td>
                                        <?php if ($status == "trash") { ?>
                                            <?php if (!$category["delete_flag"]) { ?>
                                            <span>
                                                <?php echo $category["name"]; ?> <small>(0 Active/ 0 Trashed)</small>
                                            </span>
                                            <?php } else { ?>
                                            <strong>
                                                <?php echo $category["name"]; ?> <small>(0 Active/ 0 Trashed)</small>
                                            </strong>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url("cms/blog_categories/edit/".$category["id"]); ?>">
                                                <?php echo $category["name"]; ?> <small>(0 Active/ 0 Trashed)</small>
                                            </a>
                                        <?php } ?>
                                        </td>
                                        <td class="hidden-xs"><?php echo $category["description"]; ?></td>
                                        <td class="text-center">
                                        <?php if ($status == "trash") { ?>
                                            <?php if ($category["published"]) { ?>
                                            <span class="published btn btn-xs btn-default">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <?php } else { ?>
                                            <span class="published btn btn-xs btn-default">
                                                <i class="fa fa-close"></i>
                                            </span>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($category["published"]) { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Unpublish item" href="<?php echo site_url("cms/blog_categories/unpublish/".$category["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Publish item" href="<?php echo site_url("cms/blog_categories/publish/".$category["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-close"></i>
                                            </a>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <td class="text-center image hidden-xs">
                                            <?php 
                                            $file_dir = FCPATH.$this->out_img_dir."/";
                                            $file200 = $file_dir.$category["id"]."_200.".$category["image"];
                                            if (file_exists($file200) && $category["image"]) {
                                            ?>
                                            <img src="<?php echo base_url(); ?>images/blog/categories/<?php echo $category["id"]; ?>_200.<?php echo $category["image"]; ?>" alt="<?php echo $category["name"]; ?>">
                                            <?php } else { ?>
                                            <i class="fa fa-image"></i>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($status == "trash") { ?>
                                            <a href="<?php echo site_url("cms/blog_categories/restore/".$category["id"]); ?>" class="btn btn-xs btn-success <?php if (!$category["delete_flag"]) { echo "disabled"; } ?>">
                                                <i class="fa fa-check"></i>Retore
                                            </a>
                                            <a href="javascript:void(0)" onclick="do_delete('<?php echo site_url("cms/blog_categories/delete/".$category["id"]); ?>')" class="btn btn-xs btn-danger <?php if (!$category["delete_flag"]) { echo "disabled"; } ?>">
                                                <i class="fa fa-close"></i>Delete
                                            </a>
                                            <?php } else { ?>
                                            <a href="<?php echo site_url("cms/blog_categories/edit/".$category["id"]); ?>" class="btn btn-xs btn-warning">
                                                <i class="fa fa-edit"></i>Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="do_trash('<?php echo site_url("cms/blog_categories/trash/".$category["id"]); ?>')" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>Trash
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php } else { ?>
                                    <tr class="pointer">
                                        <td colspan="6">
                                            No data found
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /categories -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Show
                            <?php echo form_dropdown("limit", $select_limit, $select_limit_selected, "id='limit' style='padding: 5px;' onchange='this.form.submit()'"); ?>
                            entries
                        </label>
                    </div>
                    <?php if ($pagination) { ?>
                    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                        <?php echo $pagination; ?>
                    </div>
                     <!-- /pagination -->
                    <?php } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!-- /x_panel -->
<script type="text/javascript">
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
    
    $('table input').on('ifChecked', function () {
        $(this).parent().parent().parent().addClass('selected');
        $(this).attr("checked", true);
        $("input[name=boxChecked]").val($("input[name='cat_id[]']:checked").length);
    });
    $('table input').on('ifUnchecked', function () {
        $(this).parent().parent().parent().removeClass('selected');
        $(this).attr("checked", false);
        $("input[name=boxChecked]").val($("input[name='cat_id[]']:checked").length);
    });
    $('input#check-all').on('ifChecked', function () {
        $("input[name='cat_id[]']").iCheck('check');
        $("input[name='cat_id[]']").attr("checked", true);
        $("input[name=boxChecked]").val($("input[name='cat_id[]']:checked").length);
    });
    $('input#check-all').on('ifUnchecked', function () {
        $("input[name='cat_id[]']").iCheck('uncheck');
        $("input[name='cat_id[]']").attr("checked", false);
        $("input[name=boxChecked]").val(0);
    });
    
    function do_trash(url) {
        if (confirm("Do you really want to move selected category to trash?")) {
            location.href = url;
        }
    }
    
    function do_delete(url) {
        if (confirm("Do you really want to delete selected category?")) {
            location.href = url;
        }
    }
    
    function do_trash_multi(url) {
        var cnf = confirm("WARNING! You are about to trash the selected categories, their children categories and all their included items!");
        if (cnf == true) {
            document.categoriesForm.action = url;
            document.categoriesForm.submit();
        }
    }
    
    function do_delete_multi(url) {
        var cnf = confirm("WARNING! Are you sure you want to delete selected categories?");
        if (cnf == true) {
            document.categoriesForm.action = url;
            document.categoriesForm.submit();
        }
    }
</script>