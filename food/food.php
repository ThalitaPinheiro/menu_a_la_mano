<?php
/*
 * Plugin Name: Menu a la Mano
 * Plugin URI:
 * Description: Este plugin ajuda no cadastro, edição e moderação de cardapios
 * Version: 1.0
 * Author: ThalitaPinheiro, danielejcruz
 * Author URI: http://profiles.wordpress.org/thalitapinheiro ; https://github.com/danielejcruz
 * License: GPL2
*/

/*  Copyright YEAR  Thalita Nick Pinheiro e Daniele Jane Cruz  (email: thalitanpg@gmail.com, danielejcruz@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

    if (!defined('ABSPATH')) exit; // Exit if accessed directly

    if(!class_exists('Comida_a_la_mano'))
    {
        class Comida_a_la_mano
        {
            /**
             * Construct the class Comida_a_la_mano
             */
            public function __construct()
            {
                //Novo post type
                add_action( 'init', array($this, 'food_post_type'));
                //Nova categoria
                add_action( 'init', array($this, 'food_taxonomy'));                
                //Adiciona campo personalizado
                add_action("admin_init", array($this, 'food_meta_box'));
                add_action('save_post', array($this, 'save_custom_food'));
                add_filter('the_content', array($this, 'food_filter'));
            } // END public function __construct

            // Define o tipo de post Carta de Vinhos
            function food_post_type() {
                $labels = array(
                    'name'                => _x( 'Cardápios', 'Post Type General Name'),
                    'singular_name'       => _x( 'Cardápio', 'Post Type Singular Name'),
                    'menu_name'           => __( 'Cardápio'),
                    'parent_item_colon'   => __( 'Parent Item:'),
                    'all_items'           => __( 'Todos os Itens'),
                    'view_item'           => __( 'Visualizar Item'),
                    'add_new_item'        => __( 'Adicionar Novo Item'),
                    'add_new'             => __( 'Adicionar Novo Prato'),
                    'edit_item'           => __( 'Editar Item'),
                    'update_item'         => __( 'Atualizar Item'),
                    'search_items'        => __( 'Buscar  Item'),
                    'not_found'           => __( 'Não Encontrado'),
                    'not_found_in_trash'  => __( 'Não Encontrado na Lixeira'),
                );
                $args = array(
                    'label'               => __( 'food'),
                    'description'         => __( 'Cardápio'),
                    'labels'              => $labels,
                    'supports'            => array( 'title', 'editor'),
                    'hierarchical'        => true,
                    'public'              => true,
                    'show_ui'             => true,
                    'show_in_menu'        => true,
                    'show_in_nav_menus'   => true,
                    'show_in_admin_bar'   => true,
                    'menu_position'       => 100,
                    'can_export'          => true,
                    'has_archive'         => true,
                    'exclude_from_search' => false,
                    'publicly_queryable'  => true,
                    'capability_type'     => 'page',
                );
                register_post_type( 'food', $args );            
            } //Fim da função que cria post type food

            // Registra tipos de vinho
            function food_taxonomy() {
                $labels = array(
                    'name'                       => _x( 'Categorias do Cardápio', 'Taxonomy General Name'),
                    'singular_name'              => _x( 'Categoria do Cardápio', 'Taxonomy Singular Name'),
                    'menu_name'                  => __( 'Categoria do Cardápio'),
                    'all_items'                  => __( 'Todos as Categorias dos Cardápios'),
                    'parent_item'                => __( 'Parent Item'),
                    'parent_item_colon'          => __( 'Parent Item:'),
                    'new_item_name'              => __( 'Nome de Nova Categoria'),
                    'add_new_item'               => __( 'Adicionar Nova Categoria'),
                    'edit_item'                  => __( 'Editar Categoria'),
                    'update_item'                => __( 'Atualizar Categoria'),
                    'separate_items_with_commas' => __( 'Separate items with commas'),
                    'search_items'               => __( 'Buscar Categorias'),
                    'add_or_remove_items'        => __( 'Adicionar ou remover categorias'),
                    'choose_from_most_used'      => __( 'Escolher entre as categorias mais usadas'),
                    'not_found'                  => __( 'Não encontrada'),
                );
                $args = array(
                    'labels'                     => $labels,
                    'hierarchical'               => true,
                    'public'                     => true,
                    'show_ui'                    => true,
                    'show_admin_column'          => false,
                    'show_in_nav_menus'          => true,
                    'show_tagcloud'              => false,
                );
                register_taxonomy( 'food', array( 'food' ), $args );
            } // Fim função que cria categoria
            
            //Cria campo personalizado Preço
            function food_meta_box() {
                
                add_meta_box(
                    'food_price',       //Nome do metabox
                    __('Outras informações (exceto A la Carte)'),        //Título da Caixa do campo personalizado
                    array($this, 'food_meta'),   //Função que será chamada para exibir o conteúdo
                    'food',             //Tipo de post que vai ter esse campo personalizado
                    'normal',           //Local da página de edição onde será exibido o campo personalizado
                    'high'              //Prioridade de onde vai aparecer a caixa - high, normal ou low
                 );
            }
            
            //Configura o campos personalizado Preço
            function food_meta($post) {
                
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'food_inner_custom_box', 'food_inner_custom_box_nonce' );
            
                $custom_fields = get_post_custom($post->ID);
                $food_price = $custom_fields['food_price'][0];
                $food_enter_date = $custom_fields['food_enter_date'][0];
                $food_exit_date = $custom_fields['food_exit_date'][0];
                
                if(empty($food_enter_date)) {
                    $food_enter_date = current_time('d/m/Y');
                }
                if(empty($food_exit_date)) {
                    $food_exit_date = current_time('d/m/Y');
                }
                // Display the form, using the current value.
                echo '<label for="food_price">';
                _e( 'Preço');
                echo '</label> ';
                echo '<input type="number" id="food_price" name="food_price"';
                echo ' value="' . esc_attr( $food_price ) . '" />';
                
                // Display the form, using the current value.
                echo '<p><label for="food_enter_date">';
                _e( 'Data de entrada');
                echo '</label> ';
                echo '<input type="date" id="fodd_enter_date" name="food_enter_date"';
                echo ' value="' . esc_attr( $food_enter_date ) . '" /></p>';

                // Display the form, using the current value.
                echo '<p><label for="food_exit_date">';
                _e( 'Data de saída');
                echo '</label> ';
                echo '<input type="date" id="fodd_exit_date" name="food_exit_date"';
                echo ' value="' . esc_attr( $food_exit_date ) . '" /></p>';
                
            }
            
            //Salva o campo personalizado quando o post é salvo
            function save_custom_food($post_id) {
                
                /*
                 * We need to verify this came from the our screen and with proper authorization,
                 * because save_post can be triggered at other times.
                 */
                    
                // Check if our nonce is set.
                if ( ! isset( $_POST['food_inner_custom_box_nonce'] ) )
                    return $post_id;
        
                $nonce = $_POST['food_inner_custom_box_nonce'];
        
                // Verify that the nonce is valid.
                if ( ! wp_verify_nonce( $nonce, 'food_inner_custom_box' ) )
                    return $post_id;
                
                // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                    return $post_id;
        
                // Check the user's permissions.
                if ( 'food' == $_POST['post_type'] ) {
        
                    if ( ! current_user_can( 'edit_page', $post_id ) )
                        return $post_id;
            
                } else {
        
                    if ( ! current_user_can( 'edit_post', $post_id ) )
                        return $post_id;
                }
        
                /* OK, its safe for us to save the data now. */
                
                // Sanitize the user input.
                $food_price = sanitize_text_field( $_POST['food_price'] );
                $food_enter_date = sanitize_text_field( $_POST['food_enter_date'] );
                $food_exit_date = sanitize_text_field( $_POST['food_exit_date'] );
        
                // Update the meta field.
                update_post_meta( $post_id, 'food_price', $food_price );
                update_post_meta( $post_id, 'food_enter_date', $food_enter_date );
                update_post_meta( $post_id, 'food_exit_date', $food_exit_date );
                
            }
            
            //Mostra as informações adicionais
            function food_filter($content) {
                global $post;
                if(get_post_type($post) == 'food') {
                    $key = '_my_meta_value_key';
                    
                    $custom_fields = get_post_custom($post->ID, $key, true);
                    $food_price = $custom_fields['food_price'][0];
                    $food_enter_date = $custom_fields['food_enter_date'][0];
                    $food_exit_date = $custom_fields['food_exit_date'][0];
                    
                    $custom_content = 'R$ ' . $food_price;
                    
                    $content = $content . $custom_content;
                }
                return $content;
            }
        } // END class Comida_a_la_mano
    } // END if(!class_exists('Comida_a_la_mano'))


    if(class_exists('Comida_a_la_mano'))
    {
        new Comida_a_la_mano();
    }

?>