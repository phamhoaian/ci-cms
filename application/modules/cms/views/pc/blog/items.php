<?php
$attributes = array(
    "name" => "itemsForm",
    "id" => "itemsForm"
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
    "placeholder" => "Search for items"
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
            <h3>Blog Items</h3>
        </div>
        <div class="col-md-6 toolbox text-right">
            <?php if ($status == "trash") { ?>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.itemsForm.action = '<?php echo site_url("cms/blog/restore") ?>';document.itemsForm.submit();}" class="btn btn-app">
                <i class="fa fa-check"></i>
                Restore
            </button>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else { do_delete_multi('<?php echo site_url("cms/blog/delete") ?>'); }" class="btn btn-app">
                <i class="fa fa-close"></i>
                Delete
            </button>
            <?php } else { ?>
            <a href="<?php echo site_url("cms/blog/edit"); ?>" class="btn btn-app">
                <i class="fa fa-plus-circle"></i>
                New
            </a>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.itemsForm.action = '<?php echo site_url("cms/blog/featured") ?>';document.itemsForm.submit();}" class="btn btn-app">
                <i class="fa fa-star"></i>
                Featured
            </button>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.itemsForm.action = '<?php echo site_url("cms/blog/publish") ?>';document.itemsForm.submit();}" class="btn btn-app">
                <i class="fa fa-check"></i>
                Publish
            </button>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.itemsForm.action = '<?php echo site_url("cms/blog/unpublish") ?>';document.itemsForm.submit();}" class="btn btn-app">
                <i class="fa fa-close"></i>
                Unpublish
            </button>
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else { do_trash_multi('<?php echo site_url("cms/blog/trash") ?>'); }" class="btn btn-app">
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
				<h2>
                    <i class="fa fa-list-ul"></i>
                    List blog items
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="javascript:void(0)" class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
			</div>
            <?php $this->load->view('pc/message'); ?>
            <div class="x_content">
                <?php echo form_open(site_url("cms/blog/search/".$status), $attributes, $hidden); ?>
                <div class="row MB10">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Status:</label>
                        <div class="btn-group">
                            <a href="<?php echo site_url("cms/blog/search/active"); ?>" class="btn btn-sm btn-success <?php if($status != "trash") { echo "active"; } ?>">Active</a>
                            <a href="<?php echo site_url("cms/blog/search/trash"); ?>" class="btn btn-sm btn-danger <?php if($status == "trash") { echo "active"; } ?>">Trash</a>
                        </div>
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
                                    <col width="3%">
                                    <col width="21%">
                                    <col width="5%">
                                    <col width="7%">
                                    <col width="10%">
                                    <col width="8%" class="hidden-xs">
                                    <col width="8%" class="hidden-xs">
                                    <col width="10%" class="hidden-xs">
                                    <col width="10%" class="hidden-xs">
                                    <col width="4%" class="hidden-xs">
                                    <col width="4%" class="hidden-xs">
                                    <col width="10%">
                                </colgroup>
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>
                                        <th class="column-title">Title</th>
                                        <th class="column-title text-center">Featured</th>
                                        <th class="column-title text-center">Published</th>
                                        <th class="column-title">Category</th>
                                        <th class="column-title hidden-xs">Author</th>
                                        <th class="column-title hidden-xs">Last modified by</th>
                                        <th class="column-title hidden-xs">Created</th>
                                        <th class="column-title hidden-xs">Modified</th>
                                        <th class="column-title text-center hidden-xs">Hits</th>
                                        <th class="column-title text-center hidden-xs">Image</th>
                                        <th class="column-title text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($count_items > 0) { ?>
                                    <?php foreach ($items as $key => $item) :
                                        if ($key%2 == 0) {
                                            $pos = "even";
                                        } else {
                                            $pos = "old";
                                        }
                                    ?>
                                    <tr class="<?php echo $pos; ?> pointer">
                                    	<td><input type="checkbox" class="flat" name="id[]" value="<?php echo $item["id"]; ?>"></td>
                                        <td>
                                        <?php if ($status == "trash") { ?>
                                            <span>
                                                <?php echo $item["title"]; ?>
                                            </span>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url("cms/blog/edit/".$item["id"]); ?>">
                                                <?php echo $item["title"]; ?>
                                            </a>
                                        <?php } ?>
                                        </td>
                                        <td class="text-center">
                                        <?php if ($status == "trash") { ?>
                                            <?php if ($item["featured"]) { ?>
                                            <span class="featured btn btn-xs btn-default">
                                                <i class="fa fa-star"></i>
                                            </span>
                                            <?php } else { ?>
                                            <span class="featured btn btn-xs btn-default">
                                                <i class="fa fa-star-o"></i>
                                            </span>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($item["featured"]) { ?>
                                            <a href="<?php echo site_url("cms/blog/unfeatured/".$item["id"]); ?>" class="featured btn btn-xs btn-default">
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a href="<?php echo site_url("cms/blog/featured/".$item["id"]); ?>" class="featured btn btn-xs btn-default">
                                                <i class="fa fa-star-o"></i>
                                            </a>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <td class="text-center">
                                    	<?php if ($status == "trash") { ?>
                                            <?php if ($item["published"]) { ?>
                                            <span class="published btn btn-xs btn-default">
                                                <i class="fa fa-check"></i>
                                            </span>
                                            <?php } else { ?>
                                            <span class="published btn btn-xs btn-default">
                                                <i class="fa fa-close"></i>
                                            </span>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($item["published"]) { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Unpublish item" href="<?php echo site_url("cms/blog/unpublish/".$item["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Publish item" href="<?php echo site_url("cms/blog/publish/".$item["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-close"></i>
                                            </a>
                                            <?php } ?>
                                        <?php } ?>
                                        </td>
                                        <td>
                                        	<?php echo $item["cat_name"]; ?>
                                        </td>
                                        <td>
                                        	<?php echo $item["created_by"]; ?>
                                        </td>
                                        <td>
                                        	<?php echo $item["modified_by"]; ?>
                                        </td>
                                        <td>
                                        	<?php echo date('d-m-Y H:i:s', strtotime($item["created"])); ?>
                                        </td>
                                        <td>
                                        	<?php if ($item["modified"] == "0000-00-00 00:00:00") { ?>
                                        	Never
                                        	<?php } else { ?>
                                        	<?php echo date('d-m-Y H:i:s', strtotime($item["modified"])); ?>
                                        	<?php } ?>
                                        </td>
                                        <td class="text-center">
                                        	<?php echo $item["hits"]; ?>
                                        </td>
                                        <td class="text-center image">
                                    	<?php 
                                            $file_dir = FCPATH.$this->out_img_dir."/";
                                            $file100 = $file_dir.$item["id"]."_100.".$item["image"];
                                            if (file_exists($file100) && $item["image"]) {
                                            ?>
                                            <img src="<?php echo base_url(); ?>images/blog/items/<?php echo $item["id"]; ?>_100.<?php echo $item["image"]; ?>" alt="<?php echo $item["title"]; ?>">
                                            <?php } else { ?>
                                            <i class="fa fa-image"></i>
                                        <?php } ?>
                                        </td>
                                        <td class="text-center">
                                        	<?php if ($status == "trash") { ?>
                                            <a href="<?php echo site_url("cms/blog/restore/".$item["id"]); ?>" class="btn btn-xs btn-success">
                                                <i class="fa fa-check"></i>Retore
                                            </a>
                                            <a href="javascript:void(0)" onclick="do_delete('<?php echo site_url("cms/blog/delete/".$item["id"]); ?>')" class="btn btn-xs btn-danger">
                                                <i class="fa fa-close"></i>Delete
                                            </a>
                                            <?php } else { ?>
                                            <a href="<?php echo site_url("cms/blog/edit/".$item["id"]); ?>" class="btn btn-xs btn-warning">
                                                <i class="fa fa-edit"></i>Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="do_trash('<?php echo site_url("cms/blog/trash/".$item["id"]); ?>')" class="btn btn-xs btn-danger">
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
        $("input[name=boxChecked]").val($("input[name='id[]']:checked").length);
    });
    $('table input').on('ifUnchecked', function () {
        $(this).parent().parent().parent().removeClass('selected');
        $(this).attr("checked", false);
        $("input[name=boxChecked]").val($("input[name='id[]']:checked").length);
    });
    $('input#check-all').on('ifChecked', function () {
        $("input[name='id[]']").iCheck('check');
        $("input[name='id[]']").attr("checked", true);
        $("input[name=boxChecked]").val($("input[name='id[]']:checked").length);
    });
    $('input#check-all').on('ifUnchecked', function () {
        $("input[name='id[]']").iCheck('uncheck');
        $("input[name='id[]']").attr("checked", false);
        $("input[name=boxChecked]").val(0);
    });
    
    function do_trash(url) {
        if (confirm("Do you really want to move selected item to trash?")) {
            location.href = url;
        }
    }
    
    function do_delete(url) {
        if (confirm("Do you really want to delete selected item?")) {
            location.href = url;
        }
    }
    
    function do_trash_multi(url) {
        var cnf = confirm("WARNING! Are you sure you want to move selected items to trash?");
        if (cnf == true) {
            document.itemsForm.action = url;
            document.itemsForm.submit();
        }
    }
    
    function do_delete_multi(url) {
        var cnf = confirm("WARNING! Are you sure you want to delete selected items?");
        if (cnf == true) {
            document.itemsForm.action = url;
            document.itemsForm.submit();
        }
    }
</script>