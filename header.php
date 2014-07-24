<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
	<title>
		<?php if (is_home()){
			bloginfo('name');
		}elseif (is_category()){
			single_cat_title(); echo ' - ' ; bloginfo('name');
		}elseif (is_single()){
			single_post_title(); echo ' - ' ; bloginfo('name');
		}elseif (is_page()){
			single_post_title(); echo ' - ' ; bloginfo('name');
		}else {
			wp_title('',true);
		} ?>
	</title>

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/main.css">

	<?php if(is_home() || is_404()){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/index.css">
	<?php } ?>

	<?php if(is_page('eventos')){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/eventos.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/flexslider.css">
	<?php } ?>

	<?php if(is_page('reservas')){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/reservas.css">
	<?php } ?>

	<?php if(is_page('sobre') || is_page('evento-enviado') || is_page('evento-nao-enviado') || is_page('reserva-enviada') || is_page('reserva-nao-enviada')){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/sobre.css">
	<?php } ?>

	<?php if(is_page('Cardápio')){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/cardapio.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/bootstrap.css">
	<?php } ?>

	<?php if(is_page('Vinho')){ ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/scrollpane.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/enoteca.css">
	<?php } ?>


	



	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/vendors/jquery-1.11.0.min.js"></script>

	<?php if(is_home() || is_404()){ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/plugins/jquery.cycle2.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/index.js"></script>
	<?php } ?>


	<?php if(is_page('eventos') || is_page('reservas')){ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/plugins/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/plugins/jquery.maskedinput.min.js"></script>
	<?php } ?>


	<?php if(is_page('eventos')){ ?>
		<script type="text/javascript" src="http://flex.madebymufffin.com/examples/jquery.flexslider.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/eventos.js"></script>
	<?php } ?>


	<?php if(is_page('reservas')){ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/reservas.js"></script>
	<?php } ?>


	<?php if(is_page('Cardápio')){ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/vendors/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/cardapio.js"></script>
	<?php } ?>


	<?php if(is_page('Vinho')){ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/plugins/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/plugins/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/javascripts/enoteca.js"></script>
	<?php } ?>


<?php wp_head(); ?>
</head>
<body>
	<header role="banner" id="topo">
		<div class="wrapper">
			<h1>
				<a href="<?php echo get_option('home'); ?>" class="logo ir"><?php echo get_bloginfo('name'); ?></a>
			</h1>
			<nav id="menu" role="navigation">
				<div class="menu-item">
					<a class="menu-link<?php if(is_home()){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>">Inicial</a>
				</div>
				<div class="menu-item">
					<a class="menu-link<?php if(is_page('sobre')){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>/sobre">Sobre</a>
				</div>
				<div class="menu-item">
					<a class="menu-link<?php if(is_page('cardapio')){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>/cardapio">Cardápio</a>
				</div>
				<div class="menu-item">
					<a class="menu-link<?php if(is_page('enoteca')){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>/enoteca">Enoteca</a>
				</div>
				<div class="menu-item">
					<a class="menu-link<?php if(is_page('eventos')){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>/eventos">Eventos</a>
				</div>
				<div class="menu-item last">
					<a class="menu-link<?php if(is_page('reservas')){echo ' active';} ?>" 
					href="<?php echo get_option('home'); ?>/reservas">Reservas</a>
				</div>
			</nav>
		</div>
	</header>