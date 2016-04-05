<?php
$attributes = array("class" => "form-horizontal", "id" => "itemForm", "name" => "itemForm");
$hidden = array("id" => $item_id, "item_image" => $item["image"]);
$js_back = "onClick=\"self.location.href='". site_url("cms/blog") ."'\"'";

$title = array(
	"name" => "title",
	"id" => "title",
	"class" => "form-control",
	"value" => set_value("title", $item["title"])
);
$alias = array(
	"name" => "alias",
	"id" => "alias",
	"class" => "form-control",
	"value" => set_value("alias", $item["alias"])
);
$category = array();
$category[""] = "-- Select category --";
$category_selected = "";
foreach ($list_categories as $row) {
	if ($row["id"] == set_value("parent", $item["cat_id"])) {
		$category_selected = set_value("parent", $item["cat_id"]);
	}
	$category["{$row["id"]}"] = $row["name"];
}
$tags = array(
    "name" => "tags",
    "id" => "tags",
    "class" => "tags form-control",
    "value" => "social, adverts, sales"
);
$featured = array(
	"name" => "featured",
	"class" => "js-switch",
	"value" => "1",
    "checked" => set_value("featured", $item["featured"])
);
$published = array(
	"name" => "published",
	"class" => "js-switch",
	"value" => "1",
    "checked" => set_value("published", $item["published"])
);
$content = array(
    "name" => "content",
    "id" => "content",
    "class" => "form-control",
    "value" => set_value("content", $item["content"])
);
$image = array(
	"name" => "image",
	"id" => "image",
	"accept" => "image/*",
    "onchange" => "openFile(event)"
);
$author = array(
    "name" => "author",
    "id" => "author",
    "class" => "form-control",
    "value" => set_value("author", $item["created_by"])
);
$created = array(
    "name" => "created",
    "class" => "form-control",
    "value" => set_value("created", $item["created"])
);
$published_date = array(
    "name" => "published_date",
    "class" => "form-control",
    "value" => set_value("published_date", $item["published_date"])
);
$metadesc = array(
    "name" => "metadesc",
    "id" => "metadesc",
    "class" => "form-control",
    "rows" => 3,
    "value" => set_value("metadesc", $item["metadesc"])
);
$metakey = array(
    "name" => "metakey",
    "id" => "metakey",
    "class" => "form-control",
    "rows" => 3,
    "value" => set_value("metakey", $item["metakey"])
);
?>
<div class="page-title">
    <div class="row">
        <div class="col-md-12 toolbox text-right">
            <button onclick="document.itemForm.submit();" class="btn btn-app">
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
    <?php echo form_open_multipart($this->uri->uri_string(), $attributes, $hidden); ?>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
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
						Title
						<span class="required">*</span>
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_input($title); ?>
						<?php echo form_error($title["name"]); ?>
					</div>
				</div>
                <div class="form-group">
					<label for="alias" class="control-label col-md-3 col-sm-3 col-xs-12">
						Title alias (URL)
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_input($alias); ?>
						<?php echo form_error($alias["name"]); ?>
					</div>
				</div>
                <div class="form-group">
					<label for="category" class="control-label col-md-3 col-sm-3 col-xs-12">
						Category
                        <span class="required">*</span>
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_dropdown("category", $category, $category_selected, "id ='category' class='form-control'"); ?>
						<?php echo form_error("category"); ?>
					</div>
				</div>
                <div class="form-group">
                    <label for="category" class="control-label col-md-3 col-sm-3 col-xs-12">
						Tags
					</label>
                    <div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
                        <?php echo form_input($tags); ?>
                        <?php echo form_error($tags["name"]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alias" class="control-label col-md-3 col-sm-3 col-xs-12">
						Featured
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_checkbox($featured); ?>
						<?php echo form_error($featured["name"]); ?>
					</div>
                </div>
                <div class="form-group">
                    <label for="alias" class="control-label col-md-3 col-sm-3 col-xs-12">
						Published
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_checkbox($published); ?>
						<?php echo form_error($published["name"]); ?>
					</div>
                </div>
            </div>
        </div>
        <!-- /content-top -->
        <div class="panel panel-default tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_content" role="tab" data-toggle="tab" aria-expanded="true">
                        <i class="fa fa-edit"></i>
                        Content
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane panel-body fade active in" id="tab_content" aria-labelledby="content-tab">
                    <?php echo form_textarea($content); ?>
                    <?php echo form_error($content["name"]); ?>
                    <button type="button" class="btn btn-default MT15" onclick="insertReadMore('content');return false;">
                        <i class="fa fa-arrow-down"></i>
                        Read More
                    </button>
                </div>
            </div>
        </div>
        <!-- /main-content -->
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
			<div class="x_title">
				<h2>
                    <i class="fa fa-image"></i>
                    Image
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
            <div class="x_content">
                <?php if ($item["image"]) { ?>
                <div class="dropzone dropzone-mini dz-clickable dz-started">
                    <div class="dz-preview dz-success">
                        <div class="dz-details">
                            <div class="dz-filename"><?php echo $item["title"]; ?></div>
                            <img id="dz-image-preview" src="<?php echo base_url()."images/blog/items/".$item["id"]."_900.".$item["image"]; ?>"/>
                        </div>
                        <div class="dz-success-mark"></div>
                        <a class="dz-remove" href="<?php echo site_url("cms/blog/photo_del/".$item["id"]); ?>" data-dz-remove="">Remove file</a>
                    </div>
                </div>
                <?php } else { ?>
                <div class="dropzone dropzone-mini dz-clickable">
                    <div class="dz-default dz-message">
                        <?php echo form_upload($image); ?>
                        <?php echo form_error($image["name"]); ?>
                    </div>
                    <div class="dz-preview">
                        <div class="dz-details">
                            <div class="dz-filename"></div>
                            <img id="dz-image-preview" src=""/>
                        </div>
                        <div class="dz-success-mark"></div>
                        <a class="dz-remove" href="javascript:void(0)" data-dz-remove="">Remove file</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- /image -->
		<div class="x_panel">
			<div class="x_title">
				<h2>
                    <i class="fa fa-cog"></i>
                    Setting
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
            <div class="x_content">
                <div class="form-group">
                    <label for="author" class="control-label col-md-4 col-sm-3 col-xs-12">
						Author
					</label>
					<div class="col-md-8 col-sm-7 col-xs-12">
						<?php echo form_input($author); ?>
						<?php echo form_error($author["name"]); ?>
					</div>
                </div>
                <div class="form-group">
                    <label for="created" class="control-label col-md-4 col-sm-3 col-xs-12">
						Creation
					</label>
					<div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="input-group date" id="created">
                            <?php echo form_input($created); ?>
                            <?php echo form_error($created["name"]); ?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
					</div>
                </div>
                <div class="form-group">
                    <label for="published_date" class="control-label col-md-4 col-sm-3 col-xs-12">
						Publishing
					</label>
					<div class="col-md-8 col-sm-7 col-xs-12">
                        <div class="input-group date" id="published_date">
                            <?php echo form_input($published_date); ?>
                            <?php echo form_error($published_date["name"]); ?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
					</div>
                </div>
                <div class="form-group">
                    <label for="metadesc" class="control-label col-md-4 col-sm-3 col-xs-12">
						Description
					</label>
					<div class="col-md-8 col-sm-7 col-xs-12">
						<?php echo form_textarea($metadesc); ?>
						<?php echo form_error($metadesc["name"]); ?>
					</div>
                </div>
                <div class="form-group">
                    <label for="metakey" class="control-label col-md-4 col-sm-3 col-xs-12">
						Keywords
					</label>
					<div class="col-md-8 col-sm-7 col-xs-12">
						<?php echo form_textarea($metakey); ?>
						<?php echo form_error($metakey["name"]); ?>
					</div>
                </div>
            </div>
        </div>
        <!-- /setting -->
    </div>
    <?php echo form_close(); ?>
</div>
<!-- /x_panel -->
<script type="text/javascript">
    $(function () {
        // category
        $("#category").select2();
        
        // tags
        $('#tags').tagsInput({
            width: 'auto'
        });
        
        // switcher
        if ($(".js-switch")[0]) {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {
                    color: '#26B99A'
                });
            });
        }
        
        // datepicker
        $('#created').datetimepicker({
            format: "DD-MM-YYYY HH:mm:ss",
        });
        $('#published_date').datetimepicker({
            format: "DD-MM-YYYY HH:mm:ss"
        });
        
        // editor
        tinyMCE.init({
            // General
            directionality: "ltr",
            language : "en",
            mode : "textareas",
            autosave_restore_when_empty: false,
            skin : "lightgray",
            theme : "modern",
            schema: "html5",
            selector: "#content",
            // Cleanup/Output
            inline_styles : true,
            gecko_spellcheck : true,
            entity_encoding : "raw",
            valid_elements : "",
            extended_valid_elements : "hr[id|title|alt|class|width|size|noshade]",
            force_br_newlines : false, force_p_newlines : true, forced_root_block : 'p',
            toolbar_items_size: "small",
            invalid_elements : "script,applet,iframe",
            // Plugins
            plugins : "table link image code hr charmap autolink lists importcss",
            // Toolbar
            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | bullist numlist",
            toolbar2: "outdent indent | undo redo | link unlink anchor image code | hr table | subscript superscript | charmap",
            removed_menuitems: "newdocument",
            // Advanced Options
            resize: "vertical",
            height : "350",
            width : "",

        });
        
        $('.dz-remove').click(restartFiles);
        
    });
    
    var restartFiles = function() {
        $('.dropzone').removeClass('dz-started');
        $('.dz-preview').removeClass('dz-success');
        $('#image').replaceWith($("#image").clone());
    };
    
    var openFile = function(event) {
        var input = event.target;
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.fileName = file.name;
        reader.onload = function(){
            var dataURL = reader.result;
            $('.dropzone').addClass('dz-started');
            $('.dz-preview').addClass('dz-success');
            $('.dz-filename').html("<span>" + this.fileName + "</span>");
            var output = document.getElementById('dz-image-preview');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    };
</script>