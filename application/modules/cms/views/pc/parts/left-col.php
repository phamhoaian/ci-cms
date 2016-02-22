<div class="left-col pull-left">
	<div class="logo">
		<a href="<?php echo site_url("cms"); ?>">
			<img class="logo-md" src="<?php echo base_url(); ?>common/img/logo-big-shop.png" alt="Effect">
			<img class="logo-sm" src="<?php echo base_url(); ?>common/img/logo-small-shop.png" alt="Effect">
		</a>
	</div>
	<!-- /logo -->
	<div class="profile clearfix">
		<div class="img">
			<img src="<?php echo base_url(); ?>common/img/profile-img.jpg" alt="Profile" class="img-circle">
		</div>
		<div class="info">
			<span>Welcome,</span>
			<h2>Anthony Fernando</h2>
		</div>
	</div>
	<!-- /profile -->
	<div id="sidebar-menu">
		<ul class="nav side-menu">
			<li<?php if (isset($active_side_menu) && $active_side_menu == "cms") { ?> class="active"<?php } ?>>
				<a href="javascript:void(0)">
					<i class="fa fa-home"></i>Home
					<span class="fa fa-chevron-down"></span>
				</a>
				<ul class="nav child-menu">
					<li class="current"><a href="">Dashboard</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- /sidebar-menu -->
</div>
<!-- /left-col -->