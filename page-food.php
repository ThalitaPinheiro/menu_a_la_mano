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
                            'posts_per_page' => -1,
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
                                if($category->name == 'À La Carte') {
                                     echo '<p class="dish-name">' . the_title('','',false) . '</p>
                                            <p>' . strip_tags($post->post_content) . '</p>';
                                } else {
                                    verificaCardapio($category, $post->ID);
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

<?php
get_footer();
?>