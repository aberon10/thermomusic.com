'use strict';
import Ajax from '../Libs/Ajax';

const btnSubscribe = document.getElementById('btn-subscribe');
const tableFree = document.getElementById('table-free');
const containerFormSuscription = document.getElementById('container-form-suscription');
const formSuscription = document.getElementById('form-suscription');

btnSubscribe.addEventListener('click', e => {
	e.preventDefault();
	if (!tableFree.classList.contains('no-block')) {
		tableFree.classList.add('no-block');
		containerFormSuscription.classList.remove('no-block');
	}
});


formSuscription.addEventListener('submit', e => {
	e.preventDefault();

	const user = document.getElementById('user');
	const numberCard = document.getElementById('number-card');
	const securityCode = document.getElementById('security-code');
	const expirationMonth = document.getElementById('expiration-month');
	const expirationYear = document.getElementById('expiration-year');
	const expirationDateError = document.getElementById('expiration-date-error');
	const message = document.getElementById('message');
	const loadingCircle = document.querySelector('.loading-circle');

	message.innerHTML = '';
	loadingCircle.classList.add('center');
	loadingCircle.classList.add('turn');

	window.setTimeout(() => {
		loadingCircle.className = 'loading-circle';
		Ajax.post({
			url: '/user/suscription',
			responseType: 'json',
			data: {
				user: user.value,
				numberCard: numberCard.value,
				securityCode: securityCode.value,
				expirationMonth: expirationMonth.value,
				expirationYear: expirationYear.value
			}
		}).then(response => {
			if (response) {
				message.className = '';

				if (response.success === true) {
					e.target.reset();
					message.classList.add('color-green');
				} else {
					message.classList.add('color-red');
				}

				message.innerHTML = response.message;
				user.nextElementSibling.innerHTML = response.username;
				numberCard.nextElementSibling.innerHTML = response.numberCard;
				securityCode.nextElementSibling.innerHTML = response.securityCode;
				expirationDateError.innerHTML = response.expirationDate;
			}
		}).catch(error => {});
	}, 2000);
});
