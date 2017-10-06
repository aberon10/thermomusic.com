'use strict';

// Dependencies
import React from 'react';

class PlayerLeft extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="player__left">
				<div className="player__img">
					<img className="cover-artist" src="" alt=""/>
				</div>
				<div className="track-info">
					<div className="track-info__name">
						<h3></h3>
					</div>
					<div className="track-info__artists">
						<h4></h4>
					</div>
				</div>
			</div>
		);
	}
}

export default PlayerLeft;
