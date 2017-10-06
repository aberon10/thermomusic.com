'use strict';

import TMPlayer from './TMPlayer';

function RangeSlider() {
	let range = document.getElementById('range-slider'),
		rangeLoading = document.querySelector('.range-slider__loading'),
		iconVolume = document.getElementById('icon-volume'),
		tooltip = document.getElementById('tooltip-volume'),
		dragger = range.children[0],
		draggerWidth = 10,
		down = false,
		rangeWidth,
		rangeLeft;

	range.addEventListener('mousedown', function (e) {
		rangeWidth = this.offsetWidth;
		rangeLeft = this.offsetLeft;
		down = true;
		updateDragger(e);
	});

	document.addEventListener('mousemove', function (e) {
		updateDragger(e);
	});

	document.addEventListener('mouseup', function () {
		tooltip.classList.remove('show-tooltip');
		down = false;
	});

	function updateDragger(e) {
		if (down && e.pageX >= rangeLeft && e.pageX <= (rangeLeft + rangeWidth)) {
			let percentage = Math.round(((e.pageX - rangeLeft) / rangeWidth) * 100);
			let volume = percentage / 100;

			dragger.style.left = e.pageX - rangeLeft - draggerWidth + 'px';
			rangeLoading.style.width = percentage + '%';
			tooltip.innerHTML = percentage + '%';
			tooltip.style.left = percentage - 25 + '%';
			tooltip.classList.add('show-tooltip');
			TMPlayer.audio.volume = volume;

			if (volume === 0) {
				if (iconVolume.classList.contains('icon-volume')) {
					iconVolume.classList.remove('icon-volume');
					iconVolume.classList.add('icon-mute');
					iconVolume.classList.add('mute');
				}
			} else {
				if (iconVolume.classList.contains('icon-mute')) {
					iconVolume.classList.remove('icon-mute');
					iconVolume.classList.remove('mute');
					iconVolume.classList.add('icon-volume');
				}
			}
		}
	}
}

export default RangeSlider;