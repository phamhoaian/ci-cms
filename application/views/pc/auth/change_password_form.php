<?php
$attributes = array('class' => 'form-horizontal');


$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	//'size' 	=> 30,
	'value' => set_value('old_password'),
	'class' => 'form-control'
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	//'size'	=> 30,
	'class' => 'form-control'
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	//'size' 	=> 30,
	'class' => 'form-control'
);

?>





<!--contentBlock-->
	<div id="otherBlock" class="clearF">
	
	<!--mainImage--><!--//mainImage-->
	
	
<div class="inner">
	
	<h2 class="heading_life">パスワード変更<span></span></h2>


<div  style="width:95%; max-width:700px; margin:30px auto; padding:10px; border:1px solid #CCC; border-radius:10px; ">

<?php echo form_open($this->uri->uri_string(), $attributes); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

  <div class="form-group">
		<label class="col-sm-2 control-label" for="old_password">現在のパスワード</label>
    <div class="col-sm-7">
			<?php echo form_error($old_password['name']); ?>
			<?php echo form_password($old_password); ?>
		</div>
	</div>


	 <div class="form-group">
		<label class="col-sm-2 control-label" for="new_password">新しいパスワード</label>
    <div class="col-sm-7">
			<?php echo form_error($new_password['name']); ?>
			<?php echo form_password($new_password); ?>
			
			</div>
	</div>



	 <div class="form-group">
		<label class="col-sm-2 control-label" for="confirm_new_password">新しいパスワード(再入力)</label>
    <div class="col-sm-7">
			<?php echo form_error($confirm_new_password['name']); ?>
			<?php echo form_password($confirm_new_password); ?>
					</div>
	</div>
	


<div class="form-actions" align="center">
	<?php echo form_submit('regist','　　パスワード変更　　','data-loading-text="処理中…" class="btn btn-success"');?>　
</div>

<script type="text/javascript"> 
  $('.btn-success').on('click', function () {
    $(this).button('loading')
  })
</script> 

<br />

<?php echo form_close()?>
</div>
	</div>
<!--//contentWrap-->
</div>




