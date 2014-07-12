<?php
/*
Plugin Name: Menu a Mano
Plugin URL:
Description: Este plugin ajuda no cadastro, edição e moderação de cardapios
Author: ThalitaPinheiro, danielejcruz
Version: 1.0
Author URL: http://profiles.wordpress.org/thalitapinheiro ; https://github.com/danielejcruz
*/

	function menu(){

		add_menu_page('Página - Cardápio','Cardápios',10 ,'plugin/menu_a_la_mano.php');
		add_submenu_page('plugin/menu_a_la_mano.php', 'Cardápio', 'Novo Cardápio',10,'plugin/new_menu.php');
		add_submenu_page('plugin/menu_a_la_mano.php', 'Cardápio', 'Lista Cardápios',10,'plugin/menu_a_la_mano.php');
	}

	add_action('admin_menu','menu')
?>