'use strict';
import Ajax from '../Libs/Ajax';

window.addEventListener('DOMContentLoaded', () => {
	document.getElementById('form-forgotpassword').addEventListener('submit', e => {
		e.preventDefault();
		const user = document.getElementById('username');
		const message = document.getElementById('message');
		const loadingCircle = document.querySelector('.loading-circle');

		message.innerHTML = '';
		loadingCircle.classList.add('center');
		loadingCircle.classList.add('turn');

		window.setTimeout(() => {
			loadingCircle.className = 'loading-circle';
			Ajax.post({
				url: '/user/forgotpassword',
				responseType: 'json',
				data: {user: user.value}
			}).then(response => {
				if (response) {
					message.className = '';

					if (response.success === true) {
						e.target.reset();
						message.classList.add('color-green');
					} else {
						message.classList.add('color-red');
					}

					message.innerHTML = response.msg;
					user.nextElementSibling.innerHTML = response.user;
				}
			}).catch(error => {});
		}, 2000);
	});
});
