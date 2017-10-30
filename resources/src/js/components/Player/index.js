'use strict';

// Dependencies
import React from 'react';

// Components
import PlayerLeft from './components/PlayerLeft';
import PlayerCenter from './components/PlayerCenter';
import PlayerRight from './components/PlayerRight';

// animation
import displayPlayer from './animation';

export default class Player extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="player-container">
				<div className="player" id="player">
					<div className="player__menu">
						<button className="control-button" id="close-player" onClick={displayPlayer}><i className="icon-arrow-left"></i></button>
					</div>
					<PlayerLeft />
					<PlayerCenter />
					<PlayerRight />
				</div>
			</div>
		);
	}
}
