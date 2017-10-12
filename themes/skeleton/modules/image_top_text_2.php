<?php 
	$module_image = "";
	$module_title = get_the_title();
	$module_content = "";
	$learn_more_text = "";
	$learn_more_link = "";

	if (null !== get_sub_field('module_image'))
		$module_image = get_sub_field('module_image');

	$module_title = get_sub_field('module_title');
	$module_content = get_sub_field('module_content');
	$learn_more_text = get_sub_field('learn_more_text');
	$learn_more_link = get_sub_field('learn_more_link');

	/* Second item */
	$module_image_2 = "";
	$module_title_2 = get_the_title();
	$module_content_2 = "";
	$learn_more_text_2 = "";
	$learn_more_link_2 = "";

	if (null !== get_sub_field('module_image_2'))
		$module_image_2 = get_sub_field('module_image_2');

	$module_title_2 = get_sub_field('module_title_2');
	$module_content_2 = get_sub_field('module_content_2');
	$learn_more_text_2 = get_sub_field('learn_more_text_2');
	$learn_more_link_2 = get_sub_field('learn_more_link_2');

?>

<section id="module-<?php echo $i; ?>" class="image-top-text">

		<div class="flex-container center-aligned">
			<div class="flex-col flex-1-2 flex-padding image-flex" style="background:url('<?php echo $module_image ?>');background-size: cover; background-position: center center;">
			</div>

			<div class="flex-col flex-1-2 flex-padding image-flex" style="background:url('<?php echo $module_image_2 ?>');background-size: cover; background-position: center center;">
			</div>

			
			<div class="flex-col flex-1-2 flex-padding arrow-top lighterblue-bg">
				<h2 class="module-title"><?php echo $module_title; ?></h2>
				<hr class="half-width bold-hr">
				<?php if ($module_content) { ?>
					<div class="module-content"><?php echo $module_content; ?></div>
				<?php } ?>
				<?php if ($learn_more_text) { ?>
					<?php echo '<a class="learn-more with-arrow bottom" href="'.$learn_more_link.'">'.$learn_more_text.'</a>'; ?>
				<?php } ?>
			</div>
			

			
			<div class="flex-col flex-1-2 flex-padding arrow-top lighterblue-bg">
				<h2 class="module-title"><?php echo $module_title_2; ?></h2>
				<hr class="half-width bold-hr">
				<?php if ($module_content_2) { ?>
					<div class="module-content"><?php echo $module_content_2; ?></div>
				<?php } ?>
				<?php if ($learn_more_text_2) { ?>
					<?php echo '<a class="learn-more with-arrow bottom" href="'.$learn_more_link_2.'">'.$learn_more_text_2.'</a>'; ?>
				<?php } ?>
			</div>
			

		</div>

		
</section>