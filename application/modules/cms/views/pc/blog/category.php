<?php
$attributes = array("class" => "form-horizontal", "id" => "categoryForm", "name" => "categoryForm");
$hidden = array("id" => $category_id, "image_from_category" => $image_from_category);
$js_back = "onClick=\"self.location.href='". site_url("cms/blog_categories") ."'\"'";

$title = array(
	"name" => "title",
	"id" => "title",
	"class" => "form-control",
	"value" => set_value("title", $category["name"])
);
$alias = array(
	"name" => "alias",
	"id" => "alias",
	"class" => "form-control",
	"value" => set_value("alias", $category["alias"])
);
$parent = array();
$parent[""] = "-- None --";
$parent_selected = "";
foreach ($list_categories as $row) {
	if ($row["id"] == set_value("parent", $category["parent"])) {
		$parent_selected = set_value("parent", $category["parent"]);
	}
	$parent["{$row["id"]}"] = $row["name"];
}
$published = array(
	"name" => "published",
	"class" => "js-switch",
	"value" => "1",
    "checked" => set_value("published", $category["published"])
);
$description = array(
	"name" => "description",
	"id" => "description",
	"class" => "form-control",
	"value" => set_value("description", $category["description"]),
	"rows" => 7,
	"style" => "resize: vertical;"
);
$image = array(
	"name" => "image",
	"id" => "image",
	"accept" => "image/*",
	"onchange" => "openFile(event)"
);
?>
<div class="page-title">
    <div class="row">
        <div class="col-md-12 toolbox text-right">
            <button onclick="document.categoryForm.submit();" class="btn btn-app">
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
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Title alias (URL)
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_input($alias); ?>
						<?php echo form_error($alias["name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Parent category
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_dropdown("parent", $parent, $parent_selected, "id ='parent' class='form-control'"); ?>
						<?php echo form_error("parent"); ?>
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
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Description
					</label>
					<div class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
						<?php echo form_textarea($description); ?>
						<?php echo form_error($description["name"]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- /left-content -->
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
                <?php if ($category["image"]) { ?>
                <div class="dropzone dropzone-mini dz-clickable dz-started">
                    <div class="dz-preview dz-success">
                        <div class="dz-details">
                            <div class="dz-filename"><?php echo $category["name"]; ?></div>
                            <img id="dz-image-preview" src="<?php echo base_url()."images/blog/categories/".$category["id"]."_300.".$category["image"]; ?>"/>
                        </div>
                        <div class="dz-success-mark"></div>
                        <a class="dz-remove" href="<?php echo site_url("cms/blog_categories/photo_del/".$category["id"]); ?>" data-dz-remove="">Remove file</a>
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
    </div>
    <!-- /image -->
    <?php echo form_close(); ?>
</div>
<!-- /x_panel -->
<script type="text/javascript">
    $(function () {
        $("#parent").select2();
        $('.dz-remove').click(restartFiles);
    });
    
	if ($(".js-switch")[0]) {
	    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	    elems.forEach(function (html) {
	        var switchery = new Switchery(html, {
	            color: '#26B99A'
	        });
	    });
	}

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