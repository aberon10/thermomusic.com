<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body>
	    <div class="ed-container  no-padding  main-container">
            <div class="ed-item   full  no-padding">
                <!-- header -->
                <?php require VIEWS_PATH.'layouts/header.php'; ?>

                <!-- cover image -->
			    <div class="cover-image  cover-image__big">
			        <!--<img src="/images/cover-images/bg.jpg" alt="Portadas de albums">-->
			        <div class="cover-image__message">
			            <h1>Acaba con los silencios incomodos <span>Accede sin limites. Donde y cuando quieras</span>
			            </h1>              
			            <a href="/home/offers" class="button  button-big  button-cyan">Iniciar 60 días de prueba</a>
			            <p>Sin compromiso. Sí, puedes cancelar tu suscripción cuando quieras.</p>
			        </div>
			    </div>
				
                <!-- main -->
                <main class="main">
                    <section class="feactures-app  boxed">
                        <div class="feactures-app__header">
                            <h3>¿Qué encuentro en ThermoMusic?</h3>
                        </div>
                        <div class="feactures-app__body">
	                        <div class="ed-container  full">	                            
		                        <div class="ed-item  web-50 feactures">
		                           <div class="feacture">
		                                <h4 class="feacture-title">Música</h4>
		                                <p class="feacture-description">
		                                	Encuentra la música para cada momento. ThermoMusic es un servicio de música digital que te da acceso a un gran catálogo de canciones y diversos géneros musicales.
		                                	Escucha toda la música que quieras de ayer y hoy. Sin anuncios, sin cortes.
		                                </p>
		                            </div>
		                            <div class="feacture">
		                                <h4 class="feacture-title">Playlist</h4>
		                                <p class="feacture-description">Manten tu música favorita organizada, a través de las thermoplaylist.</p>
		                            </div>
		                            <div class="feacture">
		                                <h4 class="feacture-title">Recomendaciones musicales</h4>
		                                <p class="feacture-description">Realizamos recomendaciones en base tus gustos musicales.</p>
		                            </div>
		                            <div class="feacture">
		                                <h4 class="feacture-title">Top 10</h4>
		                                <p class="feacture-description">Ranking de las 10 canciones más escuchadas.</p>
		                            </div>
		                        </div>
    	                        <div class="ed-item  web-50  no-padding  feactures-image">
    	                           	<img src="../images/cover-images/artists.jpg" alt="">
    	                        </div>                       	
                            </div>
                        </div>
                    </section>

                    <!-- image advertising-->
				    <div class="cover-image  cover-image__big  advertising" id="home-advertising">
                        <div class="cover-image__message  advertising-message">
                            <h1>LLeva tu música a todas partes</h1>
                            <p>Accede desde cualquier dispositivo. Disfruta del acceso instantáneo a tu música favorita directamente desde tu PC, tablet o Smartphone.</p>
                        </div>		
				    </div>

                    <!-- our artists -->
                    <section class="main-artists">
                        <div class="boxed">
                            <div class="main-artists__header">
                                <h3>Conocé a nuestros artistas exclusivos</h3>
                            </div>
                            <div class="main-artists__body">
                            	<div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="../images/artists/Nicky-Jam.jpg" alt="Nicky Jam">
                                    </div>
                                	<div class="main-artist__description">
                                        <h5>Nicky Jam</h5>
                                        <p>Nick Rivera Caminero, más conocido como Nicky Jam, es un cantante y compositor de reguetón estadounidense.</p>
                                    </div>
                                </div>
                                <div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="/images/artists/Beyonce.jpg" alt="Beyonce">
                                    </div>
                                	<div class="main-artist__description">
    	                               	<h5>Beyonce</h5>
    	                                <p>Beyoncé Giselle Knowles-Carter, conocida como Beyoncé, es una cantante, bailarina, modelo, compositora, productora discográfica, actriz y empresaria estadounidense. </p>
                                	</div>
                                </div>
                                <div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="../images/artists/David-Guetta.jpg" alt="David Guetta">
                                    </div>
                                	<div class="main-artist__description">
    	                                <h5>David Guetta</h5>
    	                                 <p>Pierre David Guetta, más conocido como David Guetta, es un disc jockey de música electrónica y productor discográfico francés, especializado en sonido house y dance.</p>
                                	</div>
                                </div>
                                <div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="../images/artists/El-polaco.jpg" alt="El Polaco">
                                    </div>
                                    <div class="main-artist__description">
                                        <h5>El polaco</h5>
                                        <p>
                                           	Ezequiel Ivan Cwirkaluk, más conocido como "El Polaco" es un cantante y compositor argentino de cumbia.
                                        </p>
                                    </div>
                                </div>
                                <div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="../images/artists/Michel-Telo.jpg" alt="Michel Telo">
                                    </div>
    								<div class="main-artist__description">
    									<h5>Michel Telo</h5>
    									<p>Michel Teló, es un cantante y compositor brasileño.</p>
    								</div>
                                </div>
                                <div class="main-artist">
                                    <div class="main-artist__image">
                                        <img src="../images/artists/daddy-yankee.jpg" alt="Daddy Yankee">
                                    </div>
                                    <div class="main-artist__description">
                                        <h5>Daddy Yankee</h5>
                                        <p>
                                    	    Daddy Yankee, cantante, actor, productor cinematográfico, locutor de radio, y empresario puertorriqueño.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

              	<!-- footer -->
                <?php require VIEWS_PATH.'layouts/footer.php'; ?>

                <!-- go up -->
                <?php require VIEWS_PATH.'layouts/goup.php'; ?>				
            </div>
        </div>
</body>
</html>