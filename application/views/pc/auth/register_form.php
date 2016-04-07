<?php
$attributes = array('class' => 'form-horizontal');

$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	//'size'	=> 30,
	'value' =>  set_value('username'),
	'class' => 'form-control',
    'placeholder' => 'Username'
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	//'size'	=> 30,
	'value' => set_value('password'),
	'class' => 'form-control',
    'placeholder' => 'Password'
);

$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	//'size'	=> 30,
	'value' => set_value('confirm_password'),
	'class' => 'form-control',
    'placeholder' => 'Confirm Password'
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	//'maxlength'	=> 80,
	//'size'	=> 30,
	'value'	=> set_value('email'),
	'class' => 'form-control',
    'placeholder' => 'Email'
);

$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
    'placeholder' => 'Confirmation Code'
);

?>
<div id="register-form">
    <div class="form-head">
        <img src="<?php echo base_url(); ?>common/img/logo-big-shop.png" alt="<?php echo SITE_NAME; ?>" />
    </div>
    <div class="form-body">
        <div class="form-title">
            <strong>Register Form</strong>
        </div>
        <?php echo form_open($this->uri->uri_string(), $attributes)?>
            <div class="form-group">
                <?php echo form_input($username)?>
                <?php echo form_error($username['name']); ?>
            </div>
            <div class="form-group">
                <?php echo form_password($password)?>
                <?php echo form_error($password['name']); ?>
            </div>
            <div class="form-group">
                <?php echo form_password($confirm_password)?>
                <?php echo form_error($confirm_password['name']); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($email)?>
                <?php echo form_error($email['name']); ?>
            </div>
            <?php if ($this->dx_auth->captcha_registration): ?>
            <div class="form-group captcha">
                <?php echo $this->dx_auth->get_captcha_image(); ?>
                <?php echo form_input($captcha)?>
                <?php echo form_error($captcha['name']); ?>
                <p class="help-block">* Enter the code exactly as it appears. There is no zero.</p>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <?php echo form_submit('register','Register', 'data-loading-text="Processing..."');?>
            </div>
        <?php echo form_close()?>
    </div>
</div>
<script type="text/javascript">
    $('input[type=submit]').on('click', function () {
        $(this).button('loading')
    })
</script>