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

?>

<section id="module-<?php echo $i; ?>" class="text-learn">
		<div class="flex-container center-aligned">
			<div class="flex-col flex-2-3 flex-padding">
				<h2 class="module-title"><?php echo $module_title; ?></h2>
				<hr class="half-width bold-hr">
				<?php if ($module_content) { ?>
					<div class="module-content"><?php echo $module_content; ?></div>
				<?php } ?>
			</div>

			
			<div class="flex-col flex-1-3 flex-padding">
				<?php if ($learn_more_text) { ?>
					<?php echo '<a class="learn-more with-arrow" href="'.$learn_more_link.'">'.$learn_more_text.'</a>'; ?>
					<hr class="long-line">
				<?php } ?>
			</div>

		</div>

	</div>
		
</section>