<?php 
	$module_image = "";
	$module_image_2 = "";
	$module_image_3 = "";
	$module_image_4 = "";

	if (null !== get_sub_field('module_image'))
		$module_image = get_sub_field('module_image');

	if (null !== get_sub_field('module_image_2'))
		$module_image_2 = get_sub_field('module_image_2');

	if (null !== get_sub_field('module_image_3'))
		$module_image_3 = get_sub_field('module_image_3');

	if (null !== get_sub_field('module_image_4'))
		$module_image_4 = get_sub_field('module_image_4');


?>

<section id="module-<?php echo $i; ?>" class="image-top-text images-4">

		<div class="flex-container center-aligned">
			<div class="flex-col flex-1-4 flex-padding image-flex" style="background:url('<?php echo $module_image ?>');background-size: cover; background-position: center center;">
			</div>

			<div class="flex-col flex-1-4 flex-padding image-flex" style="background:url('<?php echo $module_image_2 ?>');background-size: cover; background-position: center center;">
			</div>

			<div class="flex-col flex-1-4 flex-padding image-flex" style="background:url('<?php echo $module_image_3 ?>');background-size: cover; background-position: center center;">
			</div>

			<div class="flex-col flex-1-4 flex-padding image-flex" style="background:url('<?php echo $module_image_4 ?>');background-size: cover; background-position: center center;">
			</div>
			

		</div>

		
</section>