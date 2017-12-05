
<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body>
	    <div class="ed-container  no-padding  main-container">
            <div class="ed-item   full  no-padding">
 				<a href="/"><h1 class="center" style="padding-top: 1rem; font-size: 2.5rem; color: #107491;">ThermoMusic</h1></a>
			    <main class="main">
			    	<div class="panel">
	                    <div class="panel-header">
	                        <h2 class="panel-header__title">¿Olvidaste tu contraseña?</h2>
							<p>No te preocupes, ingresa tu nombre de usuario en el siguiente formulario y te enviaremos una nueva a tu cuenta de correo.</p>
							<p><b>ATENCIÓN:</b> Este proceso no es valido para cuentas que inician sesión con redes sociales.</p>
	                    </div>
	                    <div class="panel-body">
	                        <form action="#" method="POST" id="form-forgotpassword" name="form-forgotpassword">
		                        <div class="input-group">
		                        	<label for="username" class="form-label">Usuario</label>
		                        	<input type="text" class="form-control" name="username" id="username" required>
									<p class="error-message"></p>
		                        </div>
								<div class="input-group">
									<div class="loading-circle"></div>
								</div>
		                        <div class="input-group">
									<p id="message"></p>
		                        	<button type="submit" class="button  button-big  button-cyan" name="suport-button" id="suport-button">Enviar</button>
		                        </div>
		                    </form>
	                    </div>
			    	</div>
			    </main>
            </div>
        </div>
		<script src="/js/forgotpassword.js"></script>
</body>
