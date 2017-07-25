<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body>
	    <div class="ed-container  no-padding  main-container">
            <div class="ed-item   full  no-padding">
                <!-- header -->
                <?php require VIEWS_PATH.'layouts/header.php'; ?>
 				<!-- cover image -->
			    <div class="cover-image  cover-image__small" id="cover-image-offers">
			        <div class="cover-image__message">
			            <h1 class="">Tú música favorita, sin limitaciones</span>
                        </h1>			            
			        </div>
			    </div>
			    <main class="main">
			    	<div class="boxed  offers-container">
			    		<div class="ed-container  full">
			    			<!-- package free -->
                            <div class="ed-item  movil-100  tablet-50" id="table-free">
                                <div class="pricing-table  pricing-table__free">
                                	<div class="pricing-table__header">
                                    	<h1 class="pricing-title">Free</h1>
                                    	<div class="table-price">$USD 0.00 <sup>/mes</sup></div>
                                    </div>
                                    <div class="pricing-table__body">
	                                    <!-- package features -->
	                                    <ul class="pricing-list">
	                                        <li class="pricing-list__item">Anuncios publicitarios</li>
	                                        <li class="pricing-list__item"><span>10</span> Playlist</li>
	                                        <li class="pricing-list__item"><span>10 canciones </span> Favoritas </li>
	                                        <li class="pricing-list__item">Recomendaciones</li>
	                                        <li class="pricing-list__item  line-through">Ultimos éxitos musicales</li>
	                                        <li class="pricing-list__item  line-through">Soporte técnico</li>
	                                        <li class="pricing-list__item  line-through">Saltar canciones</li>
	                                    </ul>
	                                </div>
                                    <div class="pricing-table__footer">	                                
	                                    <div class="table-buy">
	                                        <span>$USD 0.00 <sup>/mes</sup></span>
	                                        <a href="#" class="pricing-table__button button-gray" id="contract-free">Registrarse</a>
	                                    </div>
	                                </div>
                                </div>
                            </div>

                            <!-- FORM SUBSCRIPTION PREMIUM -->
                            <div class="ed-item  movil-100  tablet-50" style="display: none;">
								<div class="form">
									<form name="form-subscription" id="form-subscription" action="#" method="POST">
										<div class="input-group">
											<label class="form-label" for="user">Usuario</label>
											<input type="text" class="form-control" id="user" name="user">
											<div class="error-message"></div>
										</div>
                                        <div class="input-group">
											<label class="form-label" for="number-card">Número de tarjeta</label>
                                            <input type="text" class="form-control" name="number_card" id="number-card">
                                            <div class="error-message"></div>
                                        </div>
                                        <div class="input-group">
                                        	<label class="form-label" for="security-code">Código de seguridad</label>
                                            <input type="password" class="form-control" name="security_code" id="security-code">
                                            <div class="error-message"></div>
                                        </div>
                                        <div class="input-group">
                                        	<label class="form-label" for="">Fecha de vencimiento </label>
                                            <div class="select-group">
                                            	<select class="select  form-control" name="expiration_month"
	                                            id="expiration-month">
	                                                <option value="">Mes</option>
	                                                <?php 
	                                                	for ($i=0; $i < 12; $i++) {
		                                                    echo '<option value="'.($i + 1).'">'.MONTHS[$i].'</option>';
		                                                } 
	                                                ?>
	                                            </select>
	                                            <select class="select  form-control  no-margin" name="expiration_year"
	                                            id="expiration-year">
	                                                <option value="">Año</option>
	                                                <?php
														$init_year = 2030;
	                                                    for ($i=$init_year; $i >= 1920; $i--) {
	                                                    	echo '<option value="'.$i.'">'.$i.'</option>';
	                                                	} 
	                                                ?>
	                                            </select>
                                            </div>
                                            <div class="error-message"></div>
                                        </div>
                                        <div class="input-group">
                                        	<button type="submit" class="button  button-big  button-cyan">Inciar prueba de 60 días</button>
                                        </div>						
									</form>
								</div>
							</div>
                            <!-- package premium -->
                            <div class="ed-item  movil-100  tablet-50" id="table-premium">
                                <div class="pricing-table  pricing-table__premium">
                                	<div class="pricing-table__header">
	                                    <h1 class="pricing-title">Premium</h1>
	                                    <div class="table-price">$USD 5.99 <sup>/mes</sup></div>          
                                	</div>
                                	<div class="pricing-table__body">
	                                    <!-- caracteristicas del paquete -->
	                                    <ul class="pricing-list">
	                                        <li class="pricing-list__item">Sin anuncios</li>
	                                        <li class="pricing-list__item">Playlist <span class="unlimited">ilimitadas</span></li>
	                                        <li class="pricing-list__item">Favoritas <span class="unlimited">ilimitadas</span></li>
	                                        <li class="pricing-list__item">Recomendaciones</li>
	                                        <li class="pricing-list__item">Ultimos éxitos musicales</li>
	                                        <li class="pricing-list__item">Soporte técnico</li>
	                                        <li class="pricing-list__item">Saltate las canciones que quieras</li>
	                                    </ul>                                		
                                	</div>
                                    <div class="pricing-table__footer">
	                                    <div class="table-buy">
	                                        <span>$USD 5.99 <sup>/mes</sup></span>
	                                        <a href="#" class="pricing-table__button  button-cyan" id="contract">Contratar</a>
	                                    </div>
                                    </div>
                                </div>
                            </div>
			    		</div>
			    	</div>
			    </main>
                <!-- footer -->
                <?php require VIEWS_PATH.'layouts/footer.php'; ?>
                <!-- go up -->
                <?php require VIEWS_PATH.'layouts/goup.php'; ?>
        	</div>
        </div>
</body>