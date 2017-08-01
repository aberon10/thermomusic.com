'use strict';

(function (w, d) {
	var classError = 'has-error';
	var messageError = d.querySelector('.alert-error');
	var messageSuccess = d.querySelector('.alert-success');
	var loadingCircle = d.querySelector('.loading-circle');
	var dateGroup = d.getElementById('date-group');
	var sexGroup = d.getElementById('sex-group');
	var form = d.getElementById('form-register');
	var user = d.getElementById('username');
	var email = d.getElementById('email');
	var password = d.getElementById('password');
	var repeatPassword = d.getElementById('repeat-password');
	var day = d.getElementById('day');
	var month = d.getElementById('month');
	var year = d.getElementById('year');
	var sex = d.getElementById('sex');

	function validateUser(e) {
		var element = e ? e.target : user;
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'username': 'Utilizá entre 4 y 30 letras, números, guiones y puntos.'
		}));
	}

	function validateEmail(e) {
		var element = e ? e.target : email;
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'email': 'El correo ingresado no es valido'
		}));
	}

	function valdiatePassword(e) {
		var element = e ? e.target : password;
		return reportError(element, Validate.resolver(element.value.trim(), {
			'require': 'Campo obligatorio',
			'min_length': [8, 'Utilizá como mínimo 8 caracteres'],
			'max_length': [30, 'Utilizá como máximo 30 caracteres']
		}));
	}

	function validateRepeatPassword(e) {
		var element = e ? e.target : repeatPassword;
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
		var date = day.value + '-' + month.value + '-' + year.value;
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
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		messageError.classList.add('no-block');

		var isValidUser = validateUser();
		var isValidEmail = validateEmail();
		var isValidPass = valdiatePassword();
		var isValidRepeatPass = validateRepeatPassword();
		var isValidSex = validateSex();
		var isValidDate = validateDate();

		if (isValidUser && isValidEmail && isValidPass && isValidRepeatPass && isValidSex && isValidDate) {
			loadingCircle.classList.remove('no-block');
			loadingCircle.classList.add('turn');
			loadingCircle.classList.add('center');
			window.setTimeout(function () {
				Ajax.post({
					url: '/user/register',
					responseType: 'json',
					data: {
						user: user.value,
						email: email.value,
						password: password.value,
						repeatPassword: repeatPassword.value,
						date: day.value + '-' + month.value + '-' + year.value,
						sex: sex.value,
						requestPOST: true
					}
				}).then(function (response) {
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
				}).catch(function (error) {
					//console.log(error);
				});
			}, 2000);
		} else {
			messageError.firstElementChild.innerHTML = 'Algunos campos tiene datos erroneos.';
			messageError.classList.remove('no-block');
		}
	});
})(window, document);