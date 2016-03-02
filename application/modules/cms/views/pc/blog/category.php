<?php
$attributes = array("class" => "form-horizontal");
$hidden = array("id" => $category_id, "image_from_category" => $image_from_category);
$js_back = "class='btn btn-default' onClick=\"self.location.href='". site_url("cms/blog/categories") ."'\"'";

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
	"rows" => 10,
	"style" => "resize: vertical;"
);
$image = array(
	"name" => "image",
	"id" => "image",
	"class" => "",
	"onchange" => "openFile(event)"
);
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $page_title; ?></h2>
			</div>
			<div class="x_content">
				<?php echo form_open_multipart($this->uri->uri_string(), $attributes, $hidden); ?>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Title
						<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo form_input($title); ?>
						<?php echo form_error($title["name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Title alias (URL)
						<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo form_input($alias); ?>
						<?php echo form_error($alias["name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Parent category
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo form_dropdown("parent", $parent, $parent_selected, "id ='parent' class='form-control'"); ?>
						<?php echo form_error("parent"); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Published
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo form_checkbox($published); ?>
						<?php echo form_error($published["name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Description
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php echo form_textarea($description); ?>
						<?php echo form_error($description["name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">
						Image
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php if ($category["image"]) { ?>
						<div class="image_preview">
                            <a class="image_del" href="#" data-toggle="modal" data-target="#delPhotoModal">
                                <img src="<?php echo base_url()."images/blog/categories/".$category["id"]."_200.".$category["image"]; ?>" alt="<?php echo $category["name"]; ?>">
                                <i class="fa fa-close"></i>
                            </a>
						</div>
                        <div class="modal animated fadeInDown type-success" id="delPhotoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Are you sure want to delete category image ?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo site_url("cms/blog/categories/photo_del/".$category["id"]); ?>" class="btn btn-primary">Delete</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php } else { ?>
						<?php echo form_upload($image); ?>
						<?php echo form_error($image["name"]); ?>
						<div class="image_preview">
							<img id="output">
						</div>
						<?php } ?>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<?php echo form_submit('submit','Submit','data-loading-text="Waiting…" class="btn btn-success"');?>　
						<?php echo form_reset('reset', 'Reset','class="btn btn-primary"');?>　　
						<?php echo form_button('back', 'Cancel', $js_back);?>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
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

	var openFile = function(event) {
		var input = event.target;

		var reader = new FileReader();
		reader.onload = function(){
			var dataURL = reader.result;
			var output = document.getElementById('output');
			output.src = dataURL;
		};
		reader.readAsDataURL(input.files[0]);
	};
    
    $("#parent").select2();
</script>