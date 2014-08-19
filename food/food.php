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
                
                //adapta lista
 //               add_filter("manage_edit-food_columns", array($this, "food_columns"));
//                add_action("manage_food_posts_custom_column", array($this, "food_custom_columns"),10,2);

            } // END public function __construct
        
            // Define o tipo de post Cardapio
            function food_post_type() {
                $labels = array(
                    'name'                => _x( 'Pratos', 'Post Type General Name'),
                    'singular_name'       => _x( 'Prato', 'Post Type Singular Name'),
                    'menu_name'           => __( 'Prato'),
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
                    'description'         => __( 'Prato'),
                    'labels'              => $labels,
                    'supports'            => array( 'title', 'editor'),
                    'hierarchical'        => false,
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

            // Registra tipos de food
            function food_taxonomy() {
                $labels = array(
                    'name'                       => _x( 'Categorias do Prato', 'Taxonomy General Name'),
                    'singular_name'              => _x( 'Categoria do Prato', 'Taxonomy Singular Name'),
                    'menu_name'                  => __( 'Categoria do Prato'),
                    'all_items'                  => __( 'Todos as Categorias dos Pratos'),
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
            
            function food_columns($columns){
                $columns = array(
                    'cb' => '<input type="checkbox" />',
                    'title' => __( 'Title' ),
                    'food' => __( 'Categorias do Prato' ),
                    'author' => __( 'Author' ),
                    'date' => __( 'Date' )
                );
            
                return $columns;
            }
            
            function food_custom_columns($column,$post_id) {
                global $post;
                switch( $column ) {
                    case 'food' :
                        $terms = get_the_terms( $post_id, 'food' );            
                        /* If terms were found. */
                        if ( !empty( $terms ) ) {
                            $out = array();
                            /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                            foreach ( $terms as $term ) {
                                $out[] = sprintf( '<a href="%s">%s</a>',
                                    esc_url( add_query_arg( array( 'post_type' => 'food', 'food' => $term->slug ), 'edit.php' ) ),
                                    esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'food', 'display' ) )
                                );
                            }
            
                            /* Join the terms, separating them with a comma. */
                            echo join( ', ', $out );
                        }
            
                        /* If no terms were found, output a default message. */
                        else {
                            _e( 'Sem categoria' );
                        }
            
                        break;
            
                    /* Just break out of the switch statement for everything else. */
                    default :
                        break;
                }    
            }
            
        } // END class Comida_a_la_mano
    } // END if(!class_exists('Comida_a_la_mano'))


    if(class_exists('Comida_a_la_mano'))
    {
        new Comida_a_la_mano();
    }

?>