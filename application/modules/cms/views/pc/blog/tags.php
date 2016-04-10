<?php
$attributes = array(
    "name" => "tagsForm",
    "id" => "tagsForm"
);
$hidden = array(
    "boxChecked" => 0
);
$search = array(
    "name" => "search",
    "id" => "search",
    "class" => "form-control",
    "value" => $key_disp,
    "placeholder" => "Search for tags"
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
            <h3>Blog Tags</h3>
        </div>
        <div class="col-md-6 toolbox text-right">
            <a href="<?php echo site_url("cms/blog_tags/edit"); ?>" class="btn btn-app">
                <i class="fa fa-plus-circle"></i>
                New
            </a>
            <button onclick="if (document.tagsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.tagsForm.action = '<?php echo site_url("cms/blog_tags/publish") ?>';document.tagsForm.submit();}" class="btn btn-app">
                <i class="fa fa-check"></i>
                Publish
            </button>
            <button onclick="if (document.tagsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.tagsForm.action = '<?php echo site_url("cms/blog_tags/unpublish") ?>';document.tagsForm.submit();}" class="btn btn-app">
                <i class="fa fa-close"></i>
                Unpublish
            </button>
            <button onclick="if (document.tagsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {do_delete_multi('<?php echo site_url("cms/blog_tags/delete") ?>');}" class="btn btn-app">
                <i class="fa fa-times-circle-o"></i>
                Delete
            </button>
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
                    List blog tags
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
                <?php echo form_open(site_url("cms/blog_tags/search"), $attributes, $hidden); ?>
                <div class="row MB10">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-right">
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
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="20%">
                                </colgroup>
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            <input type="checkbox" id="check-all" class="flat">
                                        </th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title text-center">Published</th>
                                        <th class="column-title text-center">Items</th>
                                        <th class="column-title text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($count_tags > 0) { ?>
                                    <?php foreach ($tags as $key => $tag) :
                                        if ($key%2 == 0) {
                                            $pos = "even";
                                        } else {
                                            $pos = "old";
                                        }
                                    ?>
                                    <tr class="<?php echo $pos; ?> pointer">
                                    	<td><input type="checkbox" class="flat" name="id[]" value="<?php echo $tag["id"]; ?>"></td>
                                        <td>
                                            <a href="<?php echo site_url("cms/blog_tags/edit/".$tag["id"]); ?>">
                                                <?php echo $tag["name"]; ?>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($tag["published"]) { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Unpublish item" href="<?php echo site_url("cms/blog_tags/unpublish/".$tag["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Publish item" href="<?php echo site_url("cms/blog_tags/publish/".$tag["id"]); ?>" class="published btn btn-xs btn-default">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        	<?php } ?>
                                        </td>
                                        <td class="text-center"></td>
                                        <td class="text-center">
                                            <a href="<?php echo site_url("cms/blog_tags/edit/".$tag["id"]); ?>" class="btn btn-xs btn-warning">
                                                <i class="fa fa-edit"></i>Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="do_delete('<?php echo site_url("cms/blog_tags/delete/".$tag["id"]); ?>')" class="btn btn-xs btn-danger">
                                                <i class="fa fa-close"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php } else { ?>
                                    <tr class="pointer">
                                        <td colspan="5">
                                            No data found
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /tags -->
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
    
    function do_delete(url) {
        if (confirm("Do you really want to delete selected tag?")) {
            location.href = url;
        }
    }
    
    function do_delete_multi(url) {
        var cnf = confirm("WARNING! Are you sure you want to delete selected tags?");
        if (cnf == true) {
            document.tagsForm.action = url;
            document.tagsForm.submit();
        }
    }
</script>