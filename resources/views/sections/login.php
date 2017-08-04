<?php 
require VIEWS_PATH.'layouts/head.php';
\App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());
?>
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
	            		<?php if (!\App\Libs\Session::has('username')): ?>
	            			<h2 class="panel-header__title">Iniciar sesión</h2>
	            		<?php else: ?>
	            			<h2 class="panel-header__title">Cuenta actual</h2>
	            		<?php endif; ?>
	            		</div>
	            		<div class="panel-body">
	            		<?php if (\App\Libs\Session::has('username')): ?>
							<div class="user-account">
								<div class="user-account__left">
									<img src='<?php echo getenv('APP_URL').\App\Libs\Session::get('src_img'); ?>'>
								</div>
								<div class="user-account__right">
									<div class="user-account__name">
										<p><?php echo \App\Libs\Session::get('username'); ?></p>
									</div>
									<div class="user-account__buttons">
										<form action="/user/index" method="POST">
											<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
											<button type="submit" class="button  button-cyan"><i class="icon-user"></i></button>
										</form>
										<form action="/user/logout" method="POST">
											<?php \App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create()); ?>
											<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
											<button type="submit" class="button  button-gray"><i class="icon-sign-out"></i></button>
										</form>
									</div>
								</div>
							</div>
						<?php else: ?>
	            			<div class="input-group">
	            				<a href="#" class="radius  social-button-login  button  bg-facebook" id="btn-login-facebook">
	            				<i class="icon-facebook"></i><span>Facebook</span></a>
	            				<a href="#" class="radius  social-button-login  button  bg-google" id="btn-login-google"> 
	            				<i class="icon-google"></i><span>Google+</span></a>
	            			</div>
	            		<?php endif; ?>
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