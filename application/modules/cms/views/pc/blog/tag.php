<?php
$attributes = array("class" => "form-horizontal", "id" => "tagForm", "name" => "tagForm");
$js_back = "onClick=\"self.location.href='". site_url("cms/blog_tags") ."'\"'";

$name = array(
    "name" => "name",
    "id" => "name",
    "class" => "form-control",
    "value" => set_value("name", $tag["name"])
);

$published = array(
    "name" => "published",
    "class" => "js-switch",
    "value" => "1",
    "checked" => set_value("published", $tag["published"])
);
?>
<div class="page-title">
    <div class="row">
        <div class="col-md-12 toolbox text-right">
            <button onclick="document.tagForm.submit();" class="btn btn-app">
                <i class="fa fa-check"></i>
                Save
            </button>
            <button <?php echo $js_back; ?> class="btn btn-app">
                <i class="fa fa-close"></i>
                Cancel
            </button>
        </div>
    </div>
</div>
<!-- /page-title -->
<div class="row">
    <?php echo form_open($this->uri->uri_string(), $attributes); ?>
    	<div class="col-md-12 col-sm-12 col-xs-12">
    		<div class="x_panel">
    			<div class="x_title">
    				<h2>
                        <i class="fa fa-pencil"></i>
                        <?php echo $page_title; ?>
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
    				<div class="form-group">
    					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
    						Name
    						<span class="required">*</span>
    					</label>
    					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
    						<?php echo form_input($name); ?>
    						<?php echo form_error($name["name"]); ?>
    					</div>
    				</div>
    				<div class="form-group">
    					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
    						Published
    					</label>
    					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
    						<?php echo form_checkbox($published); ?>
    						<?php echo form_error($published["name"]); ?>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    <?php echo form_close(); ?>
</div>
<!-- /x_panel -->
<script type="text/javascript">
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
</script>