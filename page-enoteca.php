<?php
/* Template Name: Carta de vinhos
 */
    get_header();

    if (have_posts()): while (have_posts()) : the_post(); 
?>
	<section role="main" id="conteudo">
		<div class="wrapper">
			<h1 class="content-title"><?php the_title(); ?></h1>
			<div class="outside overlay-box">
				<div class="inside overlay-box">
                    <?php 
                            the_content(); 
                        endwhile; endif;
                    ?>
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
                            $categories = get_terms('wine_type', $cat_args);
                        
                            foreach($categories as $category) {                                
                                $args = array(
                                    'tax_query'  => array(
                                        array(
                                            'taxonomy'  => 'wine_type',
                                            'showposts' => 9999,
                                            'field'     => 'term_id',
                                            'terms'     => $category->term_id)
                                    ),
                                    'post_type' => 'wine'
                                );
                        
                                $posts = get_posts($args);
                                $term_aux = '';
                                $count = 0;
                                if ($posts) {
                                    echo '<h3 class="wine-country">' . $category->name . '</h3>';  
                                    foreach($posts as $post) {
                                        $terms = get_the_terms($post->id, 'wine_type');
                                        foreach($terms as $term) {
                                            if($category->name != $term->name && $term_aux != $term->name) {
                                                $term_aux = $term->name;
                                                if($count == 0) {
                                                    echo '<h4 class="wine-country">' . $term->name . '</h4> ';
                                                    $count = 1;
                                                } else {
                                                    echo '<h5 class="wine-country">' . $term->name .'</h5>';
                                                    $count = 0;
                                                }
                                            }
                                        }
                                        
                                        $key = '_my_meta_value_key';
                                        $custom_fields = get_post_custom($post->ID, $key, true);
                                        $wine_year = $custom_fields['wine_year'][0];
                                        $wine_price = $custom_fields['wine_price'][0];
                                        $wine_ml = $custom_fields['wine_ml'][0];
                                        if($wine_ml)
                                            $wine_ml = $wine_ml . ' ml';
                                        if($wine_price)
                                            $wine_price = 'R$ ' . $wine_price;
                                        echo '<div class="wine-item">
                                                <h4 class="wine-name">' . the_title('','',false) . '</h4>
                                                <p class="wine-year">' . $wine_year . ' ' 
                                                . $wine_ml . ' ' . $wine_price .  '</p>
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