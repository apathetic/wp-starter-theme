<!doctype html>  

<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<title><?php wp_title(''); ?></title>
	
	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>

<body <?php body_class(); ?>>

	<header class="clearfix">
		<a id="logo" href="<?php echo home_url(); ?>">
			<img src="<?php echo get_bloginfo('template_url') ?>/images/logos/logo.png" title="<?php bloginfo('name'); ?>" alt="<?php wp_title(''); ?>" />
		</a>
		<nav>
			<ul>
				<?php wp_nav_menu(array('menu'=>'Main','container'=>false,'items_wrap'=>'%3$s')); ?>
			</ul>
		</nav>

		<form role="search" method="get" id="search" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="" name="s" id="s" placeholder="search" />
		</form>

	</header>
