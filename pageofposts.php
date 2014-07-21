<?php
/**
 * Template Name: Page of Books
 *
 * Print posts of a Custom Post Type.
 */

get_header(); ?>
    <div id="container">
        <div id="content">
        <?php 
        $type = 'wine';
        $args = array (
         'post_type' => $type,
         'post_status' => 'publish',
         'paged' => $paged,
         'posts_per_page' => 2,
         'ignore_sticky_posts'=> 1
        );
        $temp = $wp_query; // assign ordinal query to temp variable for later use  
        $wp_query = null;
        $wp_query = new WP_Query($args); 
        if ( $wp_query->have_posts() ) :
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                echo '<h2>'; 
                the_title();
                echo '</h2>'; 
                echo '<div class="entry-content">';
                the_content();
                echo '</div>';
            endwhile;
        else :
            echo '<h2>Not Found</h2>';
            get_search_form();
        endif;
        $wp_query = $temp;
        ?>
        </div><!-- #content -->
    </div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>