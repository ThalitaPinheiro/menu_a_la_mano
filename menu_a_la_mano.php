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

    if(!class_exists('Menu_a_la_mano'))
    {
        class Menu_a_la_mano
        {
            /**
             * Construct the plugin object
             */
            public function __construct()
            {
                //MENU
                add_action('admin_menu', array(&$this, 'menu'));
                // Hook into the 'init' action
                
                add_action( 'init', array(&$this, 'wine_taxonomy'), 0 );
                
                add_action( 'init', array(&$this, 'create_posttype') );
  

                // register actions
            } // END public function __construct
    
            /**
             * Activate the plugin
             */
            public static function activate()
            {
                // Do nothing
            } // END public static function activate
    
            /**
             * Deactivate the plugin
             */     
            public static function deactivate()
            {
                // Do nothing
            } // END public static function deactivate
            
            function menu() {
                add_menu_page('Cardápios','Cardápios', 10 ,'menu_a_la_mano/menu_a_la_mano.php');
                add_submenu_page('menu_a_la_mano/menu_a_la_mano.php', 'Novo Cardápio', 'Novo Cardápio',10,'menu_a_la_mano/new_menu.php');
                add_submenu_page('menu_a_la_mano/menu_a_la_mano.php', 'Lista de Cardápio', 'Lista de Cardápios',10,'menu_a_la_mano/menu_a_la_mano.php');
            }
            
            // Registra tipos de vinho
            function wine_taxonomy() {
            
                $labels = array(
                    'name'                       => _x( 'Categorias de Vinhos', 'Taxonomy General Name', 'text_domain' ),
                    'singular_name'              => _x( 'Categoria de Vinho', 'Taxonomy Singular Name', 'text_domain' ),
                    'menu_name'                  => __( 'Categoria de Vinho', 'text_domain' ),
                    'all_items'                  => __( 'Todos as Categorias de Vinho', 'text_domain' ),
                    'parent_item'                => __( 'Parent Item', 'text_domain' ),
                    'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
                    'new_item_name'              => __( 'Nome de Nova Categoria', 'text_domain' ),
                    'add_new_item'               => __( 'Adicionar Nova Categoria', 'text_domain' ),
                    'edit_item'                  => __( 'Editar Categoria', 'text_domain' ),
                    'update_item'                => __( 'Atualizar Categoria', 'text_domain' ),
                    'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
                    'search_items'               => __( 'Buscar Categorias', 'text_domain' ),
                    'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
                    'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
                    'not_found'                  => __( 'Not Found', 'text_domain' ),
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
                register_taxonomy( 'wine', array( 'carta_vinhos' ), $args );
            }
            
            function create_posttype() {
                register_post_type( 'carta_vinhos',
                    array(
                        'labels' => array(
                            'name' => __( 'Carta de Vinhos' ),
                            'singular_name' => __( 'Carta de Vinhos' )
                        ),
                        'public' => true,
                        'has_archive' => true,
                        'rewrite' => array('slug' => 'products'),
                    )
                );
            }
            
        } // END class Menu_a_la_mano
    } // END if(!class_exists('Menu_a_la_mano'))


    if(class_exists('Menu_a_la_mano'))
    {
        // Installation and uninstallation hooks
        register_activation_hook(__FILE__, array('Menu_a_la_mano', 'activate'));
        register_deactivation_hook(__FILE__, array('Menu_a_la_mano', 'deactivate'));
    
        // instantiate the plugin class
        $wp_plugin_template = new Menu_a_la_mano();
    }

?>