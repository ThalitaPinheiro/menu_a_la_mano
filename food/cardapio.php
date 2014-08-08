<?php
/*
 * Plugin Name: Menu a la Mano
 * Plugin URI:
 * Description: Este plugin ajuda no cadastro, edição e moderação de xulambss
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
                add_action( 'init', array($this, 'xulambs_post_type'));
                //Nova categoria
                add_action( 'init', array($this, 'xulambs_taxonomy'));                
                //Adiciona campo personalizado
                add_action("admin_init", array($this, 'xulambs_meta_box'));
                add_action('save_post', array($this, 'save_custom_xulambs'));
                
                //Menu xulambs
            //    add_action('admin_menu', array($this, 'register_xulambs_submenu_page'));
                
                //adapta lista
                add_filter("manage_edit-xulambs_columns", array($this, "xulambs_columns"));
                add_action("manage_xulambs_posts_custom_column", array($this, "xulambs_custom_columns"),10,2);
                add_action( 'restrict_manage_posts', array($this, 'my_filter_list') );
                add_filter( 'parse_query', array($this, 'perform_filtering') );
            } // END public function __construct
        
            
        /*    function register_xulambs_submenu_page() {
                add_submenu_page( 'edit.php?post_type=xulambs', 'xulambs Submenu Page', 'xulambs Submenu Page', 'manage_options', 'xulambs-submenu-page', array($this, 'xulambs') );                 
            }
          */  
            // Define o tipo de post xulambs
            function xulambs_post_type() {
                $labels = array(
                    'name'                => _x( 'Xulambss', 'Post Type General Name'),
                    'singular_name'       => _x( 'Xulambs', 'Post Type Singular Name'),
                    'menu_name'           => __( 'Xulambs'),
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
                    'label'               => __( 'xulambs'),
                    'description'         => __( 'Xulambs'),
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
                register_post_type( 'xulambs', $args );            
            } //Fim da função que cria post type xulambs

            // Registra tipos de vinho
            function xulambs_taxonomy() {
                $labels = array(
                    'name'                       => _x( 'Categorias do Xulambs', 'Taxonomy General Name'),
                    'singular_name'              => _x( 'Categoria do Xulambs', 'Taxonomy Singular Name'),
                    'menu_name'                  => __( 'Categoria do Xulambs'),
                    'all_items'                  => __( 'Todos as Categorias dos Xulambss'),
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
                register_taxonomy( 'xulambs', array( 'xulambs' ), $args );
            } // Fim função que cria categoria
            
            //Cria campo personalizado Preço
            function xulambs_meta_box() {
                
                add_meta_box(
                    'xulambs_meta_box',       //Nome do metabox
                    __('Outras informações (exceto A la Carte)'),        //Título da Caixa do campo personalizado
                    array($this, 'xulambs_meta'),   //Função que será chamada para exibir o conteúdo
                    'xulambs',             //Tipo de post que vai ter esse campo personalizado
                    'normal',           //Local da página de edição onde será exibido o campo personalizado
                    'high'              //Prioridade de onde vai aparecer a caixa - high, normal ou low
                 );
            }
            
            //Configura o campos personalizado Preço
            function xulambs_meta($post) {
                
                // Add an nonce field so we can check for it later.
                wp_nonce_field( 'xulambs_inner_custom_box', 'xulambs_inner_custom_box_nonce' );
            
                $custom_fields = get_post_custom($post->ID);
                $xulambs_price = $custom_fields['xulambs_price'][0];
                $xulambs_enter_date = $custom_fields['xulambs_enter_date'][0];
                $xulambs_exit_date = $custom_fields['xulambs_exit_date'][0];
                
                if(empty($xulambs_enter_date)) {
                    $xulambs_enter_date = current_time('d/m/Y');
                }
                if(empty($xulambs_exit_date)) {
                    $xulambs_exit_date = date('d/m/Y', mktime(0, 0, 0, date("m"), date("d")+7, date("Y")));
                }
                // Display the form, using the current value.
                echo '<label for="xulambs_price">';
                _e( 'Pratos');
                    $args = array('post_type' => 'food');
                    // The Query
                    $the_query = new WP_Query( $args );
                    
                    // The Loop
                    if ( $the_query->have_posts() ) {
                        echo '<ul>';
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            echo '<li><input type="checkbox" name="' . get_the_ID() . '" value="' . get_the_ID() . '">' . get_the_title() . '</li>';
                        }
                        echo '</ul>';
                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                
            }
            
            //Salva o campo personalizado quando o post é salvo
            function save_custom_xulambs($post_id) {
                
                /*
                 * We need to verify this came from the our screen and with proper authorization,
                 * because save_post can be triggered at other times.
                 */
                    
                // Check if our nonce is set.
                if ( ! isset( $_POST['xulambs_inner_custom_box_nonce'] ) )
                    return $post_id;
        
                $nonce = $_POST['xulambs_inner_custom_box_nonce'];
        
                // Verify that the nonce is valid.
                if ( ! wp_verify_nonce( $nonce, 'xulambs_inner_custom_box' ) )
                    return $post_id;
                
                // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                    return $post_id;
        
                // Check the user's permissions.
                if ( 'xulambs' == $_POST['post_type'] ) {
        
                    if ( ! current_user_can( 'edit_page', $post_id ) )
                        return $post_id;
            
                } else {
        
                    if ( ! current_user_can( 'edit_post', $post_id ) )
                        return $post_id;
                }
                /* OK, its safe for us to save the data now. */
                // Sanitize the user input.

        
                // Update the meta field.
  
            }
            
            
            
            
            
            
            
            
            
            
            
            
        } // END class Comida_a_la_mano
    } // END if(!class_exists('Comida_a_la_mano'))


    if(class_exists('Comida_a_la_mano'))
    {
        new Comida_a_la_mano();
    }

?>