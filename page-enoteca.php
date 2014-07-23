<?php
/* Template Name: Carta de vinhos
 */
    get_header(); ?>

	<section role="main" id="conteudo">
		<div class="wrapper">
			<h1 class="content-title"><?php single_cat_title(''); ?></h1>
			<div class="outside overlay-box">
				<div class="inside overlay-box">
					<h2 class="dotted-title">Carta de vinhos</h2>
					<div class="scroll-pane">
						<div style="clear: both;"></div>
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
                                            'showposts' => 9999,
                                            'field'     => 'term_id',
                                            'terms'     => $category->term_id)
                                    ),
                                    'post_type' => 'wine'
                                );
                        
                                $posts = get_posts($args);
                                $term_aux ='';
                                if ($posts) {
                                    echo '<h3 class="wine-country">' . $category->name . '</h3>';  
                                    foreach($posts as $post) {
                                        $terms = get_the_terms($post->id, 'wine');
                                        foreach($terms as $term) {
                                            if($category->name != $term->name && $term_aux != $term->name) {
                                                $term_aux = $term->name;
                                                echo '<h4 class="wine-country">' . $term->name . '</h4> ';  
                                            }                      
                                        }
                                        
                                        $key = '_my_meta_value_key';
                                        $custom_fields = get_post_custom($post->ID, $key, true);
                                        $wine_year = $custom_fields['wine_year'][0];
                                        
                                        echo '<div class="wine-item">
                                                <h4 class="wine-name">' . the_title('','',false) . '</h4>
                                                <p class="wine-year">' . $wine_year . '</p>
                                                <p class="wine-description">' . strip_tags($post->post_content) . '</p>
                                            </div>';                
                                    }
                                }
                                
                              } // foreach $categories
                        ?>
						
						<div class="labels">
							<p>*3005 <strong>Taxa de Rolha R$ 40,00</strong></p>
							<p><strong>** Legenda Pontuações</strong></p>
							<ul class="list-of-wines">
								<li><strong>WS ‒ Wine Spectator</strong></li>
								<li><strong>RP ‒ Robert Parker</strong></li>
								<li><strong>GR ‒ Guia Gamero Rosso (1 a 3 ᴪ)</strong></li>
								<li><strong>W&amp;S ‒ Wine &amp; Spirits</strong></li>
								<li><strong>DEC ‒ Decanter (1 a 5 *)</strong></li>
								<li><strong>WE ‒ Wine Enthusiast</strong></li>
								<li><strong>JR ‒ Jancis Robinson (0 a 20)</strong></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>