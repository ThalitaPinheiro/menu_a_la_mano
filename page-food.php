<?php
/* Template Name: Cardápio
 */
    get_header(); 

    if (have_posts()): while (have_posts()) : the_post(); 
?>
	<section role="main" id="conteudo">
		<div class="wrapper">
			<h1 class="content-title"><?php the_title(); ?></h1>
			<div class="outside overlay-box">
				<div class="inside overlay-box">
                    <div class="tabbable boxed parentTabs">
						<ul class="nav nav-tabs">
                            <?php 
                                    the_content(); 
                                endwhile; endif;
                            ?>
                            <div class="tabbable boxed parentTabs">
                                <ul class="nav nav-tabs">
                            
							<?php
                                //Lista as categorias
                                $cat_args = array(
                                    'orderby'   => 'name',  //organizar categorias por nome
                                    'order'     => 'ASC',   //ordem ascendente
                                    'parent'    => 0        //Não possui categoria pai.
                                  );
                                
                                //Retorna array de categorias/taxonomy do tipo 'food'
                                $categories = get_terms('food', $cat_args);
                                $count_category = 0;
                                foreach($categories as $category) {
                                    if($count_category == 0) {
                                        echo '<li class="active"><a href="#set-'. $category->slug .'">' . $category->name . '</a></li>';
                                        $count_category = 1;
                                    }
                                    else {
                                        echo '<li><a href="#set-'. $category->slug .'">' . $category->name . '</a></li>';  
                                    }
                                }
                            // Fim Lista categorias
							?>
                    <div class="tabbable">
                    <ul class="nav nav-tabs">

                        <?php
                            //Lista as subcategorias
                                $cat_args = array(
                                    'orderby'   => 'name',  //organizar categorias por nome
                                    'order'     => 'ASC',   //ordem ascendente
                                    'parent'    => 0        //Não possui categoria pai.
                                  );
                                
                                //Retorna array de categorias/taxonomy do tipo 'food'
                                $categories = get_terms('food', $cat_args);
                                $count_category = 0;
                                foreach($categories as $category) {
							?>
						<div class="tab-content">
                            <?php
                                if($count_category == 0) {
                            echo '<div class="tab-pane fade active in" id="set-' . $category->slug . '">';
                                $count_category = 1;
                                }
                                else {
                                    echo '<div class="tab-pane fade" id="set-' . $category->slug . '">';
                                }
                            ?>
						</ul>
                            
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<?php
                                        
                                        $subcat_args = array(
                                            'orderby'   => 'name',
                                            'order'     => 'ASC',
                                            'parent'    => $category->term_id   
                                          );
                                        
                                        //Retorna array de categorias/taxonomy do tipo 'food'
                                        $subcategories = get_terms('food', $subcat_args);
                                        $count_subcat = 0;
                                        foreach($subcategories as $subcategory) {
                                            $args = array(
                                                'tax_query'  => array(
                                                    array(
                                                        'taxonomy'  => 'food',
                                                        'field'     => 'term_id',
                                                        'terms'     => $category->term_id)
                                                ),
                                                'post_type' => 'food'
                                            );
                                    
                                            $posts = get_posts($args);
                                            if ($posts) {
                                                if($count_subcat == 0) {
                                                echo '<li class="active"><a href="#set-'. $subcategory->slug .'">' . $subcategory->name . '</a></li>';
                                                $count_subcat = 1;
                                            } else {
                                                    echo '<li><a href="#set-'. $subcategory->slug .'">' . $subcategory->name . '</a></li>';
                                                }
                                                
                                            }
                                        }
                                }
                                //Fim lista subcategorias
										?>
									</ul>
									<div class="tab-content">
                        <?php
                                //Lista de posts por categoria e subcategoria
                                $cat_args = array(
                                    'orderby'   => 'name',  //organizar categorias por nome
                                    'order'     => 'ASC',   //ordem ascendente
                                    'parent'    => 0        //Não possui categoria pai.
                                  );
                                
                                //Retorna array de categorias/taxonomy do tipo 'food'
                                $categories = get_terms('food', $cat_args);
                                $count_category = 0;
                                foreach($categories as $category) {
                                    $args = array(
                                        'tax_query'  => array(
                                            array(
                                                'taxonomy'  => 'food',
                                                'field'     => 'term_id',
                                                'showposts' => 9999,
                                                'terms'     => $category->term_id)
                                        ),
                                        'post_type' => 'food'
                                    );
                            
                                    $posts = get_posts($args);
                                    $term_aux ='';
                                    if ($posts) {
                                        $count_post = 0;
                                    foreach($posts as $post) {
                                        $terms = get_the_terms($post->id, 'food');
                                        foreach($terms as $term) {
                                            if($category->name != $term->name && $term_aux != $term->name) {
                                                $term_aux = $term->name;
                                            }                      
                                        }
                                        
                                        $key = '_my_meta_value_key';
                                        $custom_fields = get_post_custom($post->ID, $key, true);
                                        $food_price = $custom_fields['food_price'][0];
                                        $food_enter_date = strtotime($custom_fields['food_enter_date'][0]);
                                        $food_exit_date = strtotime($custom_fields['food_exit_date'][0]);
                                        $today = strtotime(current_time('d/m/Y'));
                                        if($today >= $food_enter_date && $today <= $food_exit_date || $category->name=='À la Carte') {
                                            if($count_post == 0) {
                                                echo '<div class="tab-pane fade active in" id="set-' . $term->slug . '">';
                                                $count_post = 1;
                                            } else {
                                                echo '<div class="tab-pane fade" id="set-' . $term->slug . '">';
                                            }                         
                                            echo '<p class="dish-name">' . the_title('','',false) .'</p>
                                                <p>R$' . $food_price . '</p>
                                                <p>' . strip_tags($post->post_content) . '</p>
                                            </div>';                                              
                                        }
                                    }
                                }
                          } // foreach $categories
                    //Fim Lista de contéudo
                    ?>

					</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>