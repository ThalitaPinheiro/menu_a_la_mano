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
                        
                        ?>
                            <div class="tab-pane <?php echo $fade ?> " id="set-<?php echo $category->slug ?>">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs">
                        <?php
                            $subcategories = lista_subcategorias_food($category);
                        ?>
                                        </ul>
                                    <div class="tab-content">
                        <?php
                        $count_subcategory = 0;
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
                                ?>
                                        <div class="tab-pane fade <?php echo $fade ?> " id="set-<?php echo $subcategory->slug . '-' . $category->slug ?>">
                                <?php
                                foreach($posts as $post) {
                                    verificaCardapio($category, $post->ID);
                                }
                                ?>
                                        </div>
                                <?php
                            } //Post
                        } //subcategoria
                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                    } // if pratos 
            } // if cardapio
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