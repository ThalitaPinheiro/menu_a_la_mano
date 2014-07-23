<?php get_header(); ?>

	<section role="main" id="conteudo">
		<div class="wrapper">
			<h1 class="content-title"><?php single_cat_title(''); ?></h1>
			<div class="outside overlay-box">
				<div class="inside overlay-box">
					
					<?php
						$descricaoCategoria = strip_tags(category_description($cat));
						if($descricaoCategoria != ''){
							echo '<p>' . $descricaoCategoria . '</p>';
						}
					?>
					
					<div class="tabbable boxed parentTabs">
						<ul class="nav nav-tabs">
							<?php
								ListSubCategories(get_cat_id('Cardápio'),2);
							?>
						</ul>
						<div class="tab-content">

							<div class="tab-pane fade active in" id="set-a-la-carte">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<?php
											ListSubCategories(get_cat_id('À La Carte'),2);
										?>
									</ul>

									<div class="tab-content">
										<?php
											$subAlaCarte = ListSubCategories(get_cat_id('À La Carte'),1);
											for($i = 0; $i < count($subAlaCarte); $i++){
												if($i == 0){
													$class = ' active in';
												}else{
													$class = '';
												}
												echo '<div class="tab-pane fade' . $class . '" id="set-' . $subAlaCarte[$i] . '">';
													$idObj = get_category_by_slug($subAlaCarte[$i]);
													GetPostsCategory($idObj->slug,'2');
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="set-executivo">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<?php
											ListSubCategories(get_cat_id('Executivo'),2);
										?>
									</ul>
									<div class="tab-content">
										<?php
											$subExecutivo = ListSubCategories(get_cat_id('Executivo'),1);
											for($i = 0; $i < count($subExecutivo); $i++){
												if($i == 0){
													$class = ' active in';
												}else{
													$class = '';
												}
												echo '<div class="tab-pane fade' . $class . '" id="set-' . $subExecutivo[$i] . '">';
													$idObj = get_category_by_slug($subExecutivo[$i]);
													GetPostsCategory($idObj->slug,'2');
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="set-executivo-especial">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<?php
											ListSubCategories(get_cat_id('Executivo Especial'),2);
										?>
									</ul>
									<div class="tab-content">
										<?php
											$subExecutivoEspecial = ListSubCategories(get_cat_id('Executivo Especial'),1);
											for($i = 0; $i < count($subExecutivoEspecial); $i++){
												if($i == 0){
													$class = ' active in';
												}else{
													$class = '';
												}
												echo '<div class="tab-pane fade' . $class . '" id="set-' . $subExecutivoEspecial[$i] . '">';
													$idObj = get_category_by_slug($subExecutivoEspecial[$i]);
													GetPostsCategory($idObj->slug,'2');
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="set-sugestao-do-chef">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<?php
											ListSubCategories(get_cat_id('Sugestão do Chef'),2);
										?>
									</ul>
									<div class="tab-content">
										<?php
											$subSugestao = ListSubCategories(get_cat_id('Sugestão do Chef'),1);
											for($i = 0; $i < count($subSugestao); $i++){
												if($i == 0){
													$class = ' active in';
												}else{
													$class = '';
												}
												echo '<div class="tab-pane fade' . $class . '" id="set-' . $subSugestao[$i] . '">';
													$idObj = get_category_by_slug($subSugestao[$i]);
													GetPostsCategory($idObj->slug,'2');
												echo '</div>';
											}
										?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>