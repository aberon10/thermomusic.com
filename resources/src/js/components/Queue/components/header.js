'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// app
import PlaybackQueue from '../../../app/PlaybackQueue/PlaybackQueue';

export default class Header extends React.Component {
	render() {
		return(
			<div className="panel-queuelist__header">
				<div className="panel-headings">
					<h2 className="panel-heading-2">Lista de Espera</h2>
					<h3 className="panel-heading-3" id="info-queue">{PlaybackQueue.getInfoWaitingList()}</h3>
				</div>
				<span className="icon-close  panel-button  panel-button__close" id="close-panel" onClick={this.props.clickEventHandler}></span>
			</div>
		);
	}
}

Header.propTypes = {
	clickEventHandler: PropTypes.func
};
