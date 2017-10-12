<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<script src="https://use.typekit.net/inc6yhq.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<title>
	<?php bloginfo('name'); ?> | 
	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // We are loading our theme directory style.css by queuing scripts in our functions.php file ?>

<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/dist/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/dist/js/slick.min.js"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyB2Fdgrr4wuzqSylgXdb3z-cMtSOtIDjFg" type="text/javascript"></script>



</head>

<body <?php body_class(); ?> >

<header id="header" class="header">
	<div class="center">
		<div class="flex-container header-nav">
			<div class="flex-1-4 logo flex-padding">
				<a href="<?php echo esc_url(home_url( '/' ));?>">
					<svg style="width:3.3em;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 154.624 154.599" enable-background="new 0 0 154.624 154.599"><rect fill="#AC2EFF" width="154.624" height="154.599"/><path fill="#fff" d="M112.47 92.96l-1.926-3.35-33.088-57.585-13.07 22.744-1.914 3.332-32.993 57.42h95.953L112.47 92.96zm-6.028-1.62l-.024.01-25.433 10.833L96.81 84.07l9.578 7.23.054.04zM77.456 40.947l22.152 38.55.475.828 1.41 2.452-2.14-1.615-2.343-1.768-29.048-21.926 9.494-16.52zM66.024 60.84v-.008l.004.002 22.296 16.83-23.744-4.728 1.444-12.095zM94.16 82.15l-19.976 22.864-9.91-28.816 29.886 5.95zm-38.015 28.926H37.16l21.686-37.742.794-1.382 1.487-2.588-.336 2.817-.345 2.902-4.3 35.994zm3.875.037l.004-.038 3.298-27.62 7.873 22.897-11.088 4.723-.087.038zm11.553-.037H69.94l2.513-1.07 2.706-1.154 33.19-14.138 9.403 16.362H71.574z"/></svg>
				</a>
			</div>
			<div class="flex-3-4 main-menu flex-padding">
				<nav class="site-navigation main-navigation">
					<?php wp_nav_menu( array( 'menu_id' => '2', ) ); // Display the user-defined menu in Appearance > Menus ?>
				</nav><!-- .site-navigation .main-navigation -->
			</div>

		</div>
	</div>
	<a id="pull"></a>
</header>

<main class="main-fluid"><!-- start the page containter -->

	<!-- Page hero -->
	<?php if (is_search()){ ?>
		<section id="hero" class="hero-banner short_hero" style="background:url('<?php print get_template_directory_uri(); ?>/dist/images/default_hero.jpg') no-repeat center center;background-size:cover;">
			
			<div class="center">

				<div class="flex-container">
					<div class="flex-col flex-2-3 flex-padding">
	 					<?php echo '<h1 class="hero-title">Search Result for :  '.$s.'</h1>'; ?>
	 				</div>
	 			</div>
	 		</div>
	 	</section>

	


	<?php } else { ?>
	<?php $hero = false;
		
		if( have_rows('module') ):

			while( have_rows('module') ): the_row(); 

				$type = get_sub_field('module_type');
				if ($type == "hero"){
					$hero = true;
					include ('modules/hero.php');
				}
				
			endwhile;

		endif; 

		// default hero
		if (!$hero){
			if (get_the_post_thumbnail_url())
					$hero = get_the_post_thumbnail_url();
			else
					$hero = get_template_directory_uri().'/dist/images/default_hero.jpg';
			if (isset($post->post_type)) if ($post->post_type == "member")
					$hero = get_template_directory_uri().'/dist/images/member_hero.jpg'; ?>

			<section id="hero" class="hero-banner short_hero" style="background:url('<?php print $hero; ?>') no-repeat center center;background-size:cover;">
					<div class="center">
						<?php if (isset($post->post_type)) if ($post->post_type != "member"){ ?>
							<div class="flex-container">
								<div class="flex-col flex-2-3 flex-padding">
									<?php if (isset($post->post_type)) if ($post->post_type != "members") { ?>
										<h1 class="hero-title"><?php the_title(); ?></h1>
									<?php } ?>

									<?php if (get_field('subtitle')) { ?>
										<h4 class="hero-summary"><?php echo get_field('subtitle'); ?></h4>
									<?php } ?>
								</div>
							</div>
						<?php } ?>

					</div>
			
			</section>

		<?php } ?>
	<?php } ?>
