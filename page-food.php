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
                    <?php 
                            the_content(); 
                        endwhile; endif;
                    ?>
                    <div class="tabbable boxed parentTabs">
						<ul class="nav nav-tabs">
							<?php
								lista_categorias_food();
							?>
						</ul>
                        <div class="tab-content">
<?php
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
                            'terms'     => $category->term_id)
                    ),
                    'post_type' => 'food'
                );
                $posts = get_posts($args);
                if ($posts) {    
                    $fade = '';
                    if($count_category == 0){
                        $fade = ' active in';
                        $count_category = 1;
                    }
                    echo '<div class="tab-pane' . $fade . '" id="set-' . $category->slug . '">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">';
                    
                    lista_subcategorias_food($category->term_id);
                    
                    $subcat_args = array(
                        'orderby'   => 'name',
                        'order'     => 'ASC',
                        'parent'    => $category->term_id
                      );
                    
                    //Retorna array de categorias/taxonomy do tipo 'food'
                    $subcategories = get_terms('food', $subcat_args);
                    $count_subcategory = 0;
                    echo '<div class="tab-content">';
                    foreach($subcategories as $subcategory) {
                        $args = array(
                            'tax_query'  => array(
                                array(
                                    'taxonomy'  => 'food',
                                    'field'     => 'term_id',
                                    'terms'     => $subcategory->term_id)
                            ),
                            'post_type' => 'food'
                        );
                        $posts = get_posts($args);
                        if ($posts) {
                            $fade = '';
                            if($count_subcategory == 0) {
                                $fade = ' active in';
                                $count_subcategory = 1;
                            }
                            echo '<div class="tab-pane fade' . $fade . '" id="set-' . $subcategory->slug . '">';
                            foreach($posts as $post) {
                                //recupera informações extras
                                $key = '_my_meta_value_key';
                                $custom_fields = get_post_custom($post->ID, $key, true);
                                $food_price = $custom_fields['food_price'][0];
                                $food_enter_date = strtotime($custom_fields['food_enter_date'][0]);
                                $food_exit_date = strtotime($custom_fields['food_exit_date'][0]);
                                $today = strtotime(current_time('d/m/Y'));
                                if($food_price) {
                                    $food_price = ' R$ ' . $food_price;
                                }
                                if($category->name == 'À la Carte') {
                                     echo '<p class="dish-name">' . the_title('','',false) . '</p>
                                            <p>' . strip_tags($post->post_content) . '</p>';
                                } elseif($today >= $food_enter_date && $today <= $food_exit_date) {
                                     echo '<p class="dish-name">' . the_title('','',false) .
                                            $food_price . '</p>
                                            <p>' . strip_tags($post->post_content) . '</p>';
                                }
                                
                            } //Post
                            echo '</div>';
                        }
                    } //subcategoria
                    echo '</div>';
                }
                echo '</div>
                </div>';
      } // foreach $categories
?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer();
                
    //Lista Categorias customizadas
	function lista_categorias_food() {
        $cat_args = array(
            'orderby'   => 'name',  
            'order'     => 'ASC',   
            'parent'    => 0        //Não possui categoria pai.
          );
        $categories = get_terms('food', $cat_args);
        $count_category = 0;
        foreach($categories as $category) {
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
                $class = '';
                if($count_category == 0) {
                    $class = ' class="active"';
                    $count_category = 1;
                }
                echo '<li' . $class . '><a href="#set-'. $category->slug .'">' . $category->name . '</a></li>';
            }
        }
    }

    //Lista SubCategorias customizadas
	function lista_subcategorias_food($parent_id) {               
        $subcat_args = array(
            'orderby'   => 'name',
            'order'     => 'ASC',
            'parent'    => $parent_id   
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
                        'terms'     => $subcategory->term_id)
                ),
                'post_type' => 'food'
            );
    
            $posts = get_posts($args);
            if ($posts) {
                $class = '';
                if($count_subcat == 0) {
                    $class = 'active';
                    $count_subcat = 1;
                }
                //lista Subcategorias
                echo '<li class="' . $class . '"><a href="#set-'. $subcategory->slug .'">' . $subcategory->name . '</a></li>';
            }
        }
        echo '</ul>';
    }
?>