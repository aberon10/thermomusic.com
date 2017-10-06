'use strict';

// app
import TMPlayerElement from './TMPlayerElement';
import RangeSlider from './RangeSlider';
import PlaybackQueue from '../PlaybackQueue/PlaybackQueue';

// Components
import Queue from '../../components/Queue/index';

// Utils
import { timeFormat } from '../utils/Utils';

// config
import Config from '../../config';

const formatAudio = ['audio/mpeg', 'audio/ogg'];

export default class TMPlayer {
	static init() {
		if (TMPlayer.audio === null || TMPlayer.audio === 'undefined') {
			TMPlayer.audio = new Audio();
			if (!TMPlayer.audio.canPlayType(formatAudio[0])) {
				throw new Error('Unsupported audio format');
			}
		}

		TMPlayer.audio.volume = 1;
		TMPlayer.random = false;
		TMPlayer.repeat = false;
		TMPlayer.currentVolume = 1;
		TMPlayerElement.loadAllElementsOfThePlayer();
		TMPlayer.addEventsToTheButtons();
		TMPlayer.start();
		TMPlayer.addEventsAudio();
		TMPlayerElement.showPlayer();
		RangeSlider();
	}
	static start() {
		TMPlayer.audio.src = Config.urlResource + '/' + PlaybackQueue.tracks[PlaybackQueue.indexTrack].src;
		TMPlayer.audio.type = formatAudio[0];
		TMPlayer.playPause();
		TMPlayerElement.updateDataOfTheCurrentSongInPlayer();
	}
	static isPaused() {
		return TMPlayer.audio.paused;
	}
	static playPause() {
		if (TMPlayer.isPaused()) {
			let playPromise = TMPlayer.audio.play();

			playPromise.then(() => {
				TMPlayerElement.changeTheClassOfTheMainPlayButton();
				TMPlayerElement.changeTheClassOfTheSecondaryPlayButton();
				TMPlayerElement.changeTheClassOfTheTrackPlaybackButton();
			}).catch((error) => {
				console.log(error);
			});
		} else {
			TMPlayer.audio.pause();
			TMPlayerElement.changeTheClassOfTheMainPauseButton();
			TMPlayerElement.changeTheClassOfTheSecondaryPauseButton();
			TMPlayerElement.changeTheClassOfTheTrackPlaybackButton();
		}

		// if waiting list is visible, it is updated
		if (Queue.isVisible()) {
			Queue.updateQueue();
		}
	}

	static load() {
		let loadTime = TMPlayer.audio.buffered;
		if (loadTime.length > 0) {
			let percentage = (loadTime.end(0) * 100) / TMPlayer.audio.duration;
			TMPlayerElement.changeWidthBarLoad(percentage);
		}
	}

	static duration() {
		let currentTime = parseInt(TMPlayer.audio.currentTime);
		let totalTime = TMPlayer.audio.duration;
		let width = (currentTime * 100) / totalTime;

		TMPlayerElement.changeWidthBarPlayer(width);
		TMPlayerElement.changeCurrentTime(timeFormat(currentTime));
	}

	static nextTrack() {
		if (this === TMPlayer.audio) {
			if (TMPlayer.random) {
				PlaybackQueue.indexTrack = Math.floor((Math.random() * PlaybackQueue.tracks.length));
			} else if (!TMPlayer.repeat) {
				PlaybackQueue.increaseIndex();
			}
		} else if (this === TMPlayerElement.elements.next) {
			PlaybackQueue.increaseIndex();
		}

		TMPlayerElement.changeClassOfTheCurrentTrack();
		TMPlayer.start();
	}

	static previousTrack() {
		if (this === TMPlayerElement.elements.prev) {
			PlaybackQueue.decreaseIndex();
		}

		TMPlayerElement.changeClassOfTheCurrentTrack();
		TMPlayer.start();
	}

	static randomTrack() {
		!TMPlayer.random;
		TMPlayer.repeat = false;
		TMPlayerElement.changeTheClassOfTheRandomButton();
	}

	static repeatTrack() {
		!TMPlayer.repeat;
		TMPlayer.random = false;
		TMPlayerElement.changeTheClassOfTheRepeatButton();
	}

	static jumpsOnProgressBar(e) {
		if (!TMPlayer.audio.ended) {
			let width = null;

			if (e.target === TMPlayerElement.elements.primaryBar || e.target.parentNode === TMPlayerElement.elements.primaryBar) {
				width = e.pageX - TMPlayerElement.elements.primaryBar.offsetLeft;
				TMPlayer.audio.currentTime = (width * TMPlayer.audio.duration) / TMPlayerElement.elements.primaryBar.offsetWidth;
			} else if (e.target === TMPlayerElement.elements.secondaryBar || e.target.parentNode === TMPlayerElement.elements.secondaryBar) {
				width = e.pageX - TMPlayerElement.elements.secondaryBar.offsetLeft;
				TMPlayer.audio.currentTime = (width * TMPlayer.audio.duration) / TMPlayerElement.elements.secondaryBar.offsetWidth;
			}
		}
	}

	static error() {
		/*if (TMPlayer.audio.error.code === 4) {
			throw new Error('¡Error! al cargar archivo, el formato no es soportado por el navegador');
		} else {
			throw new Error('¡Error! Algo salió mal');
		}*/
	}

	static mute() {
		if (TMPlayer.audio.volume === 0) {
			TMPlayer.audio.volume = TMPlayer.currentVolume;
		} else {
			TMPlayer.currentVolume = TMPlayer.audio.volume;
			TMPlayer.audio.volume = 0;
		}

		TMPlayerElement.changeTheClassOfTheButtonVolume();
	}

	static showTooltipBar(e) {
		let barWidth = e.target.offsetWidth;
		let barLeft = e.target.offsetLeft;

		if (e.pageX >= barLeft && e.pageX <= (barLeft + barWidth)) {
			TMPlayerElement.elements.tooltipBar.innerHTML = timeFormat(((e.pageX - barLeft) * TMPlayer.audio.duration) / barWidth);
			TMPlayerElement.elements.tooltipBar.style.left = Math.round(((e.pageX - barLeft) / barWidth) * 100) + '%';
			TMPlayerElement.elements.tooltipBar.classList.add('show-tooltip');
		}
	}

	static hideTooltipBar() {
		TMPlayerElement.elements.tooltipBar.classList.remove('show-tooltip');
	}

	static addEventsAudio() {
		TMPlayer.audio.addEventListener('loadedmetadata', TMPlayer.load);
		TMPlayer.audio.addEventListener('progress', TMPlayer.load);
		TMPlayer.audio.addEventListener('timeupdate', TMPlayer.duration);
		TMPlayer.audio.addEventListener('ended', TMPlayer.nextTrack);
		TMPlayer.audio.addEventListener('error', TMPlayer.error);
	}

	static addEventsToTheButtons() {
		TMPlayerElement.elements.play.addEventListener('click', TMPlayer.playPause);
		TMPlayerElement.elements.secondaryPlay.addEventListener('click', TMPlayer.playPause);
		TMPlayerElement.elements.next.addEventListener('click', TMPlayer.nextTrack);
		TMPlayerElement.elements.prev.addEventListener('click', TMPlayer.previousTrack);
		TMPlayerElement.elements.random.addEventListener('click', TMPlayer.randomTrack);
		TMPlayerElement.elements.repeat.addEventListener('click', TMPlayer.repeatTrack);
		TMPlayerElement.elements.primaryBar.addEventListener('click', TMPlayer.jumpsOnProgressBar);
		TMPlayerElement.elements.iconVolume.addEventListener('click', TMPlayer.mute);
		TMPlayerElement.elements.primaryBar.addEventListener('mousemove', TMPlayer.showTooltipBar);
		TMPlayerElement.elements.primaryBar.addEventListener('mouseout', TMPlayer.hideTooltipBar);
		TMPlayerElement.elements.secondaryBar.addEventListener('click', TMPlayer.jumpsOnProgressBar);
	}
}

TMPlayer.audio = null;
