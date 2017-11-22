'use strict';

window.onload = () => {
	const toggleButton = document.getElementById('bars-menu-web');
	const menu = document.querySelector('.header-top__right');
	const goUp = document.querySelector('.go-up');

	toggleButton.addEventListener('click', e => {
		e.preventDefault();
		menu.classList.toggle('block');
	});

	goUp.addEventListener('click', e => {
		e.preventDefault();
		let scrollStep = -window.scrollY / (500 / 15);
		const interval = window.setInterval(() => {
			if (window.scrollY !== 0)
				window.scrollBy(0, scrollStep);
			else
				window.clearInterval(interval);
		}, 15);
	});

	window.addEventListener('scroll', e => {
		if (window.scrollY > 50) {
			goUp.classList.add('active-go-up');
		} else {
			goUp.classList.remove('active-go-up');
		}
	});
};
