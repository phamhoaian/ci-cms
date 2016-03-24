<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username'),
    'placeholder' => "Username"
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
    'placeholder' => "Password"
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);
?>
<div id="login">
    <div class="login-logo">
        <img src="<?php echo base_url(); ?>common/img/logo-big-shop.png" alt="<?php echo SITE_NAME; ?>" />
    </div>
    <div class="login-body">
        <div class="login-title">
            <strong>Welcome</strong>, Please login
        </div>
        <?php echo form_open($this->uri->uri_string())?>
            <?php echo $this->dx_auth->get_auth_error(); ?>
            <div class="form-group">
                <?php echo form_input($username)?>
                <?php echo form_error($username['name']); ?>
            </div>
            <div class="form-group">
                <?php echo form_password($password)?>
                <?php echo form_error($password['name']); ?>
            </div>
            <div class="form-group">
                <?php if ($show_captcha): ?>
                <dt>Enter the code exactly as it appears. There is no zero.</dt>
                <dd><?php echo $this->dx_auth->get_captcha_image(); ?></dd>
                <dt><?php echo form_label('Confirmation Code', $confirmation_code['id']);?></dt>
                <dd>
                    <?php echo form_input($confirmation_code);?>
                    <?php echo form_error($confirmation_code['name']); ?>
                </dd>
                <?php endif; ?>
            </div>
            <div class="form-group checkbox">
                <label>
                    <?php echo form_checkbox($remember);?>
                    Remember me
                </label>
            </div>
            <div class="form-group">
                <?php echo form_submit('login','Login', 'data-loading-text="Processing..."');?>
            </div>
            <hr>
            <div class="login-footer">
                <i class="fa fa-arrow-left"></i>
                <?php echo anchor($this->dx_auth->forgot_password_uri, 'Forgot password');?>
            </div>
        <?php echo form_close()?>
    </div>
</div>
<script type="text/javascript"> 
    $('input[type=submit]').on('click', function () {
        $(this).attr('value', 'Processing...');
        $(this).addClass('disabled');
    })
</script>
