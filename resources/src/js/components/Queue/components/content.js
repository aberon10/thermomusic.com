'use strict';

// Dependencies
import React from 'react';
import { Link } from 'react-router-dom';

// app
import PlaybackQueue from '../../../app/PlaybackQueue/PlaybackQueue';
import TMPlayer from '../../../app/TMPlayer/TMPlayer';
import prepareSong from '../../../app/TMPlayer/';
import { getDataTrack } from '../../../app/OptionMenu/OptionMenu';

import {substr} from '../../utils';

// Config
import Config from '../../../config';
import Queue from '../index';

export default class Content extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let listItems = [];

		if (PlaybackQueue.tracks && PlaybackQueue.tracks.length > 0) {
			PlaybackQueue.tracks.forEach((track) => {
				track.playlist = false;
				track.idPlaylist = null;
				let dataTrack = JSON.stringify(track);
				let classNameCardtem = 'card-item';
				let classNameButtonPlay = 'icon-play-2';

				if (PlaybackQueue.tracks[PlaybackQueue.indexTrack].id === track.id) {
					classNameCardtem += '  active';
					classNameButtonPlay = TMPlayer.isPaused() ? 'icon-play-2' : 'icon-pause';
				}

				listItems.push(
					<div className={classNameCardtem} key={track.id} data-track={dataTrack}>
						<div className="card-picture">
							<figure className="thumbnail">
								<img src={Config.urlResource + '/' + track.srcAlbum} alt={track.trackName} />
							</figure>
							<span className={`card-picture__button  ${classNameButtonPlay}`} onClick={prepareSong}></span>
						</div>
						<div className="card-info">
							<Link to="#">
								<h2 className="card-info__heading-2">{substr(track.trackName)}</h2>
							</Link>
							<Link to="#">
								<h3 className="card-info__heading-3">{substr(track.artist)}</h3>
							</Link>
						</div>
						<div className="card-options">
							<span className="icon-ellipsis-h  card-options__button" onClick={getDataTrack}></span>
						</div>
					</div>
				);
			});
		}
		return (
			<div className="panel-queuelist__content">
				<div className="card-list">
					{listItems}
				</div>
			</div>
		);
	}
}
