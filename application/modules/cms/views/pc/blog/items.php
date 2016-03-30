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
            <button onclick="if (document.itemsForm.boxChecked.value==0){alert('Please first make a selection from the list.');} else {document.itemsForm.action = '<?php echo site_url("cms/blog/feature") ?>';document.itemsForm.submit();}" class="btn btn-app">
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
                
            </div>
        </div>
    </div>
</div>
<!-- /x_panel -->