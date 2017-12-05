<form action="/user/login" method="POST" name="form-login" id="form-login">
	<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
	<div class="input-group">
		<div class="alert alert-error <?php echo (\App\Libs\FlashValue::get('error_login')) ? '' : 'no-block'; ?>">
			<p>
				<?php
	    			echo \App\Libs\FlashValue::get('error_login');
	    			\App\Libs\FlashValue::delete('error_login');
	    		?>
	    	</p>
		</div>
	</div>
	<?php
		if (isset($_GET['token'])) {
			echo "<input type='hidden' name='_token' value='".htmlspecialchars($_GET['token'])."'>";
		}
		if (!\App\Libs\Session::has('username')):
	?>
	<div class="input-group">
	    <input type="text" class="form-control" name="username" id="username" placeholder="Usuario"
	    value="<?php echo (\App\Libs\FlashValue::get('value_username')) ?? '';
	    				\App\Libs\FlashValue::delete('value_username');
	    		?>">
	   	<div class="error-message">
	    	<?php
	    		echo \App\Libs\FlashValue::get('error_username');
	    		\App\Libs\FlashValue::delete('error_username');
	    	?>
	    </div>
	</div>
	<div class="input-group">
	    <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
	    <div class="error-message">
	    	<?php
	    		echo \App\Libs\FlashValue::get('error_password');
	    		\App\Libs\FlashValue::delete('error_password');
	    	?>
	    </div>
	</div>
	<div class="">
	    <button type="submit" class="block  button  button-big  button-cyan  radius">Entrar</button>
	</div>
	<?php endif; ?>
	<div class="">
		<p class="link"><a href="/user/forgotpassword">¿Has olvidado tu contraseña?</a></p>
	    <p class="link">¿Todavia no tienes una cuenta? <a href="/home/register">Crear una cuenta</a></p>
	</div>
</form>
