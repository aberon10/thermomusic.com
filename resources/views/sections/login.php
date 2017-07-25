<?php require VIEWS_PATH.'layouts/head.php'; ?>
<body id="cover-image-login">
	 <div class="ed-container  no-padding  main-wrapper">
        <div class="ed-item   full  no-padding">
            <?php require VIEWS_PATH.'layouts/header-secondary.php'; ?>			
            <div class="index-wrapper">
            	<div class="index-wrapper__left">
            		<div class="index-headings">
						<h1 class="index-heading-1">Ponlé música a tu vida.</h1>
						<h2 class="index-heading-2">Disfruta de tu música donde quieras y cuando quieras.
						Regístrate gratis.</h2>
					</div>
            	</div>
				<div class="index-wrapper__right">
	            	<div class="panel  panel-small">
	            		<div class="panel-header">
	            			<h2 class="panel-header__title">Iniciar sesión</h2>
	            		</div>
	            		<div class="panel-body">
	            			<div class="input-group">
	            				<a href="#" class="radius  social-button-login  button  bg-facebook" id="btn-login-facebook">
	            				<i class="icon-facebook"></i><span>Facebook</span></a>
	            				<a href="#" class="radius  social-button-login  button  bg-google" id="btn-login-google"> 
	            				<i class="icon-google"></i><span>Google+</span></a>
	            			</div>
	            			<?php require VIEWS_PATH.'layouts/form-login.php'; ?>
	            		</div>
	            	</div>						
				</div>
            </div>
        </div>
    </div>
    <?php require VIEWS_PATH.'layouts/footer-secondary.php'; ?>
</body>
</html>