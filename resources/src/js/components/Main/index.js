'use strict';

// Dependencies
import React from 'react';

class MainContent extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="main-content">
				<div className="ed-container  full  no-padding">
					<div className="ed-item  full  no-padding">
						{this.props.children}
					</div>
				</div>
			</div>
		);		
	}
}

export default MainContent;