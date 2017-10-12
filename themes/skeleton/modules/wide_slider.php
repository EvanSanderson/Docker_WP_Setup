<?php 
$slider_type = "wide_slider";
if (get_sub_field("slide_type")) $slider_type = get_sub_field("slide_type"); ?>

<section id = "module-<?php echo $i; ?>" class="flex-container regular slider <?php echo $slider_type; ?>">

            
      <?php if( have_rows('slides') ):
              if ($slider_type=="half_slider"){
                while ( have_rows('slides') ) : the_row(); 
                  include('half_slide_item.php');
                endwhile; 
              }
              else {
                while ( have_rows('slides') ) : the_row(); 
                  include('slide_item.php');
                endwhile;
                
              }
      
      endif; ?>

      <?php wp_reset_postdata(); ?>

                    
</section>
<?php wp_reset_query(); ?>