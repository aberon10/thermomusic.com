'use strict';

// Dependencies
import React from 'react';
import {Link} from 'react-router-dom';
import PlaybackQueue from '../../../app/PlaybackQueue/PlaybackQueue';
class PlayerRight extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="player__right">
				<div className="player-bar__right__inner">
					<div className="extra-controls">
						<a href="#" className="control-button" id="button-playbackqueue" onClick={PlaybackQueue.callWaitingList}>
							<i className="icon-list"></i>
							<span className="tooltip  tooltip-control">Cola de reproducción</span>
						</a>
						<div className="volume-bar">
							<button className="control-button">
								<i className="icon-volume" id="icon-volume"></i>
							</button>
							<div className="range-container">
								<div className="range-slider" id="range-slider"><span className="slider"></span><span className="tooltip  tooltip-volume" id="tooltip-volume">0%</span><div className="range-slider__loading"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default PlayerRight;
