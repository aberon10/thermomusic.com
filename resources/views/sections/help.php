<?php require VIEWS_PATH . 'layouts/head.php';?>
<body>
	    <div class="ed-container  no-padding  main-container">
            <div class="ed-item   full  no-padding">
                <!-- header -->
                <?php require VIEWS_PATH . 'layouts/header.php';?>
 				<!-- cover image -->
			    <div class="cover-image  cover-image__small" id="cover-image-help">
			        <div class="cover-image__message">
			            <h1 class="">¿En que podemos Ayudarte?</span>
                        </h1>
			        </div>
			    </div>
			    <main class="main">
					<div class="ed-container">
					    <!-- SIDEBAR MENÚ -->
						<div class="ed-item web-25 hd-20">
							<aside class="aside">
								<div class="sidebar">
									<div class="sidebar__header">
										<h2>Temas de ayuda</h2>
									</div>
									<div class="sidebar__menu">
										<ul>
											<li>
												<p><i class="icon-arrow-right"></i>Primeros pasos</p>
												<ul class="sidebar__submenu show">
													<li><a href="#create-an-account">Crear una cuenta</a></li>
													<li><a href="#premium-account">Cuenta premium</a></li>
													<li><a href="#forgot-password">He olvidado mi constraseña</a></li>
												</ul>
											</li>
											<li>
												<p><i class="icon-arrow-right"></i>Música</p>
												<ul class="sidebar__submenu  show">
													<li><a href="#create-an-playlist">Playlist</a></li>
													<li><a href="#favorits">Favoritas</a></li>
													<li><a href="#search">Buscador</a></li>
													<li><a href="#reproduction-queue">Cola de reproducción</a></li>
												</ul>
											</li>
											<li>
												<p><i class="icon-arrow-right"></i>Cuenta</p>
												<ul class="sidebar__submenu  show">
													<li><a href="#preferences">Modificar Cuenta</a></li>
													<li><a href="#cancel-suscription">Cancelar suscripción</a></li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
							</aside>
						</div>
						<div class="ed-item web-75 hd-80">
							 <section class="container-article">
                                <!-- ARTICULO 1 -->
                                <article class="article" id="create-an-account">
                                    <div class="article__title">
                                        <h2>Crear una cuenta</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                            <p>En primer lugar, debes completar el formulario de registro que aparece al pulsar en el bóton<span class="button-small"><b> REGISTRARSE </b></span>.</p>
                                            <p>Luego se enviara un correo a tu casilla personal, el cual te dara la bienvenida y te pedira que accedas al enlace para confirmar la cuenta. Una vez que pulsas en el enlace debes acceder al formulario de inicio de de sesión donde deberas ingresar tu <i><b>usuario</b></i>, <i><b>contraseña</b></i>.</p>
                                            <p>Luego de esto ya estas listo para disfrutar de ThermoMusic!</p>
                                        </div>
                                    </div>
                                </article>
								<!-- ARTICULO 2 -->
                                <article class="article" id="premium-account">
                                    <div class="article__title">
                                        <h2>Cuenta Premium</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                            <p>Antes de poder obtener una cuenta premium debes contar con una cuenta de thermomusic o una cuenta de las redes sociales Google+ o Facebook.</p>
                                            <p>Una vez que tieneas a tu disposición una cuenta ya puedes obtener tu subscripción premium. Para esto, tienes que completar el formulario de la sección
                                            <a href="/home/offers">Ofertas</a> con los datos solicitados. Listo! asi de sencillo es ser Premium. Recuerda que puedes probar la aplicación durante 60 dias y cancelar la subscripción en cualquier momento.</p>
                                            <p>No esperes más, <a href="/home/offers">suscribite ahora</a> para disfutar de los últimos éxitos y poder cantar tu música favorita sin anuncios que te corten la inspiración.</p>
                                        </div>
                                    </div>
                                </article>
								<!-- ARTICULO 3 -->
                                <article class="article" id="forgot-password">
                                    <div class="article__title">
                                        <h2>¿Has olvidado tu contraseña?</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                           <p>No te preocupes, solo tienes que ingresar tu nombre de usuario en el
                                           <a href="/user/forgotpassword">siguiente formulario</a> y de forma instantanea podras
                                           recuperar tu contraseña.</p>
                                        </div>
                                    </div>
                                </article>
								<!-- ARTICULO 4 -->
                                <article class="article" id="create-an-playlist">
                                    <div class="article__title">
                                        <h2><span class="icon-note" style="color: #444;"></span> Playlist</h2>
                                    </div>
                                    <div class="article__content columns">
                                        <div class="article__content-text">
                                            <p>Las playlists son colecciones de pistas que puedes crear para organizar tu música favorita y poder escuchar cuando tienes distintos estados de ánimo, eventos, etc. Puedes crear tantas playlists como quieras, el único límite es tu propia imaginación.</p>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">CREAR UNA PLAYLIST</h5>
                                            <ol>
                                               <li>Haz clic en el bóton NUEVA PLAYLIST del menú.</li>
                                               <li>Dale un nombre a la playlist y presiona la tecla Enter.</li>
                                            </ol>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">CAMBIAR EL NOMBRE DE UNA PLAYLIST</h5>
                                            <ol>
                                               <li>Haz clic sobre el nombre de la Playlist.</li>
                                               <li>Modifica el nombre.</li>
                                               <li>Presiona la tecla Enter.</li>
                                            </ol>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">ELIMINAR UNA PLAYLIST</h5>
                                            <ol>
                                                <li>Haz clic en el icono <span class="icon-ellipsis-h"></span> de la playlist</li>
                                                <li>Confirma la eliminación.</li>
                                            </ol>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">AGREGAR UNA CANCIÓN</h5>
                                            <ol>
                                                <li>Haz clic en el icono <span class="icon-ellipsis-h"></span> junto a la canción</li>
                                                <li>Selecciona la playlist a la cual deseas agregar la canción (Tambień puedes crear una playlist desde aquí).</li>
                                                <li>Haz clic en el bóton ACEPTAR.</li>
                                            </ol>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">ELIMINAR UNA CANCIÓN</h5>
                                            <ol>
                                                <li>Una vez dentro de la playlist, Haz clic en el icono <span class="icon-ellipsis-h"></span> junto a la canción que deseas eliminar.</li>
                                                <li>Selecciona la opción, <i>"Quitar de la playlist"</i></li>
                                            </ol>
                                        </div>
                                        <div class="cover-artist-container">
											<div class="cover-artist">
                                            	<img src="../images/help/create-playlist.png" style="max-height: 400px; display: block; margin: .5em auto;" alt="crear una playlist">
											</div>
											<div class="cover-artist">
                                            	<img src="../images/help/add-to-playlist.png" style="max-height: 400px; display: block; margin: .5em auto;" alt="agregar una canción">
											</div>
											<div class="cover-artist">
                                            	<img src="../images/help/playlist.png" style="max-height: 400px; display: block; margin: .5em auto;" alt="playlist">
											</div>
											<div class="cover-artist">
                                            	<img src="../images/help/delete-playlist.png" style="max-height: 400px; display: block; margin: .5em auto;" alt="eliminar una playlist">
											</div>
											<div class="cover-artist">
                                            	<img src="../images/help/update-playlist.png" style="max-height: 400px; display: block; margin: .5em auto;" alt="actualizar una playlist">
											</div>
                                        </div>
                                    </div>
                                </article>
                                <!-- ARTICULO 5 -->
                                <article class="article" id="favorits">
                                    <div class="article__title">
                                        <h2><span class="icon-heart  color-red"></span> Favoritas</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                            <p>Las pistas favoritas son aquellas que escuchas con mayor frecuencia, tienen un significado especial para ti o simplemente te gustan.</p>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">AGREGAR UNA PISTA COMO FAVORITA</h5>
											<img src="../images/help/add-favortie.png" alt="Agregar a una canción a favoritos">
                                            <ol>
                                               <li>Haz clic el icono del corazón <span class="icon-heart  color-red"></span> que se encunentra junto a la pista.</li>
                                            </ol>
                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">QUITAR UNA PISTA COMO FAVORITA</h5>
                                            <ol>
                                               <li>Para quitar una pista de tus favoritos, solo debes repetir el paso anterior desde la sección <i>Tu Música</i>.</li>
                                            </ol>
                                    </div>
                                </article>
								<!-- ARTICULO 6 -->
                                <article class="article" id="search">
                                    <div class="article__title">
                                        <h2><span class="icon-search" style="color: #444;"></span> Buscador</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                            <p>El buscador te permite encontrar de forma rapida, canciones, artistas y albumes.</p>

                                            <h5 style="color: #444; font-weight: bold; padding: 2em 0;">COMO BUSCAR</h5>
											<img src="../images/help/search.png" alt="Bsucador">
                                            <ol>
                                               <li>Escribe la canción, el artista o el álbum, que estás buscando en el recuadro de búsqueda.</li>
                                               <li>Selecciona un resultado de la lista desplegable.</li>
                                               <li>¿No encuentras lo que estás buscando en la lista? no te preocupes, Pulsa Enter. para obtener más resultados</li>
                                               <li>Se abrirán más resultados de la búsqueda. Desplázate hacia abajo para encontrar lo que estás buscando y luego haz clic en el resultado que quieres comenzar a escuchar.</li>
                                            </ol>
                                    </div>
                                </article>
								<!-- ARTICULO 7 -->
                                <article class="article" id="reproduction-queue">
                                    <div class="article__title">
                                        <h2><span class="icon-list" style="color: #444;"></span> Cola de reproducción</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
                                            <p>Como su nombre lo indica, la cola de reproducción te permite crear una lista con las canciones que quieres escuchar. Es una especie de playlist temporal.</p>

											<p>Si estás escuchando un álbum, ThermoMusic automáticamente agrega todas las pistas del álbum a la cola de reproducción. Pero si quieres agregar canciones:</p>
                                            <ol>
                                               <li>Busca una canción.</li>
                                               <li>Haz clic en el icono <span class="icon-ellipsis-h"></span> y elige la opción "Añadir a la lista de espera".</li>
                                            </ol>
											<p style="margin-top: 1rem">Nota: Las canciones de un álbum se eliminan si cambias a un álbum diferente.</p>
											<img src="../images/help/waiting-list.png" alt="Lista de espera">
                                    </div>
                                </article>
								<!-- ARTICULO 8 -->
                                <article class="article" id="preferences">
                                    <div class="article__title">
                                        <h2><span class="icon-user" style="color: #444;"></span>Preferencias</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
											<p><b>NOTA: </b>Es necesario que la cuenta sea exclusiva de ThermoMusic</p>
                                            <p>En esta sección podras editar los siguientes datos personales: Nombre, Apellido, Correo, Fecha de nacimiento y sexo.</p>
											<h5 style="color: #444; font-weight: bold; padding: 1em 0;">CAMBIAR CONTRASEÑA</h5>
											<p style="margin-top: 1rem">Además podras cambiar tu contraseña en la pestaña <i>Cambiar Contraseña</i>. Para ello debes hacer lo siguiente: </p>
											<ol>
                                               <li>Ingresa tu actual contraseña</li>
                                               <li>Ingresa la nueva contraseña</li>
                                               <li>Confirma la nueva contraseña</li>
                                               <li>Haz clic en bóton ACEPTAR</li>
                                            </ol>
                                    </div>
                                </article>
								<!-- ARTICULO 9 -->
								<article class="article" id="cancel-suscription">
                                    <div class="article__title">
                                        <h2>Cancelar suscripción</h2>
                                    </div>
                                    <div class="article__content">
                                        <div class="article__content-text">
											<p>Ingresar constraseña y luego hacer click en el bóton CANCELAR SUSCRIPCIÓN.</p>
											<img src="../images/help/cancel-suscription.png" alt="Cancelar suscripción">
										</div>
                                    </div>
                                </article>
							</section>
						</div>
					</div>
			    </main>
                <!-- footer -->
                <?php require VIEWS_PATH . 'layouts/footer.php';?>
                <!-- go up -->
                <?php require VIEWS_PATH . 'layouts/goup.php';?>
        	</div>
        </div>
</body>
