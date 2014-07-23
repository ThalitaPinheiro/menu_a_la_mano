<?php
/**
 * Template Name: Carta de vinhos
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
            <h1>Enoteca</h1>
            <h2> Carta de Vinhos</h2>
			<?php 
			
/*
		$args = array( 'post_type' => 'wine', 'posts_per_page' => 100 );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
            
            the_title();
			echo '<br/><br/><div class="entry-content">';
			the_content();
			echo '</div><br/><br/>';
		endwhile;
*/
            

    $cat_args = array(
        'orderby'   => 'name',
        'order'     => 'ASC',
        'parent'    => 0
      );
    
    $categories = get_terms('wine', $cat_args);

    foreach($categories as $category) {
        
/*        $args = array(
            'showposts' => -1,
            'tax_query'  => array(
                array(
                    'taxonomy'  => 'wine',
                    'field'     => 'term_id',
                    'terms'     => $category->term_id)
            ),
            'post_type' => 'wine'
        );

        $posts = get_posts($args);*/
    
        
            
            echo '<h3>Categoria: ' . $category->name.' </p> ';  
        
        
        $subcat_args = array(
            'orderby'   => 'name',
            'order'     => 'ASC',
            'parent'    => $category->term_id
          );
    
        $subcategories = get_terms('wine', $subcat_args);
    
        foreach($subcategories as $subcategory) {
        /*        $args = array(
                    'showposts' => -1,
                    'tax_query'  => array(
                        array(
                            'taxonomy'  => 'wine',
                            'field'     => 'term_id',
                            'terms'     => $subcategory->term_id)
                    ),
                    'post_type' => 'wine'
                );
    
        $posts = get_posts($args);
    
        if ($posts) {*/
            
            echo '<h4>: ' . $subcategory->name.'</h4> ';  
/*                
              echo '<ul>';
              foreach($posts as $post) {
                    the_title();
                    echo '<br/><br/><div class="entry-content">';
                    the_content();
                    echo '</div><br/><br/>';
              } // foreach($posts
              echo '</ul>';*/
     
           // } // if ($posts
        } // foreach $subcategories
      } // foreach($categories

            
            
            ?>
            
            
            
            <p>*3005 Taxa de Rolha R$ 40,00</p>    
            <p>** Legenda Pontuações</p>
            <p>WS ‒ Wine Spectator</p>
            <p>RP ‒ Robert Parker</p>
            <p>GR ‒ Guia Gamero Rosso (1 a 3 ᴪ)</p>
            <p>W&S ‒ Wine & Spirits</p>
            <p>DEC ‒ Decanter (1 a 5 *)</p>
            <p>WE ‒ Wine Enthusiast</p>    
            <p>JR ‒ Jancis Robinson (0 a 20)</p>    
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>
<?php get_footer();

//este conteudo deve ser inserido na pasta "page-templates do tema ativo 
?>
