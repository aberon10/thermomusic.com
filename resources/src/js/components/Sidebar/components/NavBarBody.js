'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// Components
import NavListItems from './NavListItems';
import RecentlyPlayed from './RecentlyPlayed';

const links = [
	{
		url: '/user',
		name: 'Explorar'
	},
	{
		url: '/music',
		name: 'Tu Música'
	},
	{
		url: '/recomended',
		name: 'Recomendados'
	},
	{
		url: '/top',
		name: 'Top 10'
	}
];

class NavBarBody extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="nav-bar__body">
				<ul className="nav-list  group">
					<NavListItems 
						links={links}
						typeLink="3"
					/>
				</ul>
				<RecentlyPlayed links={this.props.linksRecentlyArtist}/>
			</div>
		);
	}
}

NavBarBody.defaultProps = {
	linksRecentlyArtist: []
};

NavBarBody.propTypes = {
	linksRecentlyArtist: PropTypes.array.isRequired
};

export default NavBarBody;