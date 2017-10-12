<section id="slide" class="slide-item">
	<div class="center">


		<div class="flex-container">

			
			<div class="flex-col flex-1-2 flex-padding darkprimary-bg arrow-right">
				<h2 class="module-title"><?php echo get_sub_field("slide_content"); ?></h2>
				<hr class="half-width bold-hr">
				<span class="section-tag"><?php echo get_sub_field("slide_tag"); ?></span><br />
				<span class="section-tag"><?php echo get_sub_field("slide_title"); ?></span>
				<?php if (get_sub_field("link_url")) { ?>
				<a class="learn-more with-arrow" href="<?php echo get_sub_field("link_url") ?>"><?php echo get_sub_field("link_name"); ?></a>
				<?php } ?>
			</div>
			

			<div class="flex-col flex-1-2 flex-padding image-flex" style="background:url('<?php echo get_sub_field("slide_image"); ?>');background-size: cover; background-position: center center;">

			</div>

		</div>


	</div>
		
</section>
<?php wp_reset_postdata(); ?>