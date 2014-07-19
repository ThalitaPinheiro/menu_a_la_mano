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
                add_action('admin_menu',array(&$this, 'menu'));

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