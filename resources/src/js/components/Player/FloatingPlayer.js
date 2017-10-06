'use strict';

import React from 'react';

import togglePlayer from './animation';
export default class FloatingPlayer extends React.Component {
	render() {
		return(
			<div className="floating-player" id="floating-player">
				<div className="floating-player__left">
					<button className="control-button  toggle-button-player" id="open-player" onClick={togglePlayer}>
						<i className="icon-arrow-up"></i>
					</button>
				</div>
				<div className="floating-player__center">
					<div className="track-info">
						<div className="track-info__name">
							<h4>Album</h4>
						</div>
						<div className="track-info__artists">
							<h5>Artista</h5>
						</div>
					</div>
				</div>
				<div className="floating-player__right">
					<button className="control-button  floating-button-play" id="secondary-button-play">
						<i className="icon-play-2"></i>
					</button>
				</div>
				<div className="playback-bar">
					<div className="progress-bar" id="secondary-bar">
						<div className="progress-bar__loading"></div>
						<div className="progress-bar__player"></div>
					</div>
				</div>
			</div>
		);
	}
}
