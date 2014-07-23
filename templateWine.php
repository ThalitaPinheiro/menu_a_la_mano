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
            <p></p>
            <h2> Carta de Vinhos</h2>
            <p></p>
			<?php        
    
    $cat_args = array(
        'orderby'   => 'name',  //organizar categorias por nome
        'order'     => 'ASC',   //ordem ascendente
        'parent'    => 0        //Não possui categoria pai.
      );
    
    //Retorna array de categorias/taxonomy do tipo 'wine'
    $categories = get_terms('wine', $cat_args);


    foreach($categories as $category) {
        
        $args = array(
            'tax_query'  => array(
                array(
                    'taxonomy'  => 'wine',
                    'field'     => 'term_id',
                    'terms'     => $category->term_id)
            ),
            'post_type' => 'wine'
        );

        $posts = get_posts($args);
        $term_aux ='';
        if ($posts) {
            
            echo '<h3>' . $category->name.' </p> ';  
            foreach($posts as $post) {
                $terms = get_the_terms($post->id, 'wine');
                foreach($terms as $term) {
                    if($category->name != $term->name && $term_aux != $term->name) {
                        $term_aux = $term->name;
                        echo '<h4>' . $term->name.'</h4> ';  
                        
                        
                    }                      
                }
                echo '<ul>';
                        the_title();
                        echo '<br/><br/><div class="entry-content">';
                        the_content();
                        echo '</div><br/><br/>';
                  echo '</ul>';              
            }
        }
        
      } // foreach($categories
            ?>
            <p></p>
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
