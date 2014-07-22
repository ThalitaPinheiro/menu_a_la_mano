<?php


//$param = apply_filters('filtro_teste',false);

function func_filtro_teste($content){
    global $post;
	if (get_post_type( $post->ID )=='wine') {
		$args = array(  'post_type' => 'wine', 
          'posts_per_page' => '3');

        $loop = new WP_Query( $args );

        while ( $loop->have_posts() ) : $loop->the_post();
        	echo '<div class="entry-content">';
			echo $content;
			echo '</div>';
        endwhile;
    }
	
		return ;

}


add_filter('the_content', 'func_filtro_teste');

/*$query->set( 'post_type', array( 'wine', 'page', 'movie' ) );
		return $query;
		$args = array( 'post_type' => 'wine', 'posts_per_page' => 10 );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			the_title();
			echo '<div class="entry-content">';
			the_content();
			echo '</div>';
		endwhile;*/



/*
add_filter( 'post_type_archive_title', 'rp_post_type_archive_title' );

function rp_is_wine() {

	if ( post_type== 'wine'  || is_post_type_archive( 'wine' ) || is_tax( 'wine' ) )
		$is_wine_page = true;
	else
		$is_wine_page = false;

	return apply_filters( 'rp_is_wine', $is_wine_page );
}

function rp_wine_price( $post_id = '' ) {
	echo rp_get_wine_price( $post_id );
}

function rp_get_wine_price( $post_id = '' ) {

	if ( empty( $post_id ) )
		$post_id = get_the_ID();

	$price = apply_filters( 'rp_wine_price', get_post_meta( $post_id, 'wine_price', true ) );

	$price = !empty( $price ) ? floatval( $price ) : '';

	return $price;
}

function rp_formatted_wine_price( $post_id = '' ) {
	echo rp_get_formatted_wine_price( $post_id );
}

function rp_get_formatted_wine_price( $post_id = '' ) {
	$price = rp_get_wine_price( $post_id );

	if ( !empty( $price ) )
		/* Translators: The $ is for the currency symbol. The %s is the number. */
/*		return sprintf( __( '$%s', 'wine' ), number_format( $price, 2, '.', ',' ) );

	return '';
}

function rp_post_type_archive_title( $title ) {

	if ( is_post_type_archive( 'wine' ) ) {
		$post_type = get_post_type_object( 'wine' );
		$title     = isset( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $title;
	}

	return $title;
}

*/
/*
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_vinhos',
		'title' => 'Vinhos',
		'fields' => array (
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'wine',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'wine',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'discussion',
				3 => 'comments',
				4 => 'revisions',
				5 => 'slug',
				6 => 'author',
				7 => 'format',
				8 => 'categories',
				9 => 'tags',
				10 => 'send-trackbacks',
			),
		),
		'menu_order' => 100,
	));
} */

?>