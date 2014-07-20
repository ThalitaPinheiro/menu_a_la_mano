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
                add_action('admin_menu', array($this, 'menu'));
                // Hook into the 'init' action
                
                add_action( 'init', array($this, 'wine_taxonomy'), 0 );
                
                add_action( 'init', array($this, 'wine_post_type'), 0 );
  
                //Adiciona campo personalizado
                add_action("admin_init", array($this, 'admin_init_wine'));
                add_action('save_post', array($this, 'save_price_wine'));
            
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
            }
            
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
            }
            
            function admin_init_wine() {
                
                add_meta_box(
                    'wine_price',       //Nome do metabox
                    __('Preço'),        //Título da Caixa do campo personalizado
                    array($this, 'wine_meta'),   //Função que será chamada para exibir o conteúdo
                    'wine',             //Tipo de post que vai ter esse campo personalizado
                    'normal',           //Local da página de edição onde será exibido o campo personalizado
                    'high'              //Prioridade de onde vai aparecer a caixa - high, normal ou low
                 );
            }
            
            function wine_meta() {
                global $post;
                $custom = get_post_custom($post->ID);
                $price = $custom["price"][0]; // define o campo preço | mesmo nome do input
?>
                <p>R$ <input type="text" name="price" id="price" min="0" step="0.01"  value="<?php echo $price; ?>" /></p>
<?php
            }
            
            //Salva o campo personalizado
            function save_price_wine() {
                global $post;
                // salva os campos personalizados
                update_post_meta($post->ID, "price", $_POST["price"]);
                // fim dos campos personalizados
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