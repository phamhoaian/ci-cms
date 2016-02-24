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
					<li<?php if (isset($active_sub_menu) && $active_sub_menu == "dashboard") { ?> class="current"<?php } ?>><a href="<?php echo site_url("cms"); ?>">Dashboard</a></li>
				</ul>
			</li>
			<li<?php if (isset($active_side_menu) && $active_side_menu == "blog") { ?> class="active"<?php } ?>>
				<a href="javascript:void(0)">
					<i class="fa fa-edit"></i>Blog
					<span class="fa fa-chevron-down"></span>
				</a>
				<ul class="nav child-menu">
					<li<?php if (isset($active_sub_menu) && $active_sub_menu == "blog_items") { ?> class="current"<?php } ?>><a href="<?php echo site_url("cms/blog"); ?>">Items</a></li>
					<li<?php if (isset($active_sub_menu) && $active_sub_menu == "blog_categories") { ?> class="current"<?php } ?>><a href="<?php echo site_url("cms/blog/categories"); ?>">Categories</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- /sidebar-menu -->
	<div class="sidebar-footer hidden-small">
		<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a href="<?php echo site_url(); ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Page">
            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
	</div>
</div>
<!-- /left-col -->