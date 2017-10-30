'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

export default class Modal extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
		let classes = 'modal ' + this.props.classes;
		return (
			<div className={classes} onClick={this.props.clickEventHandler} id={this.props.id}>
				{this.props.children}
			</div>
		);
	}
}

Modal.propTypes = {
	children: PropTypes.element.isRequired
};

Modal.propTypes = {
	classes: PropTypes.string
};

Modal.propTypes = {
	clickEventHandler: PropTypes.func
};
