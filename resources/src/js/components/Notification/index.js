'use strict';

import React from 'react';

class Notification extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
		let classes = 'notification  ' + this.props.classes;
		return (
			<div className={classes}
				style={{
					position: 'fixed',
					top: 0,
					left: 0,
					display: 'flex',
					zIndex: 10000,
					justifyContent: 'flex-start',
					alignItems: 'center',
					paddingLeft: 1+'rem',
					width: 100+'%',
					height: 48+'px',
					color: '#fff'
				}}
			>
				<p style={{color: '#fff'}}>{this.props.message}</p>
			</div>
		);
	}
}

export default Notification;
