'use strict';

// Components
import Queue from '../../components/Queue/index';

// app
import TMPlayer from './TMPlayer';
import PlaybackQueue from '../PlaybackQueue/PlaybackQueue';
import TMPlayerElement from './TMPlayerElement';

function getDataOfTracksAndSetIndexTrack(tracks, idNextTrack) {
	let dataTracks = [];

	tracks.forEach((track, index) => {
		let data = JSON.parse(track.dataset.track);

		if (data.id === idNextTrack) {
			PlaybackQueue.indexTrack = index;
		}
		dataTracks.push(data);
	});

	return dataTracks;
}

/**
 * prepareSong
 * Handle the Event by play/pause the track buttons.
 * It is responsible for performing the previous step to the audio playback.
 * @export
 * @param {Object} e
 */
export default function prepareSong(e) {
	let nextTrack = e.target.parentNode.parentNode;
	let tracks = Array.from(nextTrack.parentNode.children);
	let idNextTrack = JSON.parse(nextTrack.dataset.track).id;
	let idCurrentTrack = PlaybackQueue.tracks ? PlaybackQueue.tracks[PlaybackQueue.indexTrack].id : null;

	if (idNextTrack === idCurrentTrack) {
		TMPlayer.playPause();
	} else {
		PlaybackQueue.tracks = getDataOfTracksAndSetIndexTrack(tracks, idNextTrack);
		TMPlayerElement.changeClassOfTheCurrentTrack();

		if (Queue.isVisible()) {
			Queue.updateQueue();
		}

		TMPlayer.init();
	}
}
