<?php
/**
 * Template Name: Cardápio
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage teste
 * @since teste
 */

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">

<?php 
        $today = $current_time('d/m/Y');
        

        $key = '_my_meta_value_key';
        
        $custom_fields = get_post_custom($post->ID, $key, true);
        $food_enter_date = $custom_fields['food_enter_date'][0];
        $food_exit_date = $custom_fields['food_exit_date'][0];

        $args = array( 'post_type' => 'food', 'posts_per_page' => 100 );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        if($today >= $food_enter_date && $today <= $food_exit_date) {
            
            the_title();
            echo '<br/><br/><div class="entry-content">';
            the_content();
            echo '</div><br/><br/>';
        }
        endwhile;?>

        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>
<?php get_footer();

//este conteudo deve ser inserido na pasta "page-templates do tema ativo 
?>
