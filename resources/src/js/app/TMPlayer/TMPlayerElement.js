'use strict';

// Components
import Queue from '../../components/Queue/index';

// app
import PlaybackQueue from '../PlaybackQueue/PlaybackQueue';

// config
import Config from '../../config';
import Advertising from '../Advertising';

export default class TMPlayerElement {
	static loadAllElementsOfThePlayer() {
		TMPlayerElement.elements = {
			player: document.getElementById('player'),
			play: document.getElementById('central-play'),
			secondaryPlay: document.getElementById('secondary-button-play'),
			next: document.getElementById('control-next'),
			prev: document.getElementById('control-previous'),
			random: document.getElementById('control-random'),
			repeat: document.getElementById('control-repeat'),
			nameTrack: document.querySelector('.track-info__name h3'),
			nameArtist: document.querySelector('.track-info__artists h4'),
			imgAlbum: document.querySelector('.cover-artist'),
			secondaryBar: document.getElementById('secondary-bar'),
			primaryBar: document.getElementById('primary-bar'),
			barLoad: document.querySelectorAll('.progress-bar__player'),
			barPlayer: document.querySelector('.progress-bar__loading'),
			currentTime: document.getElementById('current-time'),
			totalTime: document.getElementById('total-time'),
			tooltipBar: document.getElementById('tooltip-bar'),
			rangeSlider: document.getElementById('range-slider'),
			rangeLoading: document.querySelector('.range-slider__loading'),
			tooltipVolume: document.getElementById('tooltip-volume'),
			iconVolume: document.getElementById('button-volume'),
			slider: document.getElementById('range-slider').children[0]
		};
	}
	static showPlayer() {
		let player = document.getElementById('player');
		if (!player.classList.contains('visible')) {
			player.classList.add('visible');
		}
	}

	static changeWidthBarLoad(width) {
		document.getElementById('primary-bar').querySelector('.progress-bar__player').style.width = width + '%';
		document.getElementById('secondary-bar').querySelector('.progress-bar__player').style.width = width + '%';
	}

	static changeWidthBarPlayer(width) {
		document.querySelector('#primary-bar > .progress-bar__loading').style.width = width + '%';
		document.querySelector('#secondary-bar > .progress-bar__loading').style.width = width + '%';
	}

	static setTotalTime(time) {
		document.getElementById('total-time').textContent = time;
	}

	static changeCurrentTime(time) {
		document.getElementById('current-time').textContent = time;
	}

	static setNameTrack(name) {
		document.querySelector('.track-info__name h3').textContent = name;
		document.querySelector('#floating-player .track-info__name > h4').textContent = name;
	}

	static setNameArtist(name) {
		document.querySelector('.track-info__artists h4').textContent = name;
		document.querySelector('#floating-player .track-info__artists > h5').textContent = name;
	}

	static setImageAlbum(src) {
		document.querySelector('#player .cover-artist').src = src;
	}

	static containCSSClass(element, cssClass) {
		return element.classList.contains(cssClass);
	}

	static removeCSSClassIcon(element, cssClass) {
		element.classList.remove(cssClass);
	}
	static addCSSClassIcon(element, cssClass) {
		element.classList.add(cssClass);
	}

	static changeClassOfTheCurrentTrack() {
		let currentTrack = document.querySelector('.tracklist-item.active');
		let containerTracks = document.querySelector('.tracklist-container');

		if (currentTrack) {
			let currentButtonPlay = currentTrack.querySelector('.tracklist-item__icon').firstElementChild;

			currentTrack.classList.remove('active');

			if (!currentButtonPlay.classList.contains('icon-play-2')) {
				currentButtonPlay.classList.remove('icon-pause');
				currentButtonPlay.classList.add('icon-play-2');
			}
		}

		if (containerTracks) {
			let tracks = Array.from(containerTracks.querySelectorAll('.tracklist-item'));
			tracks.forEach((track) => {
				let idTrack = JSON.parse(track.dataset.track).id;
				if (idTrack === PlaybackQueue.tracks[PlaybackQueue.indexTrack].id) {
					track.classList.add('active');
				}
			});
		}
	}
	static changeTheClassOfTheRandomButton() {
		let button = TMPlayerElement.elements.random;
		if (button.classList.contains('active')) {
			button.classList.remove('active');
		} else {
			button.classList.add('active');
			TMPlayerElement.elements.repeat.classList.remove('active');
		}
	}

	static changeTheClassOfTheRepeatButton() {
		let button = TMPlayerElement.elements.repeat;
		if (button.classList.contains('active')) {
			button.classList.remove('active');
		} else {
			button.classList.add('active');
			TMPlayerElement.elements.random.classList.remove('active');
		}
	}

	static changeTheClassOfTheMainPlayButton() {
		let buttonPlay = TMPlayerElement.elements.play.firstChild.classList;
		if (buttonPlay.contains('icon-play-circle')) {
			buttonPlay.remove('icon-play-circle');
			buttonPlay.add('icon-pause');
		}
	}

	static changeTheClassOfTheMainPauseButton() {
		let buttonPause = TMPlayerElement.elements.play.firstChild.classList;
		if (buttonPause.contains('icon-pause')) {
			buttonPause.add('icon-play-circle');
			buttonPause.remove('icon-pause');
		}
	}

	static changeTheClassOfTheSecondaryPlayButton() {
		let buttonPlay = TMPlayerElement.elements.secondaryPlay.firstChild.classList;
		if (buttonPlay.contains('icon-play-2')) {
			buttonPlay.remove('icon-play-2');
			buttonPlay.add('icon-pause');
		}
	}

	static changeTheClassOfTheSecondaryPauseButton() {
		let buttonPause = TMPlayerElement.elements.secondaryPlay.firstChild.classList;
		if (buttonPause.contains('icon-pause')) {
			buttonPause.add('icon-play-2');
			buttonPause.remove('icon-pause');
		}
	}

	static changeTheClassOfTheTrackPlaybackButton() {
		let trackItem = document.querySelector('.tracklist-item.active .tracklist-item__icon > span');

		if (trackItem) {
			if (trackItem.classList.contains('icon-play-2')) {
				trackItem.classList.remove('icon-play-2');
				trackItem.classList.add('icon-pause');
			} else if (!trackItem.classList.contains('icon-play-2')) {
				trackItem.classList.remove('icon-pause');
				trackItem.classList.add('icon-play-2');
			}
		}

	}
	static updateDataOfTheCurrentSongInPlayer() {
		if (PlaybackQueue.adv) {
			TMPlayerElement.setTotalTime(Advertising.audios[Advertising.index].duracion);
			TMPlayerElement.setNameTrack(Advertising.audios[Advertising.index].nombre_publicidad);
			TMPlayerElement.setNameArtist('Publicidad');
			TMPlayerElement.setImageAlbum(Config.urlResource + '/bi/ad.jpg');
		} else {
			TMPlayerElement.setTotalTime(PlaybackQueue.tracks[PlaybackQueue.indexTrack].duration);
			TMPlayerElement.setNameTrack(PlaybackQueue.tracks[PlaybackQueue.indexTrack].trackName);
			TMPlayerElement.setNameArtist(PlaybackQueue.tracks[PlaybackQueue.indexTrack].artist);
			TMPlayerElement.setImageAlbum(Config.urlResource + '/' + PlaybackQueue.tracks[PlaybackQueue.indexTrack].srcAlbum);
		}
	}

	static changeTheClassOfTheButtonVolume() {
		let button = TMPlayerElement.elements.iconVolume.firstChild.classList;
		if (button.contains('icon-volume')) {
			button.remove('icon-volume');
			button.add('icon-mute');
			button.add('mute');
			TMPlayerElement.currentPostitonSlider = TMPlayerElement.elements.slider.style.left;
			TMPlayerElement.currentWidthRangeLoading = TMPlayerElement.elements.rangeLoading.style.width;
			TMPlayerElement.elements.slider.style.left = 0;
			TMPlayerElement.elements.rangeLoading.style.width = 0;
		} else {
			button.remove('icon-mute');
			button.remove('mute');
			button.add('icon-volume');
			TMPlayerElement.elements.slider.style.left = TMPlayerElement.currentPostitonSlider;
			TMPlayerElement.elements.rangeLoading.style.width = TMPlayerElement.currentWidthRangeLoading;
		}
	}
}

TMPlayerElement.elements = null;
TMPlayerElement.currentWidthRangeLoading = 100;
TMPlayerElement.currentPostitonSlider = -70;
