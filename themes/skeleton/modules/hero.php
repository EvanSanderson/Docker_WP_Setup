<?php 
	$hero_image = get_template_directory_uri().'/dist/images/default_hero.jpg'; 
	$hero_title = get_the_title();
	$hero_type = "short_hero";
	$hero_summary = "";
	$summary_color = "";
	$links= [];

	if (null !== get_sub_field('hero_image'))
		$hero_image = get_sub_field('hero_image');

	$hero_title = get_sub_field('hero_title');
	$hero_summary = get_sub_field('hero_summary');
	$summary_color = get_sub_field('summary_color');
	$hero_type = get_sub_field('hero_type');

	if( have_rows('hero_links') ):

		while ( have_rows('hero_links') ) : the_row();

			$links[get_sub_field('link_name')]['name']= get_sub_field('link_name');;
			$links[get_sub_field('link_name')]['url'] = get_sub_field('link_url');

		endwhile;
	endif;
?>
<?php if ($hero_type == "slider_hero"){
	$i="hero-slider";
	include('wide_slider.php');

} else { ?>

<section id="hero" class="hero-banner <?php echo $hero_type; ?>" style="background:url('<?php echo $hero_image; ?>') no-repeat center center;background-size:cover;">
	<div class="center">

		<div class="flex-container">
			<div class="flex-col flex-2-3 flex-padding">
				<h1 class="hero-title"><?php echo $hero_title; ?></h1>
				<?php if ($hero_summary) { ?>
					<h4 class="hero-summary <?php echo $summary_color; ?>"><?php echo $hero_summary; ?></h4>
				<?php } ?>
			</div>

			<?php if ($links) { ?>
			<div class="flex-col flex-1-3 flex-padding">
				<?php foreach ($links as $link){
					echo '<div class="hero-links">';
						echo '<a class="with-arrow" href="'.$link["url"].'">'.$link["name"].'</a>';

					echo '</div>';
				} ?>
			</div>
			<?php } ?>

		</div>

	</div>
		
</section>
<?php } ?>