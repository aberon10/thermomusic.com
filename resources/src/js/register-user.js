'use strict';

(function(w, d) {
	let classError = 'has-error';
	let messageError = d.querySelector('.alert-error');
	let messageSuccess = d.querySelector('.alert-success');
	let loadingCircle = d.querySelector('.loading-circle');
	let dateGroup = d.getElementById('date-group');
	let sexGroup = d.getElementById('sex-group');
	let form = d.getElementById('form-register');
	let user = d.getElementById('username');
	let email = d.getElementById('email');
	let password = d.getElementById('password');
	let repeatPassword = d.getElementById('repeat-password');
	let day = d.getElementById('day');
	let month = d.getElementById('month');
	let year = d.getElementById('year');
	let sex = d.getElementById('sex');

	function validateUser(e) {
		let element = e ? e.target : user;
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'username': 'Utilizá entre 4 y 30 letras, números, guiones y puntos.'
		}));
	}

	function validateEmail(e) {
		let element = e ? e.target : email;
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'email': 'El correo ingresado no es valido'
		}));
	}

	function valdiatePassword(e) {
		let element = e ? e.target : password;		
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'min_length': [8, 'Utilizá como mínimo 8 caracteres'],
			'max_length': [30, 'Utilizá como máximo 30 caracteres']
		}));		
	}

	function validateRepeatPassword(e) {
		let element = e ? e.target : repeatPassword;				
		if (element.value.trim() === '') {
			return reportError(element, 'Campo obligatorio');
		} else if (element.value.trim() !== password.value.trim()) {
			return reportError(element, 'La contraseña no coincide.');
		} else {
			return reportError(element, true);
		}
	}

	function validateSex() {
		if (sex.value === '') {
			return reportError(sexGroup, 'Campo Obligatorio');
		} else {
			return reportError(sexGroup, true);
		}
	}

	function validateDate() {
		let date = day.value+'-'+month.value+'-'+year.value;
		return reportError(dateGroup, Validate.resolver(date, {
			'require': 'Campo obligatorio',
			'date': 'La fecha no es valida'
		}));
	}

	// Event Listeners - Validate
	user.addEventListener('blur', validateUser);
	email.addEventListener('blur', validateEmail);
	password.addEventListener('blur', valdiatePassword);
	repeatPassword.addEventListener('blur', validateRepeatPassword);

	// Submit Form
	form.addEventListener('submit', (e) => {
		e.preventDefault();
		messageError.classList.add('no-block');

		let isValidUser = validateUser();
		let isValidEmail = validateEmail();
		let isValidPass = valdiatePassword();
		let isValidRepeatPass = validateRepeatPassword();
		let isValidSex = validateSex();
		let isValidDate = validateDate();

		if (isValidUser && isValidEmail && isValidPass && isValidRepeatPass && isValidSex && isValidDate) {
			loadingCircle.classList.remove('no-block');
			loadingCircle.classList.add('turn');
			loadingCircle.classList.add('center');
			window.setTimeout(function() {
				Ajax
				.post({
					url: '/user/register',
					    responseType: 'json',
					    data: {
							user: user.value,
							email: email.value,
							password: password.value,
							repeatPassword: repeatPassword.value,
							date: day.value+'-'+month.value+'-'+year.value,
							sex: sex.value,
							requestPOST: true
						}
					})
					.then((response) => {
			    		loadingCircle.classList.remove('turn');
						loadingCircle.classList.remove('center');
				    	loadingCircle.classList.add('no-block');
					    if (response.success) {
							messageSuccess.classList.remove('no-block');
							messageSuccess.innerHTML = response.message;
							form.reset();
					    } else {
							loadingCircle.classList.remove('turn');
							loadingCircle.classList.remove('center');
					    	loadingCircle.classList.add('no-block');
							messageError.firstElementChild.innerHTML = 'Algunos campos tiene datos erroneos.';
							messageError.classList.remove('no-block');
							reportError(user, response.user);
							reportError(email, response.email);
							reportError(password, response.password);
							reportError(repeatPassword, response.repeatPassword);
							reportError(dateGroup, response.date);
							reportError(sex, response.sex);
					    }
					})
					.catch((error) => {
						//console.log(error);
					});
			}, 2000);
			
		} else {
			messageError.firstElementChild.innerHTML = 'Algunos campos tiene datos erroneos.';
			messageError.classList.remove('no-block');
		}
	});
})(window, document);