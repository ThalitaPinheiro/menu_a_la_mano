<?php
	require_once(get_stylesheet_directory() . '/theme-options.php');
	date_default_timezone_set("Brazil/East");
	ob_start();

	// Altera logo da página de login
	function MeuLogoLogin(){
		echo '
			<style  type="text/css">
				h1 a{
					background-image:url('.get_bloginfo('template_directory').'/logo-login.png) !important;
					width: 320px !important;
					background-size: 320px !important;
				}
			</style>'
		;
	}
	add_action('login_head',  'MeuLogoLogin');

	// Css no painel
	function MyCustomLogo() {
		echo '
			<style  type="text/css">
				#adminmenu li.wp-menu-separator{
					border-top: 1px solid #CCC !important;
					border-bottom: 1px solid #CCC !important;
				}
				#adminmenu{
					margin-top: 0px;
					border-top: 5px solid #e14d43;
					border-bottom: 5px solid #e14d43;
				}
				#wp-admin-bar-comments, #toplevel_page_edit-post_type-acf{
					display: none;
				}
			</style>';
	}
	add_action('admin_head', 'MyCustomLogo');

	// Remove informações da barra superior
	function WpsAdminBar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
		$wp_admin_bar->remove_menu('view-site');
	}
	add_action('wp_before_admin_bar_render', 'WpsAdminBar');

	// Remove aba de opção de tela
	function RemoveScreenOptions(){
		return false;
	}
	add_filter('screen_options_show_screen', 'RemoveScreenOptions');

	// Mostra barra de admin somente para administradores
	if(!current_user_can('manage_options')){
		add_filter('show_admin_bar', '__return_false');
	}

	// Página de Personalização do usuário
	function SaLayoutView(){
		global $sa_options;
		$settings = get_option('sa_options', $sa_options);
	}
	add_action('wp_head', 'SaLayoutView');

	//Definições de envio de E-mail
	global $sa_options;
	$sa_settings = get_option('sa_options', $sa_options);
	//define(host,$sa_settings['host']);
	//define(emailautenticacao,$sa_settings['emailautenticacao']);
	//define(emailautenticacaosenha,$sa_settings['emailautenticacaosenha']);
	//define(emailsend,$sa_settings['emailsend']);

	//Removendo informações da pg inicial do admin
	function DelSecoesPainel(){
		global$wp_meta_boxes; unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); 
	}add_action('wp_dashboard_setup', 'DelSecoesPainel');

	//Alterando Rodapé do Admin
	function AltAdminFooter(){
		echo '<span id="footer-thankyou">Tema Desenvolvido por <a href="http://www.desertodigital.com.br" title="by Deserto Digital" target="_blank">Deserto Digital</a>
		power by <a href="http://br.wordpress.org/" title="Visite o site do Wordpress" target="_blank">Wordpress</a></span>';
	}add_filter('admin_footer_text', 'AltAdminFooter');

	//Esconde mensagem de atualizacao
	function wphidenag(){
		remove_action('admin_notices','update_nag',3);
	}
	add_action('admin_menu','wphidenag');

	//Habilita Imagem de Destaque
	add_theme_support('post-thumbnails');

	// Registrando os Menus
	if(function_exists('register_nav_menu')){
		register_nav_menu('menu_topo', 'Menu Topo');
	}

	//Esconde itens do menu adm
	function RemoveLinksMenu(){
		remove_menu_page('options-general.php');
		remove_menu_page('tools.php');
		remove_menu_page('plugins.php');
		remove_menu_page('edit-comments.php');
		remove_submenu_page('index.php','update-core.php');
		remove_submenu_page('edit.php','edit-tags.php?taxonomy=post_tag');
		remove_submenu_page('themes.php','themes.php');
		remove_submenu_page('themes.php','customize.php');
	}
	add_action('admin_menu', 'RemoveLinksMenu');

	// Remove editor do tema
	function RemoveEditorMenu(){
		remove_action('admin_menu', '_add_themes_utility_last', 101);
	}
	add_action('_admin_menu', 'RemoveEditorMenu', 1);

	// Remove Shortcodes
	function RemoveShortcode($content){
		$content = strip_shortcodes($content);
		return $content;
	}

	// Exibir SubCategorias
	function ListSubCategories($idcategory,$retorno){
		global $ancestor;
		$childcats = get_categories('orderby=order&child_of=' . $idcategory . '&show_count=1');
		$i = 0; foreach ($childcats as $childcat){
			if(cat_is_ancestor_of($ancestor, $childcat->cat_ID) == false){
				if($retorno == '1'){
					$f[] = $childcat->slug;
				}else{
					if($i == 0){
						$class = ' class="active"';
					}else{
						$class = '';
					}

					if($childcat->cat_name == 'Massas Artesanais'){
						$NomeCategoria = 'Massas<span class="clear-row"></span>Artesanais';
					}elseif($childcat->cat_name == 'Peixes e Frutos do Mar'){
						$NomeCategoria = 'Peixes e<span class="clear-row"></span>Frutos do Mar';
					}elseif($childcat->cat_name == 'Carnes e Aves'){
						$NomeCategoria = 'Carnes e<span class="clear-row"></span>Aves';
					}elseif($childcat->cat_name == 'Especial da casa para 2 pessoas'){
						$NomeCategoria = 'Especial da casa<span class="clear-row"></span>para 2 pessoas';
					}else{
						$NomeCategoria = $childcat->cat_name;
					}

					echo '<li' . $class . '><a href="#set-'. $childcat->slug .'">' . $NomeCategoria . '</a></li>';
				}
				$ancestor = $childcat->cat_ID;
			}
			$i++;
		}
		if($retorno == '1'){
			return $f;
		}
		
		$ancestor = '';
		$childcats = '';
		$f = '';
	}

	// Exibe posts
	function GetPostsCategory($CategoryName,$enoteca){
		query_posts('showposts=9999&category_name=' . $CategoryName . '&orderby=order');
		if(have_posts()): while (have_posts()) : the_post();
			if($enoteca == '1'){
				echo '
					<div class="wine-item">
						<h4 class="wine-name">' . the_title('','',false) . '</h4>
						<p class="wine-year">' . get_field('ano') . '</p>
						<p class="wine-year">' . get_field('ml') . '</p>
						<p class="wine-description">' . strip_tags(get_the_content()) . '</p>
					</div>
				';
			}else{
				echo '<p class="dish-name">' . the_title('','',false) . '</p>';
				echo '<p>' . strip_tags(get_the_content()) . '</p>';
			}
		endwhile; endif;
	}

    //Lista Categorias customizadas da taxonomy food
	function lista_categorias_food() {
        $cat_args = array(
            'orderby'   => 'name',  
            'order'     => 'ASC',   
            'parent'    => 0        //Não possui categoria pai.
          );
        $categories = get_terms('food', $cat_args);
        $count_category = 0;
        foreach($categories as $category) {
            $args = array(
                    'tax_query'  => array(
                        array(
                            'taxonomy'  => 'food',
                            'field'     => 'term_id',
                            'terms'     => $category->term_id)
                    ),
                    'post_type' => 'food'
                );
            $posts = get_posts($args);
            if ($posts) {        
                $class = '';
                if($count_category == 0) {
                    $class = ' class="active"';
                    $count_category = 1;
                }
                echo '<li' . $class . '><a href="#set-'. $category->slug .'">' . $category->name . '</a></li>';
            }
        }
    }

    //Lista SubCategorias customizadas da taxonomy food
	function lista_subcategorias_food($parent_id) {               
        $subcat_args = array(
            'orderby'   => 'name',
            'order'     => 'ASC',
            'parent'    => $parent_id   
        );
        //Retorna array de categorias/taxonomy do tipo 'food'
        $subcategories = get_terms('food', $subcat_args);
        $count_subcat = 0;
        foreach($subcategories as $subcategory) {
            $args = array(
                'tax_query'  => array(
                    array(
                        'taxonomy'  => 'food',
                        'field'     => 'term_id',
                        'terms'     => $subcategory->term_id)
                ),
                'post_type' => 'food'
            );
    
            $posts = get_posts($args);
            if ($posts) {
                $class = '';
                if($count_subcat == 0) {
                    $class = 'active';
                    $count_subcat = 1;
                }
                //lista Subcategorias
                echo '<li class="' . $class . '"><a href="#set-'. $subcategory->slug .'">' . $subcategory->name . '</a></li>';
            }
        }
        echo '</ul>';
    }




	// Função de Cadastro no banco
	function create($tabela, array $datas){
		$fields = implode(", ",array_keys($datas));
		$values = "'".implode("', '",array_values($datas))."'";
		$qrCreate = "INSERT INTO {$tabela} ($fields) VALUES ($values)";
		$stCreate = mysql_query($qrCreate) or die('Erro ao Cadastrar em: '.$tabela.' '.mysql_error());
		if($stCreate) {return true;}
	}

	//Enviar Contato
	function formularios($array,$assunto,$tipo){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		require_once('mail/class.phpmailer.php');

		// Get Name and E-mail
		for($i = 0; $i < count($array); $i++){
			$valor = explode(': ',$array[$i]);
			if($valor[0] == 'Nome' || $valor[0] == 'Name'){
				$nome = $valor[1];
			}elseif($valor[0] == 'E-mail'){
				$email = $valor[1];
			}
		}

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth         = true;
		$mail->IsHTML(true);
		$mail->Host             = host;
		$mail->Port             = '587';
		$mail->Username         = emailautenticacao;
		$mail->Password         = emailautenticacaosenha;
		$mail->From             = emailautenticacao;
		$mail->FromName         = get_bloginfo('name');
		$mail->AddReplyTo($email, $nome);
		$mail->Subject = $assunto;

		if($tipo == 'reserva' || $tipo == 'evento'){
			$f['nome'] = $array[0];
			$f['email'] = $array[1];
			$f['telefone1'] = $array[2];
			$f['telefone2'] = $array[3];
			$f['data'] = $array[4];
			$f['horario'] = $array[5];
			$f['numeropessoas'] = $array[6];
			$f['mensagem'] = $array[7];
			$f['tipo'] = $tipo;
			create('wp_contatos',$f);
		}

		$mail->Body = '
			<html>
			<body>
				<center>
					<img src="' . get_option('home') . '/wp-content/themes/serafini/images/logos/logo-login.png" 
					width="320" height="80" alt="' . get_bloginfo('name') . '" title="' . get_bloginfo('name') . '" />
				</center>
				
				<br/><br/>

				<p style="text-align: center; width: 100%;">E-mail de contato enviado através do site <a href="' . get_option('home') . '" 
				title="Acessar Site">' . get_bloginfo('name') . '</a></p><br/></br>

				<table style="width: 100%; float: left; border: 1px solid #272c37;">
		';

		// Campos
		for($i = 0; $i < count($array); $i++){
			$valor = explode(': ',$array[$i]);
			$mail->Body .= '
				<tr> 
					<td style="border: 1px solid #272c37; padding: 5px; background-color: #EEE; font-family: \'Arial\'; font-size: 12px; width: 30%; background-color: #272c37; color: #FFF;">* ' . $valor[0] . '</td>
					<td style="border: 1px solid #272c37; padding: 5px; background-color: #EEE; font-family: \'Arial\'; font-size: 12px;">' . $valor[1] . '</td>
				</tr>
			';
		}

		$mail->Body .= '
				</table>
				
				<br /><br />
				<p style="float: left;">Enviado em : '.date('d/m/Y').' &aacute;s '.date('H:i:s').' hs</p>    

			</body>
			</html>
		';
		
		$mail->AddAddress(emailsend, $assunto);

		if($mail->Send()){
			
			if($tipo == 'reserva'){
				//header('Location: ' . get_option('home') . '/reserva-enviada');
				header('Location: ' . get_option('home') . '/?p=43');
			}

			if($tipo == 'evento'){
				//header('Location: ' . get_option('home') . '/evento-enviado');
				header('Location: ' . get_option('home') . '/?p=47');
			}

		}else{

			if($tipo == 'reserva'){
				//header('Location: ' . get_option('home') . '/reserva-nao-enviada');
				header('Location: ' . get_option('home') . '/?p=45');
			}

			if($tipo == 'evento'){
				//header('Location: ' . get_option('home') . '/evento-nao-enviado');
				header('Location: ' . get_option('home') . '/?p=49');
			}

		}
	}

?>