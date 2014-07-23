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
					
					<h2 class="dotted-title">Carta de vinhos</h2>

					<div class="scroll-pane">

						<div style="clear: both;"></div>

						<?php
							global $ancestor1;
							$childcats1 = get_categories('orderby=order&child_of=' . get_cat_id('Enoteca') . '&show_count=1');
							foreach($childcats1 as $childcat1){
								if(cat_is_ancestor_of($ancestor1, $childcat1->cat_ID) == false && $childcat1->category_parent == get_cat_id('Enoteca')){
									echo '<h3 class="wine-country">' . $childcat1->name .'</h3>';

									query_posts('orderby=order&showposts=9999&category_name=' . $childcat1->slug);
									if(have_posts()): while (have_posts()) : the_post();
										$categorias = wp_get_post_categories($post->ID);

										for($i = 0; $i < count($categorias); $i++){
											if($categorias[$i] == get_cat_id('Enoteca')){
												unset($categorias[$i]);
											}
										}

										if(count($categorias) == 1){
											if($categorias[0] == $childcat1->cat_ID){
												echo '
													<div class="wine-item">
														<h4 class="wine-name">' . the_title('','',false) . '</h4>
														<p class="wine-year">' . get_field('ano') . '</p>
														<p class="wine-year">' . get_field('ml') . '</p>
														<p class="wine-description">' . strip_tags(get_the_content()) . '</p>
													</div>
												';
											}
										}
									endwhile; endif;

									global $ancestor2;
									$childcats2 = get_categories('orderby=order&child_of=' . $childcat1->cat_ID . '&show_count=1');
									foreach($childcats2 as $childcat2){
										if(cat_is_ancestor_of($ancestor2, $childcat2->cat_ID) == false && $childcat2->category_parent == $childcat1->cat_ID){
											echo '<h4 class="wine-country">' . $childcat2->name .'</h4>';

											global $ancestor3;
											$childcats3 = get_categories('orderby=order&child_of=' . $childcat2->cat_ID . '&show_count=1');
											if(count($childcats3) > 0){
												foreach($childcats3 as $childcat3){
													if(cat_is_ancestor_of($ancestor2, $childcat3->cat_ID) == false && $childcat3->category_parent == $childcat2->cat_ID){
														echo '<h5 class="wine-country">' . $childcat3->name .'</h5>';
														GetPostsCategory($childcat3->slug,'1');

														$ancestor3 = $childcat3->cat_ID;
													}
												}
											}else{
												GetPostsCategory($childcat2->slug,'1');
											}

											$ancestor2 = $childcat2->cat_ID;
										}
									}

									$ancestor1 = $childcat->cat_ID;
								}
							}
						?>
						
						<div class="labels">
							<p>*3005 <strong>Taxa de Rolha R$ 40,00</strong></p>
							<p><strong>** Legenda Pontuações</strong></p>
							<ul class="list-of-wines">
								<li><strong>WS ‒ Wine Spectator</strong></li>
								<li><strong>RP ‒ Robert Parker</strong></li>
								<li><strong>GR ‒ Guia Gamero Rosso (1 a 3 ᴪ)</strong></li>
								<li><strong>W&amp;S ‒ Wine &amp; Spirits</strong></li>
								<li><strong>DEC ‒ Decanter (1 a 5 *)</strong></li>
								<li><strong>WE ‒ Wine Enthusiast</strong></li>
								<li><strong>JR ‒ Jancis Robinson (0 a 20)</strong></li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>