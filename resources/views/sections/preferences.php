<?php
require VIEWS_PATH . 'layouts/head.php';
\App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());
?>
<body>
	<div class="ed-container  no-padding  main-container">
        <div class="ed-item   full  no-padding">
			<?php if (!\App\Libs\Session::get('social_account')): ?>
			<div class="panel">
				<div class="panel-header">
					<h2 class="panel-header__title">Preferencias</h2>
				</div>
				<div class="panel-body">
					<form class="" method="post" action="">
						<div class="input-group">
							<label for="username" class="form-label">Usuario</label>
							<input type="text" class="form-control" name="username" id="username" readonly disabled
							value="<?php echo \App\Libs\Session::get('username'); ?>">
						</div>
						<div class="input-group">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" name="name" id="name"
							value="<?php echo \App\Libs\FlashValue::get('value_name'); ?>">
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_name') != 1 ? \App\Libs\FlashValue::get('error_name') : ''; ?></div>
						</div>
						<div class="input-group">
							<label for="lastname" class="form-label">Apellido</label>
							<input type="text" class="form-control" name="lastname" id="lastname"
							value="<?php echo \App\Libs\FlashValue::get('value_lastname'); ?>">
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_lastname') != 1 ? \App\Libs\FlashValue::get('error_lastname') : ''; ?></div>
						</div>
						<div class="input-group">
							<label for="email" class="form-label">Correo</label>
							<input type="text" class="form-control" name="email" id="email"
							value="<?php echo \App\Libs\FlashValue::get('value_email'); ?>">
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_email') != 1 ? \App\Libs\FlashValue::get('error_email') : ''; ?></div>
						</div>
						<div class="input-group">
							<?php
								$birthdate = explode('-', App\Libs\FlashValue::get('value_birthdate'));
							?>
							<label class="form-label" for="">Fecha de  nacimiento</label>
							<div class="select-group" id="date-group">
								<select class="select  form-control  no-margin" name="day"
								id="day">
									<option>Día</option>
									<?php
										for ($i = 1; $i <= 31; $i++) {
											$selected = '';
											if ($birthdate[2] == $i)
												$selected = 'selected';
											echo "<option $selected value='".$i."'>$i</option>";
										}
									?>
								</select>
								<select class="select  form-control" name="month"
								id="month">
									<option>Mes</option>
									<?php
										for ($i = 0; $i < 12; $i++) {
											$selected = '';

											if (ltrim($birthdate[1] - 1, 0) == $i)
												$selected = 'selected';
											echo "<option $selected value='".($i + 1)."'>".($i + 1)."</option>";
										}
									?>
								</select>
								<select class="select  form-control  no-margin" name="year"
								id="year">
									<option>Año</option>
									<?php
										for ($i = date('Y'); $i >= 1920; $i--) {
											$selected = '';

											if ($birthdate[0] == $i)
    											$selected = 'selected';
											echo "<option $selected value='".$i."'>".$i."</option>";
										}
									?>
								</select>
							</div>
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_birthdate') != 1 ? \App\Libs\FlashValue::get('error_birthdate') : ''; ?></div>
						</div>
						<div class="input-group">
							<div class="select-group" id="sex-group">
								<?php $sex = \App\Libs\FlashValue::get('value_sex'); ?>
								<select name="sex" class="form-control" id="sex">
									<option value="">Selecciona tu sexo</option>
									<option value="F" <?php echo $sex == 'F' ? 'selected' : ''; ?>>Femenino</option>
									<option value="M" <?php echo $sex == 'M' ? 'selected' : ''; ?>>Masculino</option>
								</select>
							</div>
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_sex') != 1 ? \App\Libs\FlashValue::get('error_sex') : ''; ?></div>
						</div>
						<div class="input-group">
							<?php \App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());?>
							<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
							<?php if (!\App\Libs\FlashValue::get('error_update')): ?>
							<div class="block  text-left  color-green">Datos actualizados con exito!</div>
							<?php endif;?>
							<button type="submit" class="button  button-cyan">Guardar</button>
						</div>
					</form>
				</div>
			</div>
			<div class="panel">
				<div class="panel-header">
					<h2 class="panel-header__title">Cambiar contraseña</h2>
				</div>
				<div class="panel-body">
					<!-- Change Password -->
					<form class="" method="post" action="/user/changePassword">
						<div class="input-group">
							<label for="password" class="form-label">Contraseña actual</label>
							<input type="password" class="form-control" name="password" id="password" required>
							<div class="error-message"><?php echo !\App\Libs\FlashValue::get('error_password') ? \App\Libs\FlashValue::get('error_password') : ''; ?></div>
						</div>
						<div class="input-group">
							<label for="new-password" class="form-label">Nueva contraseña</label>
							<input type="password" class="form-control" name="new-password" id="new-password" required>
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_new_password') != 1 ? \App\Libs\FlashValue::get('error_new_password') : ''; ?></div>
						</div>
						<div class="input-group">
							<label for="repeat-password" class="form-label">Repetir contraseña</label>
							<input type="password" class="form-control" name="repeat-password" id="repeat-password" required>
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_confirm_password') !== false ? \App\Libs\FlashValue::get('error_confirm_password') : ''; ?></div>
						</div>
						<div class="input-group">
							<?php \App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());?>
							<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
							<?php if (!\App\Libs\FlashValue::get('error_change_password')): ?>
							<div class="block  text-left  color-green">Contraseña cambiada con exito!</div>
							<?php endif;?>
							<button type="submit" class="button  button-cyan">Guardar</button>
						</div>
					</form>
				</div>
			</div>
			<?php endif; ?>
			<div class="panel">
				<div class="panel-header">
					<h2 class="panel-header__title">Cuenta - Suscripción</h2>
				</div>
				<div class="panel-body">
					<?php if (\App\Libs\Session::get('account') == \Config\USER_PREMIUM): ?>
					<form class="" method="post" action="/user/cancelSuscription">
						<div class="input-group">
							<label for="pass" class="form-label">Contraseña</label>
							<input type="password" class="form-control" name="pass" id="pass" required>
							<div class="error-message"><?php echo \App\Libs\FlashValue::get('error_pass') ? \App\Libs\FlashValue::get('error_pass') : ''; ?></div>
						</div>
						<div class="input-group">
							<?php \App\Libs\Session::set('csrf', \App\Libs\CsrfToken::create());?>
							<input type="hidden" name="csrf" value="<?php echo \App\Libs\Session::get('csrf'); ?>">
							<?php if (!\App\Libs\FlashValue::get('error_cancel_suscription')): ?>
							<div class="block  text-left  color-green">Contraseña cambiada con exito!</div>
							<?php endif;?>
							<p></p>
							<button type="submit" class="button  button-red  button-big  block  center">Cancelar Suscripción</button>
						</div>
					</div>
					<?php else: ?>
					<a href="/home/offers" class="button  button-cyan  button-big  block  center">Contratar Premium</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</body>
