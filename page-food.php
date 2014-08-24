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
              );
            
            //Retorna array de categorias/taxonomy do tipo 'food'
            $categories = get_terms('cardapio_type', $cat_args);
            $count_category = 0;
            foreach($categories as $category) {
                $args = array(
                    'post_type' => 'cardapio',
                    'tax_query'  => array(
                        array(
                            'taxonomy'  => 'cardapio_type',
                            'field'     => 'term_id',
                            'terms'     => $category->term_id)
                    ),
                    'post_status' => 'publish'
                );
                $cardapios = new WP_Query( $args );
                if ($cardapios->have_posts()) {
                    $cardapios->the_post();
                    $pratos = get_field('pratos');
                    if( $pratos ) {
                        $fade = '';
                        if($count_category == 0){
                            $fade = ' active in';
                            $count_category = 1;
                        }
                        echo '<div class="tab-pane' . $fade . '" id="set-' . $category->slug . '">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">';
                        
                        $subcategories = lista_subcategorias_food($category->term_id);
                    
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
                                    verificaCardapio($category, $post->ID);
                                }
                                echo '</div>';                                    
                            } //Post
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