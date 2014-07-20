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

    if(!class_exists('Vino_a_la_mano'))
    {
        class Vino_a_la_mano
        {
            /**
             * Construct the class Vino_a_la_mano
             */
            public function __construct()
            {
                //Novo post type
                add_action( 'init', array($this, 'wine_post_type'));
                //Nova categoria
                add_action( 'init', array($this, 'wine_taxonomy'));                
                //Adiciona campo personalizado
                add_action("admin_init", array($this, 'wine_meta_box'));
                add_action('save_post', array($this, 'save_price_wine'));
            } // END public function __construct

            // Define o tipo de post Carta de Vinhos
            function wine_post_type() {
                $labels = array(
                    'name'                => _x( 'Carta de Vinhos', 'Post Type General Name'),
                    'singular_name'       => _x( 'Carta de Vinhos', 'Post Type Singular Name'),
                    'menu_name'           => __( 'Carta de Vinhos'),
                    'parent_item_colon'   => __( 'Parent Item:'),
                    'all_items'           => __( 'Todos os Itens'),
                    'view_item'           => __( 'Visualizar Item'),
                    'add_new_item'        => __( 'Adicionar Novo Item'),
                    'add_new'             => __( 'Adicionar Novo Vinho'),
                    'edit_item'           => __( 'Editar Item'),
                    'update_item'         => __( 'Atualizar Item'),
                    'search_items'        => __( 'Buscar  Item'),
                    'not_found'           => __( 'Não Encontrado'),
                    'not_found_in_trash'  => __( 'Não Encontrado na Lixeira'),
                );
                $args = array(
                    'label'               => __( 'wine'),
                    'description'         => __( 'Carta de Vinhos'),
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
                register_post_type( 'wine', $args );            
            } //Fim da função que cria post type Wine

            // Registra tipos de vinho
            function wine_taxonomy() {
                $labels = array(
                    'name'                       => _x( 'Categorias de Vinhos', 'Taxonomy General Name'),
                    'singular_name'              => _x( 'Categoria de Vinho', 'Taxonomy Singular Name'),
                    'menu_name'                  => __( 'Categoria de Vinho'),
                    'all_items'                  => __( 'Todos as Categorias de Vinho'),
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
                register_taxonomy( 'wine', array( 'wine' ), $args );
            } // Fim função que cria categoria
            
            //Cria campo personalizado Preço
            function wine_meta_box() {
                
                add_meta_box(
                    'wine_price',       //Nome do metabox
                    __('Preço'),        //Título da Caixa do campo personalizado
                    array($this, 'wine_meta'),   //Função que será chamada para exibir o conteúdo
                    'wine',             //Tipo de post que vai ter esse campo personalizado
                    'normal',           //Local da página de edição onde será exibido o campo personalizado
                    'high'              //Prioridade de onde vai aparecer a caixa - high, normal ou low
                 );
            }
            
            //Configura o campos personalizado Preço
            function wine_meta($post) {
                
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'wine_inner_custom_box', 'wine_inner_custom_box_nonce' );
            
                $value = get_post_meta($post->ID, '_my_meta_value_key', true);
                
                // Display the form, using the current value.
                echo '<label for="price">';
                _e( 'Preço');
                echo '</label> ';
                echo '<input type="number" id="price" name="price"';
                echo ' value="' . esc_attr( $value ) . '" />';                
            }
            
            //Salva o campo personalizado quando o post é salvo
            function save_price_wine($post_id) {
                
                /*
                 * We need to verify this came from the our screen and with proper authorization,
                 * because save_post can be triggered at other times.
                 */
                    
                // Check if our nonce is set.
                if ( ! isset( $_POST['wine_inner_custom_box_nonce'] ) )
                    return $post_id;
        
                $nonce = $_POST['wine_inner_custom_box_nonce'];
        
                // Verify that the nonce is valid.
                if ( ! wp_verify_nonce( $nonce, 'wine_inner_custom_box' ) )
                    return $post_id;
                
                // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                    return $post_id;
        
                // Check the user's permissions.
                if ( 'wine' == $_POST['post_type'] ) {
        
                    if ( ! current_user_can( 'edit_page', $post_id ) )
                        return $post_id;
            
                } else {
        
                    if ( ! current_user_can( 'edit_post', $post_id ) )
                        return $post_id;
                }
        
                /* OK, its safe for us to save the data now. */
        
                // Sanitize the user input.
                $mydata = sanitize_text_field( $_POST['price'] );
        
                // Update the meta field.
                update_post_meta( $post_id, '_my_meta_value_key', $mydata );   
            }
            
        } // END class Vino_a_la_mano
    } // END if(!class_exists('Vino_a_la_mano'))


    if(class_exists('Vino_a_la_mano'))
    {
        new Vino_a_la_mano();
    }

?>