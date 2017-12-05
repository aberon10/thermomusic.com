'use strict';
import Ajax from '../Libs/Ajax';

window.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('form-support');
	form.addEventListener('submit', e => {
		e.preventDefault();
		const email = document.getElementById('support-email');
		const name = document.getElementById('support-name');
		const subject = document.getElementById('support-subject');
		const message = document.getElementById('support-message');
		const msg = document.getElementById('message');
		const loadingCircle = document.querySelector('.loading-circle');

		msg.innerHTML = '';
		loadingCircle.classList.add('center');
		loadingCircle.classList.add('turn');

		window.setTimeout(() => {
			loadingCircle.className = 'loading-circle';
			Ajax.post({
				url: '/home/support',
				responseType: 'json',
				data: {
					email: email.value,
					name: name.value,
					subject: subject.value,
					message: message.value,
				}
			}).then(response => {
				if (response) {
					msg.className = '';

					if (response.success === true) {
						e.target.reset();
						msg.classList.add('color-green');
					} else {
						msg.classList.add('color-red');
					}

					msg.innerHTML = response.msg;
					email.nextElementSibling.innerHTML = response.email !== true ? response.email : '';
					name.nextElementSibling.innerHTML = response.name !== true ? response.name : '';
					subject.nextElementSibling.innerHTML = response.subject !== true ? response.subject : '';
					message.innerHTML = response.message !== true ? response.message : '';
				}
			}).catch(error => {});
		}, 2000);
	});
});
