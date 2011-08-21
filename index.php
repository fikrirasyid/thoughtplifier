<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title>
		<?php
			if 	( is_home() )			{ bloginfo("name"); echo (' | '); bloginfo('description'); }
			elseif	( is_single() )			{ wp_title(''); }
			elseif	( is_page() || is_paged() ) 	{ bloginfo('name'); wp_title('|'); }
			elseif	( is_archive() )		{ _e('Archive for ', 'essential'); wp_title(''); }			
			elseif	( is_author() )			{ wp_title(__(' | Post written by ', 'essential'));	} 
			elseif	( is_search() )			{ echo __('Search results for "', 'essential') . $s . '"'; }
			elseif	( is_404() )			{ _e('Four-oh-Four', 'essential'); } 
			else 					{ _e('Are You Lost?', 'essential'); }
		?>
	</title>
	
	<?php if (is_home()) { ?>
		<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php } ?>

	<meta name="robots" content="noodp,noydir" />
	
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="Shortcut Icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />

	
	<?php
		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' );}
		wp_head();
	?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">
	<div id="head">
		<div class="wrap">
			<div id="identity">
				<?php ess_sitename(); ?>
				<p id="tagline"><?php bloginfo('description'); ?></p>
			</div>
		</div><!-- .wrap -->
	</div><!-- #head -->
	
	<div id="nav">
		<div class="wrap">
			<?php wp_nav_menu(array('theme_location' => 'main_nav')); ?>
		</div><!-- .wrap -->
	</div><!-- #nav -->
	<div id="body">
		<div class="wrap clearfix">
			<div id="nav-bar">
				<ul><?php dynamic_sidebar('Navigation Bar'); ?></ul>
			</div>
			<div id="more-content-nav">
				<a href="#" class="hide">less</a>
				<a href="#">more</a>
			</div>
			
			<?php if (is_home() || is_category() || is_tag() || is_search()) { ?>
			<div class="content-title-wrap">
				<?php if (is_category()) { ?>
					<h1 id="content-title"><?php _e('Posts categorized into ', 'essential'); ?> <em><?php echo single_cat_title(); ?></em> :</h1>			
				<?php } elseif (is_tag()) { ?>
					<h1 id="content-title"><?php _e('Posts tagged with ', 'essential'); ?> <em><?php echo single_tag_title(); ?></em> :</h1>
				<?php } elseif (is_search()) { ?>
					<h1 id="content-title"><?php _e('Search results for ', 'essential'); ?> <em><?php echo $s ?></em> :</h1>
				<?php } ?>
			</div>				
			<?php } ?>
					
			<div id="content-wrap" class="clearfix">
				<?php get_template_part( 'loop', 'index' ); ?>
			</div>
			
			<?php if (!is_singular()) : ?>
				<div id="pagenavi">
					<?php pagenavi(); ?>
				</div>
			<?php endif; ?>
			
		</div><!-- .wrap -->
	</div><!-- #body -->
	<div id="foot" class="clearfix2">
		<div class="wrap">
			<p id="credit"><a href="http://outstando.com/thoughtplifier">Thoughtplifier Theme</a><br /> Designed &amp; developed by <br /> <a href="http://outstando.com">Fikri Rasyid</a></p>
			<ul id="bar-root"><?php dynamic_sidebar('Footer Bar'); ?></ul>
		</div><!-- .wrap -->
	</div><!-- #foot -->
</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>