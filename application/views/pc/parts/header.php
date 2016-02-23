<header id="header">
    <div class="header-top-row">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="top-welcome hidden-xs hidden-sm">
                        <p>
                            Welcome Effect Template
                            <i class="fa fa-phone"></i>
                            0126-424-4466&nbsp;
                            <i class="fa fa-envelope"></i>
                            phamhoaian005@gmail.com
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <div id="lang" class="pull-right">
                            <a class="lang-title" href="#">
                                <img src="<?php echo site_url("common/img/f-gb.png"); ?>" alt="English" title="English">
                                English
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="list-unstyled lang-item">
                                <li>
                                    <a href="#">
                                        <img src="<?php echo site_url("common/img/f-gb.png"); ?>" alt="English" title="English">
                                        English
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo site_url("common/img/f-fr.png"); ?>" alt="French" title="French">
                                        French
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="currency" class="pull-right">
                            <a class="currency-title" href="#">
                                $ USB
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="list-unstyled currency-item">
                                <li>
                                    <a href="#">€ EURO</a>
                                </li>
                                <li>
                                    <a href="#">£ POUND</a>
                                </li>
                            </ul>
                        </div>
                        <div id="account-menu" class="pull-right">
                            <a class="account-menu-title" href="#">
                                <i class="fa fa-user"></i>
                                Account
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="list-unstyled account-menu-item">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-heart"></i>
                                        Wishlist
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-check"></i>
                                        Checkout
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart"></i>
                                        Cart
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="socials-block" class="pull-right">
                            <ul class="list-unstyled list-inline">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /header-top-row -->
    <div class="header-bg">
        <div id="header-main-fixed" class="header-main">
            <div class="header-main-block1">
                <div class="container">
                    <div id="container-fixed">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="<?php echo site_url(); ?>" class="header-logo">
                                    <img src="<?php echo site_url("common/img/logo-big-shop.png"); ?>" alt="Effect">
                                </a>
                            </div>
                            <div class="col-md-5">
                                <div class="top-search-form pull-left">
                                    <?php echo form_open("home/search"); ?>
                                    <?php echo form_input(array('name' => 'search', 'class' => 'form-control', 'placeholder' => 'Search...')); ?>
                                    <?php echo form_button(array('name' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-search"></i>')); ?>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="header-mini-cart pull-right">
                                    <a href="#" data-toggle="dropdown">
                                        Shopping cart
                                        <span>0 item(s)-0.00</span>
                                    </a>
                                    <div class="dropdown-menu shopping-cart-content pull-right">
                                        <div class="shopping-cart-items">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="top-icons">
                                    <a href="#" title="Wishlist">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a href="#" title="Notification">
                                        <i class="fa fa-bell"></i>
                                        <span>12</span>
                                    </a>
                                    <a href="#" title="Login">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-main-block2">
                <nav class="navbar yamm navbar-main" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo site_url(); ?>" class="navbar-brand <?php if (isset($active_side_menu) && $active_side_menu == "home") { ?>active<?php } ?>">
                                <i class="fa fa-home"></i>
                            </a>
                        </div>
                        <div id="navbar-collapse-1" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li<?php if (isset($active_side_menu) && $active_side_menu == "blog") { ?> class="active"<?php } ?>>
                                    <a href="<?php echo site_url("blog"); ?>">Blog</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- /header-main-menu -->
</header>
<!-- /Header -->