<section id="slide" class="slide-item" style="background:url('<?php echo get_sub_field("slide_image"); ?>') no-repeat center center;background-size:cover;">
	<div class="center">

		<div class="flex-container">
			<div class="flex-col flex-1-2 slider-content">
					<span class="section-tag"><?php echo get_sub_field("slide_tag"); ?></span>
				<h1 class="hero-title"><?php echo get_sub_field("slide_title"); ?></h1>
				<hr class="half-width bold-hr white">
				<div class="section-summary"><?php echo get_sub_field("slide_content"); ?></div>
				<?php if (get_sub_field("link_url")) { ?>
				<a class="learn-more with-arrow" href="<?php echo get_sub_field("link_url") ?>"><?php echo get_sub_field("link_name"); ?></a>
				<?php } ?>

			</div>


		</div>

	</div>
		
</section>
<?php wp_reset_postdata(); ?>