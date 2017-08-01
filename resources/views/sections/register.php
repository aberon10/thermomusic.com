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
	            			<h2 class="panel-header__title">Crear una cuenta</h2>
	            		</div>
	            		<div class="panel-body">
	            			<?php require VIEWS_PATH.'layouts/form-register.php'; ?>
	            		</div>
	            	</div>						
				</div>
           	</div>
        </div>
    </div>
    <?php require VIEWS_PATH.'layouts/footer-secondary.php'; ?>
    <script src="/js/Libs/Ajax.js"></script>
    <script src="/js/Libs/Utilities.js"></script>
    <script src="/js/Libs/Validate.js"></script>
    <script src="/js/register-user.js"></script>
</body>
</html>