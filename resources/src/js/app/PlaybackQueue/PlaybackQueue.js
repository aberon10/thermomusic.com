'use strict';

// Components
import Queue from '../../components/Queue/index';
import MenuPopUp from '../../components/MenuPopUp/index';

// app
import TMPlayerElement from '../TMPlayer/TMPlayerElement';

// utils
import { totalTimeInStringFormat } from '../utils/Utils';

export default class PlaybackQueue {
	/**
	 * inPlaybackQueue
	 * Check if the song is on the Playback queue
	 *
	 * @static
	 * @param {Number} idTrack
	 * @return {Number|false}
	 * @memberof PlaybackQueue
	 */
	static inQueue(idTrack) {
		let inList = false;
		if (PlaybackQueue.tracks) {
			let i = 0;
			while (i < PlaybackQueue.tracks.length && inList === false) {
				if (PlaybackQueue.tracks[i].id === idTrack) {
					inList = i;
				}
				i++;
			}
		}
		return inList;
	}

	static existQueue() {
		return PlaybackQueue.tracks && PlaybackQueue.tracks.length > 0;
	}

	static _removeTrackTheQueue(index) {
		PlaybackQueue.tracks.splice(index, 1);
	}

	static _addTrackTheQueue(dataTrack) {
		PlaybackQueue.tracks.push(dataTrack);
	}

	// TODO:
	// 1) Mostrar notificación de si se quito/agrego
	/**
	 * updateQueue
	 * Event handler for the button add/remove from waiting list.
	 * @static
	 * @param {Object} e
	 * @memberof PlaybackQueue
	 */
	static updateQueue(e) {
		let dataTrack = JSON.parse(e.target.parentNode.parentNode.dataset.track);
		let index = PlaybackQueue.inQueue(dataTrack.id);

		if (index !== false) {

			if (dataTrack.id === PlaybackQueue.tracks[PlaybackQueue.indexTrack].id) {
				PlaybackQueue.decreaseIndex();
				PlaybackQueue._removeTrackTheQueue(index);
				TMPlayerElement.elements.next.click();
			} else {
				PlaybackQueue._removeTrackTheQueue(index);

				if (Queue.isVisible()) {
					Queue.updateQueue();
				}
			}

		} else {
			PlaybackQueue._addTrackTheQueue(dataTrack);
		}

		sessionStorage.removeItem('id_track');
		MenuPopUp.resetStates();
	}

	static increaseIndex() {
		if (PlaybackQueue.indexTrack >= PlaybackQueue.tracks.length - 1) {
			PlaybackQueue.indexTrack = 0;
		} else {
			PlaybackQueue.indexTrack++;
		}
	}

	static decreaseIndex() {
		if (PlaybackQueue.indexTrack === 0) {
			PlaybackQueue.indexTrack = PlaybackQueue.tracks.length - 1;
		} else {
			PlaybackQueue.indexTrack--;
		}
	}

	// Event handler for the wait list open button
	static callWaitingList(e) {
		e.preventDefault();
		Queue.updateQueue();
	}

	static getInfoWaitingList() {
		let textTotalTracks = PlaybackQueue.tracks.length === 1 ? ' canción ' : ' canciones';
		return PlaybackQueue.tracks.length + textTotalTracks + ' - ' + totalTimeInStringFormat(PlaybackQueue.tracks);
	}
}

PlaybackQueue.tracks = null;
PlaybackQueue.indexTrack = 0;
