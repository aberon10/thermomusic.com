<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body style="background-image: linear-gradient(rgb(47, 66, 106), rgb(4, 6, 10) 85%);">
	<div class="main-content">
		<div class="ed-container  full  no-padding">
			<div class="ed-item  full  no-padding">
				<section class="content-spacing">
					<div class="content-spacing__header">
						<h1 class="content-spacing-title">Géneros</h1>						
					</div>
					<div class="content-spacing__body">
						<?php if (isset($genres) && count($genres) > 0): ?>
							<div class="cover-artist-container">
								<?php
									\App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());
									foreach ($genres as $genre):
										$url = '/artist/get_artist_by_genre?csrf='.
											urlencode(\App\Libs\Session::get('csrf')).'&id_genre='.
											urlencode($genre['id_genero']);
								?>
								<div class="cover-artist  brightness-image">
									<div class="cover-artist__header">
										<a href="<?php echo $url; ?>" target="root">
											<div class="cover-artist-image" 
											style="background-image:url(<?php echo getenv('APP_SRC_RESOURCES').
											$genre['src_img']; ?>);">
											</div>
										</a>
									</div>
									<div class="cover-artist__footer">
										<a href="<?php echo $url; ?>" class="cover-artist-name">
										<?php echo $genre['nombre_genero']; ?></a>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
						<h1>Lo sentimos, no hay Géneros disponibles.</h1>
						<?php endif; ?>			
					</div>
				</section>
			</div>
		</div>
	</div>
</body>
</html>