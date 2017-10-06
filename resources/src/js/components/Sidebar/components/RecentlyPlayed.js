'use strict';

// Dependencies
import React from 'react';

// Components
import NavListItems from './NavListItems';

class RecentlyPlayed extends React.Component {
	constructor(props) {
		super(props);
		this.status = {
			links: []
		};
	}

	componentDidMount() {
		return;
	}

	render() {
		return (
			<div className="recently-played-group  group">
				<h5 className="recently-played-group__title">ÚLTIMAS REPRODUCCIONES</h5>
				<ul className="nav-list">
					<NavListItems links={this.status.links}/>
				</ul>
			</div>
		);
	}
}

export default RecentlyPlayed;