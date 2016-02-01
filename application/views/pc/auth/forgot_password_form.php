<?php
$attributes = array('class' => 'form-horizontal');

$class = 'class="input-small"';

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	//'maxlength'	=> 80,
	//'size'	=> 30,
	'class' => 'form-control',
	'value' => set_value('login')
);





?>




<!--contentBlock-->
	<div id="otherBlock" class="clearF">
	
	<!--mainImage--><!--//mainImage-->
	
	
<div class="inner">
	
	<h2 class="heading_life">パスワード再発行<span></span></h2>


<div  style="width:95%; max-width:700px; margin:30px auto; padding:10px; border:1px solid #CCC; border-radius:10px; ">

<?php echo form_open($this->uri->uri_string(), $attributes); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>


  <div class="form-group">
		<label class="col-sm-2 control-label" for="login">メールアドレス</label>
    <div class="col-sm-7">
			<?php echo form_error($login['name']); ?>
			<?php echo form_input($login);?>
		</div>
	</div>


	


<div class="form-actions" align="center">
	<?php echo form_submit('regist','　　パスワード再発行　　','data-loading-text="処理中…" class="btn btn-success"');?>
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



