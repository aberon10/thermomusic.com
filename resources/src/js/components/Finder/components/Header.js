'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

const resetInput = (e) => {
	e.target.value = '';
};

export default class Header extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="panel-queuelist__header">
				<div className="panel-headings">
					<div className="form">
						<div className="input-group">
							<input type="search" className="form-control" placeholder="Buscar..." onKeyUp={this.props.keyUpEventHandler} id="search" autoComplete="off" maxLength="150"/>
						</div>
					</div>
				</div>
				<span className="icon-close  panel-button  panel-button__close" id="close-finder" onClick={this.props.clickEventHandler}></span>
			</div>
		);
	}
}

Header.propTypes = {
	clickEventHandler: PropTypes.func,
	keyUpEventHandler: PropTypes.func
};
