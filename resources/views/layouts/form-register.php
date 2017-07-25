<form action="#" method="POST" name="form-register" id="form-register">
	<div class="input-group">
	    <input type="text" class="form-control" name="username" id="username" placeholder="Usuario">
	    <div class="error-message"></div>
	</div>
	<div class="input-group">
		<input type="text" class="form-control" name="email" id="email" placeholder="Correo electrónico">
		<div class="error-message"></div>
	</div>            					
	<div class="input-group">
	    <label class="form-label" for="">Fecha de  nacimiento</label>
	    <div class="select-group">
	        <select class="select  form-control  no-margin" name="day"
		    id="day">
		    	<option value="">Día</option>
		        <?php
		            for ($i = 1; $i <= 31; $i++) {
		                echo '<option value="'.$i.'">'.$i.'</option>';
		            } 
		        ?>
		    </select>
	        <select class="select  form-control" name="month"
		    id="month">
		        <option value="">Mes</option>
		        <?php 
		            for ($i = 0; $i < 12; $i++) {
			            echo '<option value="'.($i + 1).'">'.MONTHS[$i].'</option>';
			        } 
		        ?>
		    </select>	                                    
		    <select class="select  form-control  no-margin" name="year"
		    id="year">
			    <option value="">Año</option>
			    <?php
			        for ($i = date('Y'); $i >= 1920; $i--) {
			        	echo '<option value="'.$i.'">'.$i.'</option>';
			        } 
			    ?>
		    </select>
	    </div>
	    <div class="error-message"></div>
	</div>                      
	<div class="input-group">
	     <div class="select-group">
	        <select name="sex" class="form-control" id="sex">
	            <option value="">Selecciona tu sexo</option>
	            <option value="F">Femenino</option>
	            <option value="M">Masculino</option>
	        </select>                                	
	    </div>
	    <div class="error-message"></div>
	</div>          
	<div class="input-group">
	    <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña, utilizá mínimo 8 caracteres">
	    <div class="error-message"></div>
	</div>
	<div class="input-group">
		<input type="password" class="form-control" name="repeat-password" id="repeat-password" placeholder="Confirmar contraseña">
		<div class="error-message"></div>
	</div>
	<div class="">
	    <button type="submit" class="center  block  button  button-big  button-cyan  radius" >Crear cuenta</button>
	    <p class="link">¿Ya tienes una cuenta? <a href="/home/login">Inciar sesión</a></p>
	</div>
</form>