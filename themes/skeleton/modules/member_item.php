<div class="flex-col flex-1-4 news-item member">
	<?php $member_type = get_sub_field("members_type"); ?>					
	<?php if (get_the_post_thumbnail_url()) { $arrow = "arrow-top"; ?>
		<a href="<?php print get_permalink().'?type='.$member_type; ?>"><div class="item-thumb" style="background:url('<?php print get_the_post_thumbnail_url(); ?>') no-repeat center center;background-size:cover;">
		</div></a>
	<?php } ?>

	<div class="news-teaser <?php echo $arrow; ?>">

		<?php the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '?type='.$member_type.'" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h3>' ); ?>

		<div class="news-meta">
			<?php echo get_field('title'); ?>
		</div>

		<div class="entry-content">
			<?php if ($member_type == "staff"){
			 	echo wp_trim_words(get_the_excerpt(), 20);
			} else {
				echo wp_trim_words(get_field("member_bio"), 20); } ?>
		</div>
	</div>

	<a class="learn-more with-arrow" href="<?php echo get_permalink().'?type='.$member_type; ?>"><?php echo get_sub_field('member_link'); ?></a>
	
</div>