'use strict';
export default function displayPlayer(e) {
	let player = document.getElementById('player');
	let floatingButton = document.getElementById('floating-player');

	if (e.target === window && e.target.innerWidth > 1024) {
		if (player.classList.contains('player-closed')) {
			player.classList.remove('player-closed');
		}

		if (floatingButton.classList.contains('floating-player__visible')) {
			floatingButton.classList.remove('floating-player__visible');
		}
	} else if (e.target !== window && window.innerWidth <= 1024) {
		if (player.classList.contains('player-closed')) {
			player.classList.remove('player-closed');
		} else {
			player.classList.add('player-closed');
		}

		if (floatingButton.classList.contains('floating-player__visible')) {
			floatingButton.classList.remove('floating-player__visible');
		} else {
			floatingButton.classList.add('floating-player__visible');
		}
	}
}

window.onresize = displayPlayer;