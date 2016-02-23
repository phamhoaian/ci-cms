<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
		if(isset($title) && $title)
		{
			print "<title>{$title} - ".SITE_NAME."</title>";
		}
		else
		{
		print "<title>".SITE_NAME."</title>";
		}
		if(isset($description) && $description)
		{
			print "\n".'<meta name="description" content="'.$description.'">';
		}
		?>
		<link rel="stylesheet" href="<?php echo base_url();?>common/css/reset.css">
		<link rel="stylesheet" href="<?php echo base_url();?>common/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>common/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>common/css/animate.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>common/css/cms.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="<?php echo base_url();?>common/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>common/js/cms.js"></script>
		<?php echo $js;?>
		<?php echo $css;?>
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	    <![endif]-->
	</head>
	<body>
		<div class="container main">
			<?php $this->load->view('pc/parts/left-col'); ?>
			<div class="right-col" role="main">
				<?php $this->load->view('pc/parts/top-nav'); ?>
				<?php if (isset($position) and $position){ ?>
				<ul class="breadcrumb">
				    <?php echo $position; ?>
				</ul>
				<?php } ?>
				<div class="main-content">
					<?php echo $main; ?>
				</div>
			</div>
			<!-- /right-col -->
		</div>
	</body>
</html>