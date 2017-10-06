<div class="nav-bar-container" id="nav-bar-container" style="display: block;">
	<nav class="nav-bar">
		<div class="nav-bar__header">
			<div class="nav-bar__logo">
				<a href="" target="root"><h2>ThermoMusic</h2></a>
				<i class="icon-bars  no-block"></i>
			</div>
			<div class="nav-bar__session-info  group">
				<a href="#"><i class="icon-user" id="menu-bars"></i> <?php echo \App\Libs\Session::get('username'); ?></a>
			</div>
			<div class="nav-bar__search  group">
				<a href="#">Buscar</a><i class="icon-search"></i>
			</div>
		</div>
		<div class="nav-bar__body">
			<ul class="nav-list  group">
				<li class="nav-list__item">
					<a href="/explorer/index?csrf=<?php echo \App\Libs\Session::get('csrf'); ?>" class="active" target="root">Explorador</a>
				</li>
				<li class="nav-list__item">
					<a href="/artist/index?csrf=<?php echo \App\Libs\Session::get('csrf'); ?>" target="root">Artistas</a>
				</li>
				<li class="nav-list__item">
					<a href="/artist/artist?csrf=<?php echo \App\Libs\Session::get('csrf'); ?>" target="root">Artista</a>
				</li>
				<li class="nav-list__item">
					<a href="/album/index?csrf=<?php echo \App\Libs\Session::get('csrf'); ?>" target="root">Álbum</a>
				</li>
				<li class="nav-list__item">
					<a href="#">Tu Música</a>
				</li>
				<li class="nav-list__item">
					<a href="#">Recomendados</a>
				</li>
				<li class="nav-list__item">
					<a href="#">Top 10</a>
				</li>
			</ul>
			<div class="recently-played-group  group">
				<h5 class="recently-played-group__title">ÚLTIMAS REPRODUCCIONES</h5>
				<ul class="nav-list">
					<li class="nav-list__item"><a href="#">Artista #1</a></li>
					<li class="nav-list__item"><a href="#">Artista #2</a></li>
					<li class="nav-list__item"><a href="#">Artista #3</a></li>
					<li class="nav-list__item"><a href="#">Artista #4</a></li>
				</ul>			
			</div>
		</div>		
	</nav>
</div>