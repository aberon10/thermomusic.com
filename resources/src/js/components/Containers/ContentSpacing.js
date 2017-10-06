'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

class ContentSpacing extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return(
			<section className="content-spacing">
				<div className="content-spacing__header">
					<h1 className="content-spacing-title">{this.props.title}</h1>						
				</div>
				<div className="content-spacing__body">
					{this.props.children}
				</div>
			</section>
		);
	}
}

ContentSpacing.defaultProps = {
	title: ''
};

ContentSpacing.propTypes = {
	title: PropTypes.string.isRequired
};

export default ContentSpacing;