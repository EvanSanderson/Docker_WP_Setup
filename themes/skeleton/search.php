<?php 
/* Template Name: Custom Search */        
get_header(); 
?>             

<section id="main-section" class="main-section">
    <section id="the-main-content" class="the-main-content">

            <div class="content-container">
                        
                    <div class="flex-container news-releases">   
        
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>    
                            <?php $i=""; $arrow=""; ?>
                            <div class="flex-col news-item full-width">
                                <?php include ('modules/news_horizontal.php'); ?>
                            </div>
                        <?php endwhile; ?><?php endif; ?>
                    </div>

                    <?php
                    global $wp_query;

                    $big = 999999999; // need an unlikely integer
                    $translated = __( '', 'mytextdomain' ); // Supply translatable string

                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $wp_query->max_num_pages,
                            'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
                    ) );
                    ?>
            </div>


    </section>
</section>

<?php get_footer(); ?>