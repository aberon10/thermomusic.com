'use strict';

// Dependencies
import React from 'react';

class PlayerCenter extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="player__center">
				<div className="player-controls">
					<div className="player-controls__buttons">
						<button className="control-button" id="control-random">
							<i className="icon-random"></i>
							<span className="tooltip  tooltip-control">Modo aleatorio</span>
						</button>
						<button className="control-button" id="control-previous">
							<i className="icon-previous"></i>
							<span className="tooltip  tooltip-control">Anterior canción</span>
						</button>
						<button className="control-button" id="central-play">
							<i className="icon-play-circle  control-play"></i>
						</button>
						<button className="control-button" id="control-next">
							<i className="icon-next"></i>
							<span className="tooltip  tooltip-control">Siguiente canción</span>
						</button>
						<button className="control-button" id="control-repeat">
							<i className="icon-loop  no-margin"></i>
							<span className="tooltip  tooltip-control">Repetir canción</span>
						</button>
					</div>
				</div>
				<div className="playback-bar">
					<div className="playback-bar__progress-time" id="current-time"></div>
					<div className="progress-bar" id="primary-bar">
						<div className="progress-bar__loading"></div>
						<div className="progress-bar__player"></div>
						<span className="progress-bar__tooltip  tooltip" id="tooltip-bar">00:00</span>
					</div>
					<div className="playback-bar__progress-time" id="total-time"></div>
				</div>
			</div>
		);
	}
}

export default PlayerCenter;
