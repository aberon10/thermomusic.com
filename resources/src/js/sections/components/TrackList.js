'use strict';

// Dependencies
import React from 'react';

// app
import prepareSong from '../../app/TMPlayer/';
import TMPlayer from '../../app/TMPlayer/TMPlayer';
import PlaybackQueue from '../../app/PlaybackQueue/PlaybackQueue';
import {getDataTrack} from '../../app/OptionMenu/OptionMenu';


export default class TrackList extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			tracks: []
		};
	}

	createTrackList() {
		let tracks = [];
		let data = Array.prototype.slice.call(this.props.data);

		data.forEach((item) => {
			let classNameTracklistItem = 'tracklist-item';
			let classNameButtonPlay = 'icon-play-2';
			let trackInfo = JSON.stringify({
				id: item.id,
				src: item.src,
				duration: item.duration,
				trackName: item.trackName,
				artist: item.artist,
				srcAlbum: item.srcAlbum,
			});

			// compruebo si hay canciones en la "Lista de Espera"
			if (PlaybackQueue.tracks && PlaybackQueue.tracks.length > 0) {

				if (PlaybackQueue.tracks[PlaybackQueue.indexTrack].id === item.id) {
					classNameTracklistItem += '  active';
					classNameButtonPlay = TMPlayer.isPaused() ? 'icon-play-2' : 'icon-pause';
				}
			}

			tracks.push(
				<div className={classNameTracklistItem} key={item.id} data-track={trackInfo}>
					<div className="tracklist-item__icon" onClick={prepareSong}>
						<span className={classNameButtonPlay}></span>
					</div>
					<div className="tracklist-item__name">
						<span className="track-name">{item.trackName}</span>
					</div>
					<div className="tracklist-item__icon" onClick={getDataTrack}>
						<span className="icon-ellipsis-h"></span>
					</div>
					<div className="tracklist-item__icon  add-favorit">
						<span className="icon-heart"></span>
					</div>
					<div className="tracklist-item__duration">{item.duration}</div>
				</div>
			);
		});

		this.setState({tracks: tracks});
	}

	componentDidMount() {
		this.createTrackList();
	}

	render() {
		return (
			<div className="tracklist-container">
				{this.state.tracks}
			</div>
		);
	}
}
