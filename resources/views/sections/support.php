<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body>
	    <div class="ed-container  no-padding  main-container">
            <div class="ed-item   full  no-padding">
				<!-- header -->
                <?php require VIEWS_PATH.'layouts/header.php'; ?>
                <!-- cover image -->
			    <div class="cover-image  cover-image__small" id="cover-image-support">
			        <div class="cover-image__message">
			            <h1>¿Necesitas ayuda?</h1>			            
			        </div>
			    </div>
			    <main class="main">
			    	<div class="boxed">
			    		<div class="form">			    			
	                        <form action="#" method="POST" id="form-support" name="form-support">
	                        	<div class="input-group">
	                        		<label for="support-email" class="form-label">Correo electrónico</label>
	                        		<input type="text" class="form-control" name="support-email" id="support-email">
	                        	</div>
	                        	<div class="input-group">
	                        		<label for="support-name" class="form-label">Nombre</label>
	                        		<input type="text" class="form-control" name="support-name" id="support-name">
	                        	</div>
	                        	<div class="input-group">
	                        		<label for="support-subject" class="form-label">Asunto</label>
	                        		<input type="text" class="form-control" name="support-subject" id="support-subject">
	                        	</div>
	                        	<div class="input-group">
	                        		<label for="support-message" class="form-label">¿Cuál es tu mensaje?</label>
	                        		<textarea class="form-control" name="support-message" id="support-message">
	                        		</textarea>
	                        	</div>
	                        	<div class="input-group">
	                        		<button type="submit" class="button  button-big  button-cyan" name="suport-button" id="suport-button">Enviar</button>
	                        	</div>
	                        </form>
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
</html>