<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="favicon.ico" >
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
if(isset($keywords) && $keywords)
{
	print "\n".'<meta name="keywords" content="'.$keywords.'">';
}
if( isset($og_title) && $og_title )
{
    print "\n".'<meta property="og:title" content="'.$og_title.'">';
}
else if(defined('SITE_NAME') && isset($title))
{
    print "\n".'<meta property="og:title" content="'.SITE_NAME.'】'.'">';
}
if(isset($og_description) && $og_description)
{
    print "\n".'<meta property="og:description" content="'.$og_description.'">';
}
else if(isset($description) && $description)
{
    print "\n".'<meta property="og:description" content="'.$description.'">';
}
if(current_url() == base_url())
{
    print "\n".'<meta property="og:type" content="website">'."\n";
}
else
{
    print "\n".'<meta property="og:type" content="article">'."\n";
}
?>
<meta property="og:image" content="<?php echo base_url();?>common/img/logo_s.jpg" />
<meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
<meta property="og:locale" content="vi_VN" />
<link rel="stylesheet" href="<?php echo base_url();?>common/css/reset.css">
<link rel="stylesheet" href="<?php echo base_url();?>common/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>common/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>common/css/yamm.css">
<link rel="stylesheet" href="<?php echo base_url();?>common/css/common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo base_url();?>common/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>common/js/main.js"></script><!-- jQuery -->
<?php echo $js;?>
<?php echo $css;?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body<?php if(isset($body_id)) { echo " id = '".$body_id."'"; } ?>>
<?php $this->load->view('pc/parts/header');?>
<?php if(isset($position) and $position){ ?>
<section id="breadcrumbs">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <?php echo $position; ?>
            </ul>
        </div>
    </div>
</section>
<?php } ?>
<?php echo $main;?>
<?php $this->load->view('pc/parts/footer');?>
<?php echo $js_foot;?>
</body>
</html>
