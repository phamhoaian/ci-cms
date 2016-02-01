<?php
$attributes = array('class' => 'form-horizontal');

$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	//'size'	=> 30,
	'value' =>  set_value('username'),
	'class' => 'form-control'
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	//'size'	=> 30,
	'value' => set_value('password'),
	'class' => 'form-control'
);

$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	//'size'	=> 30,
	'value' => set_value('confirm_password'),
	'class' => 'form-control'
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	//'maxlength'	=> 80,
	//'size'	=> 30,
	'value'	=> set_value('email'),
	'class' => 'form-control'
);

$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha'
);

?>




<!--contentBlock-->
	<div id="otherBlock" class="clearF">
	
	<!--mainImage--><!--//mainImage-->
	
	
<div class="inner">
	
	<h2 class="heading_life">登録フォーム<span></span></h2>


<div  style="width:95%; max-width:700px; margin:30px auto; padding:10px; border:1px solid #CCC; border-radius:10px; ">
	<h3 style="margin-top:0px;">以下のフォームから登録してください（完全無料です）</h3>

<?php echo form_open($this->uri->uri_string(), $attributes)?>


  <div class="form-group">
		<label class="col-sm-2 control-label" for="name">御社名</label>
    <div class="col-sm-7">
			<?php echo form_error($username['name']); ?>
			<?php echo form_input($username)?>
		</div>
	</div>


	 <div class="form-group">
		<label class="col-sm-2 control-label" for="password">パスワード</label>
    <div class="col-sm-7">
			<?php echo form_error($password['name']); ?>
			<?php echo form_password($password)?>
			
			</div>
	</div>



	 <div class="form-group">
		<label class="col-sm-2 control-label" for="confirm_password">パスワード(再入力)</label>
    <div class="col-sm-7">
			<?php echo form_error($confirm_password['name']); ?>
			<?php echo form_password($confirm_password)?>
					</div>
	</div>

	 <div class="form-group">
		<label class="col-sm-2 control-label" for="email">メールアドレス</label>
    <div class="col-sm-7">
			<?php echo form_error($email['name']); ?>
			<?php echo form_input($email)?>
					</div>
	</div>
	
	
<?php if ($this->dx_auth->captcha_registration): ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="captcha">画像の中の文字を入力してください</label>
		<div class="col-sm-7">
			<?php echo $this->dx_auth->get_captcha_image(); ?>
			<br>
			<?php echo form_error($captcha['name']); ?>
			<?php echo form_input($captcha)?>
			<p class="help-block">（数字のゼロは入っていません）</p>
		</div>
	</div>

<?php endif; ?>
	


<div class="form-actions" align="center">
<?php echo form_submit('regist','　　無料登録　　','data-loading-text="処理中…" class="btn btn-success"');?>
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





