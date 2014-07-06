<?php
/*
Plugin Name: Menu a Mano
Plugin URL:
Description: Este plugin ajuda no cadastro, edição e moderação de cardapios
Author: ThalitaPinheiro
Version: 1.0
Author URL: http://profiles.wordpress.org/thalitapinheiro
*/

	function menu(){

		add_menu_page('Página - Cardápio','Cardápios',10 ,'menu_a_mano/menu_a_mano.php');
		add_submenu_page('menu_a_mano/menu_a_mano.php', 'Cardápio', 'Novo Cardápio',10,'menu_a_mano/new_menu.php');
		add_submenu_page('menu_a_mano/menu_a_mano.php', 'Cardápio', 'Lista Cardápios',10,'menu_a_mano/menu_a_mano.php');
	}

	add_action('admin_menu','menu')
?>